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

class ImageFinder extends BaseFinder
{
	function search($rules, $sorting, $paging)
	{
		$db = getDB();

		$this->addField('`cody_image`.*');
		$this->setFrom('`cody_image`');

		
                $this->addWhere("`site_id` = '".Site::id()."'");
		

		if (isset($rules["filter_width"]) && is_array($rules["filter_width"]) && count($rules["filter_width"]) == 2)
		{
			$start = (int)$rules["filter_width"][0];
			$end = (int)$rules["filter_width"][1];
			$this->addWhere("`image_width` BETWEEN $start AND $end");
		}

		if (isset($rules["filter_height"]) && is_array($rules["filter_height"]) && count($rules["filter_height"]) == 2)
		{
			$start = (int)$rules["filter_height"][0];
			$end = (int)$rules["filter_height"][1];
			$this->addWhere("`image_height` BETWEEN $start AND $end");
		}

		if (isset($rules["type"]) && $rules["type"] != "" && $rules["type"] != "*")
		{
			$this->addWhere("`image_type` = '". $db->escape($rules["type"]) ."'");
		}

		if (isset($rules['substring']) && $rules['substring'] != '')
		{
			$where = array(
				"image_filename LIKE '%". $db->escape($rules["substring"]) ."%'",
				"image_alt LIKE '%". $db->escape($rules["substring"]) ."%'"
			);
			$this->addWhere(implode(' OR ', $where));
		}

		$this->addSorting($sorting);
				
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
		#print_r($rules);die;
		#echo $sql;die;
		return $db->table($sql);
	}

	private function addSorting($sorting)
	{
		if (empty($sorting)) $sorting = new Sorting("", "");

		$sortField = $sorting->getField();
		$sortDir = $sorting->getDirection();

		// Фильтруем поле сортировки
		$sortTable = 'cody_image';
		if (!in_array($sortField, array('title', 'created', 'enabled')))
		{
			$sortField = 'image_id';
			$sortDir   = 'desc';
		}
		else
		{
			$sortField = 'post_'.$sortField;
		}

		// Фильтруем направление сортировки
		if ($sortDir != 'asc' && $sortDir != 'desc' || $sortDir == '')
		{
			$sortDir = 'desc';
		}

		// Конструируем SELECT-запрос
		$this->addOrderBy($sortTable.'.'.$sortField.' '.$sortDir);
		if ($sortField != "image_id") $this->addOrderBy('cody_image.image_id desc');
	}
}