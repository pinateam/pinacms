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

	var $fields = array(
		'site_id' => "int(10) NOT NULL DEFAULT '0'",
		'url_key' => "varchar(64) NOT NULL DEFAULT ''",
		'url_action' => "varchar(32) NOT NULL DEFAULT ''",
		'url_params' => "varchar(128) NOT NULL DEFAULT ''",
	);

	var $indexes = array(
		'PRIMARY KEY' => array('url_key', 'site_id'),
		'KEY action_params' => array('url_action','url_params', 'site_id')
	);
	
	function reportKey($action, $params)
	{
		return $this->db->one("SELECT url_key FROM ".$this->table." WHERE url_action = '".$this->db->escape($action)."' AND url_params = '".$this->db->escape($params)."'".$this->getBySiteAndAccount());
	}

	function addUrl($key, $action, $params)
	{
		$this->db->query("INSERT INTO ".$this->table." SET url_key = '".$this->db->escape($key)."', url_action = '".$this->db->escape($action)."', url_params = '".$this->db->escape($params)."'".$this->getBySiteAndAccount());
	}

	function paste($key, $action, $params)
	{
		$this->db->query("DELETE FROM ".$this->table." WHERE url_action = '".$this->db->escape($action)."' AND url_params = '".$this->db->escape($params)."'".$this->getBySiteAndAccount());
		if (!empty($key))
		{
			$this->db->query("INSERT INTO ".$this->table." SET url_key = '".$this->db->escape($key)."', url_action = '".$this->db->escape($action)."', url_params = '".$this->db->escape($params)."'".$this->getBySiteAndAccount(","));
		}
	}

	function reportEditApproved($key, $action, $params)
	{
		return !$this->db->one($q = "SELECT count(*) FROM ".$this->table." WHERE url_key = '".$this->db->escape($key)."' AND (url_action != '".$this->db->escape($action)."' OR url_params != '".$this->db->escape($params)."')".$this->getBySiteAndAccount());
	}

        public function removeUrl($action, $params)
        {
                return $this->db->query("DELETE FROM `".$this->table."` WHERE `url_action` = '".$this->db->escape($action)."' AND `url_params` = '".$this->db->escape($params)."'".$this->getBySiteAndAccount());
        }

}