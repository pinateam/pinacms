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

class PostFinder extends BaseFinder
{
	function search($rules, $sorting, $paging)
	{
		$db = getDB();

                $this->addField('`cody_post`.*');
                $this->setFrom('`cody_post`');

		
                $this->addWhere("`site_id` = '".Site::id()."'");
		

		if (isset($rules["blog_id"]) && $rules["blog_id"] != "" && $rules["blog_id"] != "N")
		{
			$this->addWhere("`blog_id` = '".(int)$rules["blog_id"]."'");
		}

		if(!empty($rules["post_enabled"]) && $rules["post_enabled"] != '*')
		{
			$this->addWhere("post_enabled='".$rules["post_enabled"]."'");
		}

		if (!empty($rules['substring']))
		{
			$this->addWhere("post_title LIKE '%".$rules["substring"]."%'");
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
		#echo $sql;die;
		return $db->table($sql);
	}

        private function addSorting($sorting)
        {
		if (empty($sorting)) $sorting = new Sorting("", "");

		$sortField = $sorting->getField();
		$sortDir = $sorting->getDirection();

		// Фильтруем поле сортировки
		$sortTable = 'cody_post';
		if (!in_array($sortField, array('title', 'created', 'published', 'enabled')))
		{
			$sortField = 'post_id';
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
		if ($sortField != "post_id") $this->addOrderBy('cody_post.post_id desc');
        }

        public function searchIds($rules, $sorting = false, $paging)
        {
                $db = getDB();
                $this->clear();

                $this->addField('`cody_post`.`post_id`');
                $this->setFrom('`cody_post`');

		
                $this->addWhere("`site_id` = '".Site::id()."'");
		

		if (isset($rules["blog_id"]))
		{
			$this->addWhere("`blog_id` = '".(int)$rules["blog_id"]."'");
		}

                if(!empty($sorting)) $this->addSorting($sorting);
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
		return $db->col($sql);
        }
}