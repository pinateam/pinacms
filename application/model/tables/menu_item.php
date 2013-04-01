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




require_once PATH_CORE.'classes/TableDataGateway.php';

class MenuItemGateway extends TableDataGateway
{
	var $table = 'cody_menu_item';
	var $orderBy = 'menu_item_order ASC';
	var $useSiteId = true;

	var $fields = array(
		'menu_item_id' => "int(11) NOT NULL AUTO_INCREMENT",
		'menu_id' => "int(11) NOT NULL DEFAULT '0'",
		'site_id' => "int(11) NOT NULL DEFAULT '0'",
		'menu_item_title' => "varchar(255) NOT NULL DEFAULT ''",
		'menu_item_link' => "varchar(255) NOT NULL DEFAULT ''",
		'url_action' => "varchar(32) NOT NULL DEFAULT ''",
		'url_params' => "varchar(128) NOT NULL DEFAULT ''",
		'menu_item_enabled' => "varchar(1) NOT NULL DEFAULT 'Y'",
		'menu_item_order' => "int(11) NOT NULL DEFAULT '0'",
	);

	var $indexes = array(
		'PRIMARY KEY' => 'menu_item_id',
		'KEY action_params' => array('url_action', 'url_params', 'site_id'),
		'KEY menu_id' => array('menu_id', 'site_id')
	);

	function reportMenuIdsByActionAndParams($action, $params)
	{
		$action = $this->db->escape($action);
		$params = $this->db->escape($params);

		return $this->db->col("SELECT menu_id FROM ".$this->table." WHERE url_action = '".$action."' AND url_params = '".$params."'".$this->getBySiteAndAccount());
	}

	function removeByActionAndParams($action, $params)
	{
		$action = $this->db->escape($action);
		$params = $this->db->escape($params);

		return $this->db->query("DELETE FROM ".$this->table." WHERE url_action = '".$action."' AND url_params = '".$params."'".$this->getBySiteAndAccount());
	}


	function removeByMenuIdAndActionAndParams($menuId, $action, $params)
	{
		$menuId = intval($menuId);
		$action = $this->db->escape($action);
		$params = $this->db->escape($params);

		return $this->db->query("DELETE FROM ".$this->table." WHERE menu_id = '".$menuId."' AND url_action = '".$action."' AND url_params = '".$params."'".$this->getBySiteAndAccount());
	}

	function reportMaxOrder()
	{
		return $this->db->one("SELECT max(menu_item_order) FROM ".$this->table." WHERE 1".$this->getBySiteAndAccount());
	}

	function editByActionAndParams($action, $params, $data)
	{
		$action = $this->db->escape($action);
		$params = $this->db->escape($params);

		$this->db->query($q = "UPDATE `".$this->table."` ".$this->constructSetCondition($data)." WHERE `".$this->table."`.`url_action` = '".$action."' AND `".$this->table."`.`url_params` = '".$params."'".$this->getBySiteAndAccount());
	}
}