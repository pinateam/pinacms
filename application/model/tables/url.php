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

class UrlGateway extends TableDataGateway
{
	var $table = 'cody_url';

	var $useSiteId = true;
	
	function reportKey($action, $params)
	{
		$siteId = intval($this->siteId);
		return $this->db->one("SELECT url_key FROM ".$this->table." WHERE site_id = '".$siteId."' AND url_action = '".$this->db->escape($action)."' AND url_params = '".$this->db->escape($params)."'");
	}

	function paste($key, $action, $params)
	{
		$siteId = intval($this->siteId);
		$this->db->query("DELETE FROM ".$this->table." WHERE site_id = '".$siteId."' AND url_action = '".$this->db->escape($action)."' AND url_params = '".$this->db->escape($params)."'");
		if (!empty($key))
		{
			$this->db->query("INSERT INTO ".$this->table." SET site_id = '".$siteId."', url_key = '".$this->db->escape($key)."', url_action = '".$this->db->escape($action)."', url_params = '".$this->db->escape($params)."'");
		}
	}

	function reportEditApproved($key, $action, $params)
	{
		$siteId = intval($this->siteId);
		return !$this->db->one($q = "SELECT count(*) FROM ".$this->table." WHERE site_id = '".$siteId."' AND url_key = '".$this->db->escape($key)."' AND (url_action != '".$this->db->escape($action)."' OR url_params != '".$this->db->escape($params)."')");
	}

        public function remove($action, $params)
        {
		$siteId = intval($this->siteId);
                return $this->db->query("DELETE FROM `".$this->table."` WHERE site_id = '".$siteId."' AND `url_action` = '".$this->db->escape($action)."' AND `url_params` = '".$this->db->escape($params)."'");
        }

}