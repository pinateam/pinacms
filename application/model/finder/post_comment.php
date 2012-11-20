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

class PostCommentFinder extends BaseFinder
{
	public function search($rules = array(), $sorting = false, $paging = false)
	{
		$db = getDB();
		
		// Конструируем поисковый запрос по заданным правилам
		$this->addField('cody_post_comment.*');

		$this->constructSearchSQL($rules);
		
		$this->setSorting($sorting, 'cody_post_comment', 'comment_id');

		// Расширяем запрос
		$extensions = ExtManager::instance()->get();
		$this->addExtensions($extensions);

		if (!empty($paging))
		{
			$total = $db->one(
				$q = $this->constructSelect(true)
			);
			
			$paging->setTotal($total);
			$this->setPaging($paging);
		}
		
		$sql = $this->constructSelect();
		
		if ($sql == '') return false;
		
		// Выполняем SELECT-запрос и возвращаем результат
		return $db->table($sql);
	}

	/**
	 *
	 * Вспомогательная функция для search
	 *
	 */
	private function constructSearchSQL($rules)
	{
		$db = getDB();

		$this->setFrom('cody_post_comment');

		$this->addWhere("cody_post_comment.`site_id` = '".Site::id()."'");
		
		$this->addField('cody_post.post_title');
		$this->addJoin('left', 'cody_post',
			array(
				'post_id' => array('cody_post_comment' => 'post_id'),
				'site_id' => array('cody_post_comment' => 'site_id')
			)
		);

		if (!empty($rules["comment_date_start"]))
		{  
			$this->addWhere("cody_post_comment.comment_created>='".date("Y-m-d 00:00:00", strtotime($rules["comment_date_start"]))."'");
		}

		if (!empty($rules["comment_date_end"]))
		{   
			$this->addWhere("cody_post_comment.comment_created<='".date("Y-m-d 23:59:59", strtotime($rules["comment_date_end"]))."'");
		}

		if(!empty($rules["post_title"]))
		{ 
			$this->addWhere("cody_post.post_title LIKE '%".$rules["post_title"]."%'"); 
		}

		if(!empty($rules["comment_approved"]) && $rules["comment_approved"] != '*')
		{ 
			$this->addWhere("comment_approved='".$rules["comment_approved"]."'");  
		}
	}
	
	private function setSorting($sorting, $defSortTable, $defSortField)
	{
		if (empty($sorting)) $sorting = new Sorting('', '');

		$sortField = $sorting->getField();
		$sortDir = $sorting->getDirection();

		// Фильтруем поле сортировки
		if (!in_array($sortField, array(
			"comment_id", "post_id","visitor_name","visitor_email", "visitor_ip",
			"comment_message","comment_approved","comment_created", "user_id",
			"visitor_site","comment_updated"
		)))
		{
			$sortTable = $defSortTable;
			$sortField = $defSortField;
			$sortDir   = 'asc';
		}
		else
		{
			$sortTable = 'cody_post_comment';
		}

		// Фильтруем направление сортировки
		if ($sortDir != 'asc' && $sortDir != 'desc' || $sortDir == '')
		{
			$sortDir = 'asc';
		}

		// Конструируем SELECT-запрос
		$this->addOrderBy($sortTable.'.'.$sortField.' '.$sortDir);
		if ($sortField != 'comment_id') $this->addOrderBy('cody_post_comment.comment_id');
	}
}