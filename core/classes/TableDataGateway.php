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
* @copyright � 2010 Dobrosite ltd.
*/

if (!defined('PATH')){ exit; }



class TableDataGateway 
{
	public $table = "";
	public $primaryKey = "";
	public $db;
	
	public $orderBy = "";

	public $fields = false;

	
	public $siteId = 0;

	public $useSiteId = false;
	public $useAccountId = false;
	

	var $engine  = "ENGINE=InnoDB DEFAULT CHARSET=utf8";

	public function __construct(
		
		$siteId = false
		
	)
	{
		//TODO: make tables prefixes
		if (empty($this->primaryKey))
		{
			$this->primaryKey = str_replace("cody_", "", $this->table)."_id";
		}

		$this->db = getDB();
		
		if ($siteId !== false)
		{
			$this->siteId = intval($siteId);
                        //TODO: adjust me
                        $this->accountId = $this->db->one("SELECT `account_id` FROM `cody_site` WHERE `site_id` = '".(int)$siteId."'");
		}
		else
		{
			$this->siteId = Site::id();
                        $this->accountId = Site::accountId();
		}
		
	}

	public function constructSetCondition($data, $isAdd = false, $result = "SET ")
	{
                $fields = !isset($this->fields[0]) ? array_keys($this->fields) : $this->fields;
            
		if (is_array($fields) && in_array($this->table."_description", $fields) && !isset($data[$this->table."_description"]) && $isAdd)
		{
			$data[$this->table."_description"] = '';
		}

		
		if ($isAdd && $this->useSiteId)
		{
			$data["site_id"] = intval($this->siteId);
		}

		if ($isAdd && $this->useAccountId && !isset($data["account_id"]))
		{
			$data["account_id"] = intval($this->accountId);
		}
		

		$first = true;
		foreach ($data as $key=>$value)
		{
			if (is_array($fields) && !in_array($key, $fields))
			{
				continue;
			}

			if ($first)
				$first = false;
			else
				$result .= ", ";

			$result .= "`".$key . "` = '".$this->db->escape($value)."'";
		}
		if ($first) return false;

		return $result;
	}

	public function constructSelectFields()
	{
		if (empty($this->selectMode) || $this->selectMode == "full" || !isset($this->selectModes[$this->selectMode])) return "*";

		return $this->selectModes[$this->selectMode];
	}
	
/**
 * Формирует часть SQL-запроса, проверяющего равенство поля $field значениям или значению в $needle.
 * Если $needle строка, то формируется обычное сравнение
 * Если $needle массив, то формируется сравнение через IN с элементами массива $needle
 * @param string $field поле которое необходимо проанализировать
 * @param string/array $needle значения для сравнения c $field
 * @return string строка частью SQL-запроса
 */
	public function constructByCondition($field, $needle)
	{
		$field = $this->db->escape($field);
		
		$cond = $field;

		if (is_array($needle))
		{
			$cond .= " IN (";
			$first = true;
			if ($needle)
			{
				foreach ($needle as $n)
				{
					if (!$first) $cond .= ", ";
					$cond .= "'".$this->db->escape($n)."'";
					$first = false;
				}
			}
			else
			{
				$cond .= "''";
			}
			$cond .= ")";
		}
		else
		{
			$cond .= " = '".$this->db->escape($needle)."'";
		}

		return $cond;
	}

	
	public function getBySiteAndAccount($sep = "AND")
	{
		$cond = "";
		if ($this->useSiteId) $cond .= " ".$sep." `".$this->table."`.`site_id` = '".intval($this->siteId)."'";
		if ($this->useAccountId) $cond .= " ".$sep." `".$this->table."`.`account_id` = '".intval($this->accountId)."'";
		return $cond;
	}
	

/**
* Добавляет новую запись в таблицу из массива data
* @param string $data данные для вставки
* @return int идентификтор добавленной строки
*/
	public function add($data = array())
	{
		$this->db->query($q = "INSERT INTO `".$this->table."` ".$this->constructSetCondition($data, true));
		return $this->db->insertId();
	}

/**
* Заменяет в таблице строку из массива data.
* @param string $data данные, которые будут вставлены в таблицу
* @return int индентификатор добавленной строки
*/
	public function put($data)
	{
		$this->db->query("
			INSERT INTO `".$this->table."` ".$this->constructSetCondition($data, true)."
			ON DUPLICATE KEY UPDATE ".$this->constructSetCondition($data, true, "")."
		");
		return $this->db->insertId();
	}

/**
* Редактирует строчку в таблице
* @param integer $id идентификатор строчки
* @param string $data данные строки
* @return boolean успешно ли выполнился запрос
*/
	public function edit($id, $data)
	{
		$id = intval($id);
		return $this->db->query("UPDATE `".$this->table."` ".$this->constructSetCondition($data)." WHERE `".$this->table."`.`".$this->primaryKey."` = '".$id."'".$this->getBySiteAndAccount());
	}

/**
* Удаляет строчку из таблицы
* @param integer $id
* @return boolean
*/
	public function remove($id)
	{
		$id = intval($id);
		return $this->db->query("DELETE FROM `".$this->table."` WHERE `".$this->table."`.`".$this->primaryKey."` = '".$id."'".$this->getBySiteAndAccount());
	}

/**
* Удалить из таблицы те строки, в которых указаные поля field равны needle
* @param string $field поля которые нужно сравнить
* @param string $needle значяения которые будут сопоставленны с field
* @return void
*/
	public function removeBy($field, $needle)
	{
		return $this->db->query("DELETE FROM `".$this->table."` WHERE ".$this->constructByCondition($field, $needle).$this->getBySiteAndAccount());
	}

/**
* Удалить из таблицы записи с идентификаторами из массива $ids
* @param array $ids
* @return void
*/
	public function clear($ids)
	{
		foreach ($ids as $k => $id) $ids[$k] = intval($ids[$k]);
		
		return $this->db->query("DELETE FROM `".$this->table."` WHERE `".$this->table."`.`".$this->primaryKey."` IN ('".join("', '", $ids)."')".$this->getBySiteAndAccount());
	}

/**
* Получить все записи из таблицы с идентификаторами из массива $ids
* @param array $ids
* @return array
*/
	public function items($ids)
	{
		if (!is_array($ids) || count($ids) == 0) return false;

		foreach ($ids as $k => $id) $ids[$k] = intval($ids[$k]);

		return $this->db->table("SELECT * FROM `".$this->table."` WHERE `".$this->table."`.`".$this->primaryKey."` IN ('".join("', '", $ids)."')".$this->getBySiteAndAccount().$this->getOrderBy());
	}

/**
* Получить строку из таблицы по первичному ключу
* @param integer $id
* @return array
*/
	public function get($id)
	{
		$id = intval($id);
		$row = $this->db->row("SELECT * FROM `".$this->table."` WHERE `".$this->table."`.`".$this->primaryKey."` = '".$id."'".$this->getBySiteAndAccount()." LIMIT 1");
		return $row;
	}
/**
* Получить строку из таблицы, удовлетворяющую сравнению поля $field со значением или значениями в $needle
* @param  string $field
* @param  string $needle
* @return array
*/	
	public function getBy($field, $needle)
	{
		$field = $this->db->escape($field);
		$needle = $this->db->escape($needle);

		$row = $this->db->row("SELECT * FROM `".$this->table."` WHERE `".$this->table."`.`".$field."` = '".$needle."'".$this->getBySiteAndAccount()." LIMIT 1");
		return $row;
	}

/**
* Получить последнюю добавленную строчку из таблицы, удовлетворяющую сравнению поля $field со значением или значениями из $needle
* @param string $field
* @param string $needle
* @return array На выходе строка для текущей таблицы, где поля field = needle
*/
	public function getNewBy($field, $needle)
	{
		$field = $this->db->escape($field);
		$needle = $this->db->escape($needle);
		return $this->db->row("SELECT * FROM `".$this->table."` WHERE `".$this->table."`.`".$field."` = '".$needle."'".$this->getBySiteAndAccount()." ORDER BY ".($this->created?"created":"id")." DESC LIMIT 1");
	}

/**
* Найти строчки, соответствующие идентификаторам из массива $ids
* @param array $ids
* @return array
*/
	public function find($ids)
	{
		$list = $this->db->table("SELECT * FROM `".$this->table."` WHERE `".$this->table."`.`".$this->primaryKey."` IN('".join("','",$ids)."')".$this->getBySiteAndAccount());
		return $list;
	}
/**
* Получить все записи из таблицы
* @return array 
*/
	public function findAll()
	{
		return $this->db->table("SELECT * FROM `".$this->table."` WHERE 1 ".$this->getBySiteAndAccount().$this->getOrderBy());
	}

        public function findRandom($paging = false)
	{
		$this->setOrderBy(" RAND()");
		$ids = $this->findAllIds($paging);
		$paging->setTotal($this->reportMaxId());
		$ids = $this->page($ids);
		return $this->items($ids);
	}
	
	public function findNew($paging = false)
	{
		$this->setOrderBy($this->table.".".$this->primaryKey." DESC");
		$ids = $this->findAllIds($paging);
		$paging->setTotal($this->reportMaxId());
		$ids = $this->page($ids);
		return $this->items($ids);
	}
		
	public function findNewBy($field, $needle, $paging = false)
	{
		$this->setOrderBy($this->table.".".$this->primaryKey." DESC");
		$ids = $this->findIdsBy($field, $needle);
		$paging->setTotal($this->reportMaxId());
		$ids = $this->page($ids);
		return $this->items($ids);
	}
/**
* Получить все идентификаторы из таблицы
* @param Paging $paging
* @return array
*/	
	public function findAllIds($paging = false)
	{
		return $this->db->col("SELECT ".$this->primaryKey." FROM ".$this->table." WHERE 1 ".$this->getBySiteAndAccount().$this->getOrderBy().($paging?(" LIMIT ".$paging->getStart().",".$paging->getCount()):""));
	}
/**
* Получить все записи из таблицы, поле $field которых соответствует $needle
* @param string $field
* @param string $needle
* @return array
*/	
	public function findBy($field, $needle, $paging = false)
	{
		return $this->db->table("SELECT * FROM `".$this->table."` WHERE ".$this->constructByCondition($field, $needle).$this->getBySiteAndAccount().$this->getOrderBy().($paging?(" LIMIT ".$paging->getStart().",".$paging->getCount()):""));
	}
/**
* Получить идентификаторы всех записей из таблицы, поле $field которых соответствует $needle
* @param string $field
* @param string $needle
* @return array
*/	
	public function findIdsBy($field, $needle)
	{
		return $this->db->col("SELECT ".$this->primaryKey." FROM `".$this->table."` WHERE ".$this->constructByCondition($field, $needle).$this->getBySiteAndAccount()." ".$this->getOrderBy());
	}

/**
* Получить количество записей в таблице
* @return integer
*/
	public function reportCount()
	{
		return $this->db->one("SELECT count(*) FROM ".$this->table);
	}
/**
* Получить минимальный идентификатор в таблице
* @return integer
*/
	public function reportMinId()
	{
		return $this->db->one("SELECT min(".$this->primaryKey.") FROM ".$this->table);
	}
/**
* Получить максимальный идентификатор в таблице
* @return integer
*/
	public function reportMaxId()
	{
		return $this->db->one("SELECT max(".$this->primaryKey.") FROM ".$this->table);
	}
/**
* Получить идентификатор таблицы для записи, поле $field которой соответствует $needle
* @param string $field
* @param string $needle
* @return integer
*/	
	public function reportIdBy($field, $needle)
	{
		$field = $this->db->escape($field);
		$needle = $this->db->escape($needle);
		return $this->db->one("SELECT ".$this->primaryKey." FROM `".$this->table."` WHERE `".$field."` = '".$needle."'".$this->getBySiteAndAccount()." LIMIT 1");
	}

/**
* Получить количество записей в таблице, поле $field которых соответствует $needle
* @param string $field
* @param string $needle
* @return integer
*/	
	public function reportCountBy($field, $needle)
	{
		$field = $this->db->escape($field);
		$needle = $this->db->escape($needle);
		return $this->db->one("SELECT count(*) FROM `".$this->table."` WHERE `".$this->table."`.`".$field."` = '".$needle."'".$this->getBySiteAndAccount());
	}

/**
* Узнать, существует ли запись с идентификатором $id
* @param mixed $id
* @return boolean
*/	
	public function reportExists($id)
	{
		$id = intval($id);
		return $this->db->one("SELECT count(*) FROM `".$this->table."` WHERE `".$this->table."`.`".$this->primaryKey."` = '".$id."'".$this->getBySiteAndAccount()." LIMIT 1");
	}

	
/**
* Узнать, существуют ли записи с идентификатором $id в таблице для любого сайта, кроме текущего
* @param integer $id
* @return boolean
*/
	public function reportAnotherSiteExists($id)
	{
		$id = intval($id);
		$siteId = intval($this->siteId);
		return $this->db->one("SELECT count(*) FROM `".$this->table."` WHERE `".$this->table."`.`".$this->primaryKey."` = '".$id."' AND `".$this->table."`.`site_id` != '".intval($siteId)."' LIMIT 1");
	}
	
/**
* Разбить массив идентификаторов на страницы в соотвествии с $paging
* @param Paging $paging
* @return array
*/
	protected function page($ids, $paging = false)
	{
		if (!$paging) return $ids;
		
		$paging->setTotal(count($ids));

		return array_slice($ids, $paging->getStart(), $paging->getCount());
	}
/**
* Устанавливает сортировку
* @param string $orderBy тип сортировки
* @return void
*/
	protected function setOrderBy($orderBy)
	{
		$this->orderBy = $orderBy;
	}
/**
* Возврашает часть SQL-запроса, отвечающего за сортировку
* @return string
*/
	protected function getOrderBy()
	{
		if (empty($this->orderBy))
			return '';

		return " ORDER BY ".$this->orderBy;
	}
/**
* Сбрасывает сортировку
* @return void
*/
	protected function clearOrderBy()
	{
		$this->orderBy = "";
	}
/**
* Блокирует таблицы для данного потока
* @param string $mode
* @return void
*/
	
	public function lock($mode = '')
	{
		if (empty($this->table)) return false;
		
		$this->db->query('LOCK TABLES '.$this->table." ".$mode);
	}
	
/**
* Снимает блокировку таблиц
* @return void
*/
	public function unlock()
	{
		$this->db->query('UNLOCK TABLES');
	}

	
}
