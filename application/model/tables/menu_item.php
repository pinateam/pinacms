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

	function reportMenuIdsByActionAndParams($action, $params)
	{
		$action = $this->db->escape($action);
		$params = $this->db->escape($params);

		return $this->db->col("SELECT menu_id FROM ".$this->table." WHERE site_id = '".$this->siteId."' AND url_action = '".$action."' AND url_params = '".$params."'");
	}

	function removeByActionAndParams($action, $params)
	{
		$action = $this->db->escape($action);
		$params = $this->db->escape($params);

		return $this->db->query("DELETE FROM ".$this->table." WHERE site_id = '".$this->siteId."' AND url_action = '".$action."' AND url_params = '".$params."'");
	}


	function removeByMenuIdAndActionAndParams($menuId, $action, $params)
	{
		$menuId = intval($menuId);
		$action = $this->db->escape($action);
		$params = $this->db->escape($params);

		return $this->db->query("DELETE FROM ".$this->table." WHERE site_id = '".$this->siteId."' AND menu_id = '".$menuId."' AND url_action = '".$action."' AND url_params = '".$params."'");
	}

	function reportMaxOrder()
	{
		return $this->db->one("SELECT max(menu_item_order) FROM ".$this->table." WHERE site_id = '".$this->siteId."'");
	}

	function editByActionAndParams($action, $params, $data)
	{
		$action = $this->db->escape($action);
		$params = $this->db->escape($params);

		$this->db->query($q = "UPDATE `".$this->table."` ".$this->constructSetCondition($data)." WHERE `".$this->table."`.`site_id` = '".$this->siteId."' AND `".$this->table."`.`url_action` = '".$action."' AND `".$this->table."`.`url_params` = '".$params."'");
	}
}