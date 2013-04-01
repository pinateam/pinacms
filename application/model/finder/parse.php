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



require_once PATH_CORE.'classes/BaseFinder.php';
require_once PATH_CORE.'classes/ExtManager.php';
require_once PATH_CORE.'classes/Sorting.php';

class ParseFinder extends BaseFinder {

	function search($rules, $sorting, $paging)
	{
		$db = getDB();

		$this->addField("cody_parse.*");
		$this->setFrom("cody_parse");

		if (!empty($rules["substring"]))
		{
			$substring = $db->escape($rules["substring"]);
			$where = "
			    cody_parse.parse_url LIKE '%".$substring."%' OR
			    cody_parse.parse_title LIKE '%".$substring."%'
			";
			$this->addWhere($where);
		}

		if (!empty($rules["module_id"]) && $rules["module_id"] != "*")
		{
			$module_id = intval($rules["module_id"]);
			$this->addJoin('inner', 'rsb_module',
				array(
					'parse_url' => array('cody_parse' => 'parse_url'),
					'module_id' => $module_id
				)
			);
		}

		if (!empty($rules["parse_type"]) && $rules["parse_type"] != "*")
		{
			$parse_type = $db->escape($rules["parse_type"]);
			$where = "
			    cody_parse.parse_type = '".$parse_type."'
			";
			$this->addWhere($where);
		}

		if (!empty($rules["only_new"]) && $rules["only_new"] != "*")
		{
			$where = "
			    cody_parse.parse_file = ''
			";
			$this->addWhere($where);
		}

		$this->setGroupBy('cody_parse', 'parse_id');

		$this->addSorting($sorting, 'cody_parse', 'parse_id');

		if (!empty($paging))
		{
			$paging->setTotal(
				$db->one(
					$this->constructSelect(true)
				)
			);
			$this->setPaging($paging);
		}

		$sql = $this->constructSelect();
		#echo $sql;
		return $db->table($sql);
	}

	public function addSorting($sorting, $defTable, $defField)
	{
		if (empty($sorting)) $sorting = new Sorting("", "");

		$sortField = $sorting->getField();
		$sortDir = $sorting->getDirection();

		// Фильтруем поле сортировки
		if (!in_array($sortField, array('id', 'url', 'title', 'type')))
		{
			$sortTable = $defTable;
			$sortField = $defField;
			$sortDir   = 'asc';
		}
		else
		{
			$sortTable = 'cody_parse';
			$sortField = 'parse_'.$sortField;
		}

		// Фильтруем направление сортировки
		if ($sortDir != 'asc' && $sortDir != 'desc' || $sortDir == '')
		{
			$sortDir = 'desc';
		}

		// Конструируем SELECT-запрос
		$this->addOrderBy($sortTable.'.'.$sortField.' '.$sortDir);
		if ($sortField != "parse_id") $this->addOrderBy('cody_parse.parse_id asc');
	}

}