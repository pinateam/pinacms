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



require_once PATH_CORE.'classes/BaseFinder.php';
require_once PATH_CORE.'classes/ExtManager.php';
require_once PATH_CORE.'classes/Sorting.php';

class UserFinder extends BaseFinder
{
	function search($rules, $sorting, $paging)
	{
		$db = getDB();

		$this->addField("cody_user.*");
		$this->setFrom("cody_user");

		
		$this->addWhere("cody_user.account_id = '".intval(Site::accountId())."'");
		

		$this->addField("cody_access_group.access_group");
		$this->addJoin("left", "cody_access_group", array(
		    "access_group_id" => array ("cody_user" => "access_group_id")
		));

		if (!empty($rules["substring"]))
		{
			$substring = $db->escape($rules["substring"]);
			$where = "
				cody_user.user_login LIKE '%".$substring."%'
				OR
				cody_user.user_title LIKE '%".$substring."%'
				OR
				cody_user.user_email LIKE '%".$substring."%'
			";
			$this->addWhere($where);
		}

		if (!empty($rules["user_status"]) && $rules["user_status"] != "*")
		{
			$this->addWhere("cody_user.user_status = '".$db->escape($rules["user_status"])."'");
		}

		if (!empty($rules["access_group_id"]) && $rules["access_group_id"] != "*")
		{
			$this->addWhere("cody_user.access_group_id = '".$db->escape($rules["access_group_id"])."'");
		}

		$this->addSorting($sorting, 'cody_user', 'user_id');

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
		return $db->table($sql);
	}

	public function addSorting($sorting, $defTable, $defField)
	{
		if (empty($sorting)) $sorting = new Sorting("", "");

		$sortField = $sorting->getField();
		$sortDir = $sorting->getDirection();

		// Фильтруем поле сортировки
		if (!in_array($sortField, array('id', 'login', 'title', 'email', 'created', 'status')))
		{
			$sortTable = $defTable;
			$sortField = $defField;
			$sortDir   = 'desc';
		}
		else
		{
			$sortTable = 'cody_user';
			$sortField = 'user_'.$sortField;
		}

		// Фильтруем направление сортировки
		if ($sortDir != 'asc' && $sortDir != 'desc' || $sortDir == '')
		{
			$sortDir = 'desc';
		}

		// Конструируем SELECT-запрос
		$this->addOrderBy($sortTable.'.'.$sortField.' '.$sortDir);
		if ($sortField != "user_id") $this->addOrderBy('cody_user.user_id desc');
	}

}
