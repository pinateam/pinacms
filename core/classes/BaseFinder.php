<?php
/*
* PinaCMS
*
* THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
* "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
* LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
* A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
* OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
* SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
* LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
* DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
* THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
* (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
* OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*
* @copyright © 2010 Dobrosite ltd.
*/
if (!defined('PATH')){ exit; }


class BaseFinder
{
	private $fields  = array();
	private $from    = '';
	private $joins   = array();
	private $where   = array();
	public $groupby = array();
	private $orderby = array();
	private $limitStart = 0;
	private $limitCount = 0;
	
	protected function clear()
	{
		$this->fields  = array();
		$this->from    = '';
		$this->joins   = array();
		$this->where   = array();
		$this->groupby = array();
		$this->orderby = array();
		$this->limitStart = 0;
		$this->limitCount = 0;
	}
	
	protected function addField($tableField)
	{
		$this->fields[] = $tableField;
	}
	
	protected function setFrom($table)
	{
		$this->from = $table;
	}
	
	protected function addJoin($type, $table, $fields)
	{
		$this->joins[$type][$table] = $fields;
	}
	
	protected function addWhere($condition)
	{
		$this->where[] = $condition;
	}
	
	protected function setGroupBy($table, $field)
	{
		$this->groupby[$table] = $field;
	}
	
	protected function addOrderBy($orderby)
	{
		if (empty($orderby)) return;
		$this->orderby[] = $orderby;
	}
	
	public function setLimit($start, $count)
	{
		$this->limitStart = $start;
		$this->limitCount = $count;
	}

	protected function setPaging($paging)
	{
		$limitStart = intval($paging->getStart());
		$limitCount = intval($paging->getCount());
		$this->setLimit($limitStart, $limitCount);
	}

	protected function sphinxsearch($string, $subject)
	{
		if (!defined("SPHINXSEARCH_HOST") || !defined("SPHINXSEARCH_PORT")) return false;

		include_once PATH_LIB."/sphinxsearch/sphinxapi.php";

		$cl = new SphinxClient();
		$cl->SetServer(SPHINXSEARCH_HOST, SPHINXSEARCH_PORT);

		$cl->SetMatchMode(SPH_MATCH_ANY);
		$cl->SetLimits(0, 1000);

		$result = $cl->Query("*".$string."*", 
			SPHINXSEARCH_PREFIX?(SPHINXSEARCH_PREFIX."_".$subject):$subject
		);

		if ($result === false)
		{
			return false;
		}

		if ( $cl->GetLastWarning() ) {
			echo "WARNING: " . $cl->GetLastWarning() . "\n";
		}

		if (empty($result["matches"]))
		{
			return false;
		}

		return array_keys($result["matches"]);
	}
	
	/**
	 *
	 * Объединение fields, joins и where с аналогичными массивами расширений
	 *
	 * array $extensions - массив объектов класса ExtendFinder
	 * bool $reportCount - если равен true, не добавлять $fields
	 *
	 */
	protected function addExtensions($extensions, $reportCount = false)
	{
		if (!is_array($extensions)) return;
	
		// Цикл по объектам расширений
		foreach ($extensions as $extension)
		{
			// Пропускаем ошибочный объект
			if (get_parent_class($extension) != __CLASS__) continue;
			
			if (!$reportCount)
			{
				// Соединяем массив $this->fields с массивом fields расширения
				$this->fields = array_merge($this->fields, $extension->fields);
			}
			
			// Соединяем массив $this->joins с массивом joins расширения
			$this->joins = array_merge_recursive($this->joins, $extension->joins);
			
			// Соединяем массив $this->where с массивом where расширения
			$this->where = array_merge($this->where, $extension->where);
		}
	}

	protected function extractTableLink($table)
	{
		if (strpos($table, " ") > 0) return strstr($table, " ");

		return $table;
	}
	
	/**
	 *
	 * Конструирование SELECT-запроса
	 *
	 * bool $reportCount - если равен true, нужно выбрать COUNT(*)
	 *
	 * Функция возвращает SQL-запрос или пустую строку при возникновении ошибки
	 *
	 */
	protected function constructSelect($reportCount = false)
	{
		$sql = 'SELECT ';
		
		// Поля выборки
		$flds = array();
		
		if ($reportCount)
		{
			$keys = array_keys($this->groupby);
			$vals = array_values($this->groupby);

			if (!empty($keys[0]) && !empty($vals[0]))
			{
				$table = $keys[0];
				$field = $vals[0];
				$flds[] = 'COUNT(DISTINCT '.$table.'.'.$field.')';
			}
			elseif (is_string($reportCount))
			{
				$flds[] = 'COUNT('.$reportCount.')';
			}
			else
			{
				$flds[] = 'COUNT(*)';
			}
		}
		else
		{
			$flds = $this->fields;
		}
		
		$flds = join(', ', $flds);
		
		if ($flds == '') return '';
		
		$sql .= $flds;
		
		// Главная таблица выборки
		if ($this->from == '') return '';
		
		$sql .= ' FROM '.$this->from;
		
		// JOIN'ы
		foreach ($this->joins as $type => $joins)
		{
			$type = strtoupper($type);
			
			if ($type != 'LEFT' && $type != 'INNER') return '';
			
			foreach ($joins as $table => $fields)
			{
				if ($table == '') return '';
				
				$sql .= " $type JOIN $table ON ";
				
				$ons = array();
				
				foreach ($fields as $field => $val)
				{
					if ($field == '') return '';

					$op = '=';

					if (is_array($val) && !empty($val[0]) && !empty($val[1]) && in_array($val[0], array('!=', '=', '>', '<', '<>')))
					{
						$op = $val[0];
						$val = $val[1];
					}
					
					$on = $this->extractTableLink($table).".$field $op ";
					
					if (is_array($val))
					{
						$keys = array_keys($val);
						$vals = array_values($val);
						
						if (empty($keys[0]) || empty($vals[0])) return '';
						
						$on .= $keys[0].'.'.$vals[0];
					}
					else
					{
						$on .= "'$val'";
					}
					
					$ons[] = $on;
				}
				
				$sql .= join(' AND ', $ons);
			}
		}
		
		// Условия WHERE
		$wheres = array();
		
		foreach ($this->where as $where)
		{
			if (empty($where)) continue;
			
			$wheres[] = '('.$where.')';
		}
		
		$wheres = join(' AND ', $wheres);
		
		if ($wheres != '') $sql .= ' WHERE '.$wheres;
		
		// GROUP BY
		$keys = array_keys($this->groupby);
		$vals = array_values($this->groupby);
		
		if (!$reportCount)
		{
			if (!empty($keys[0]) && !empty($vals[0]))
			{
				$table = $keys[0];
				$field = $vals[0];

				$sql .= " GROUP BY $table.$field";
			}

			// ORDER BY
			if (!empty($this->orderby))
			{
				$sql .= ' ORDER BY '.join(', ', $this->orderby);
			}
			
			// LIMIT
			if ($this->limitCount > 0)
			{
				$sql .= ' LIMIT '.$this->limitStart.', '.$this->limitCount;
			}
		}
		
		//$this->clear();
		
		return $sql;
	}
	
	// Извлечение одного объекта
	//protected function getOne() {}
	
	// Извлечение списка объектов
	//protected function getList() {}
}