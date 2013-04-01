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

class MetaGateway extends TableDataGateway
{
	var $table = 'cody_meta';

	var $useSiteId = true;

	var $fields = array(
		'site_id' => "int(10) NOT NULL DEFAULT '0'",
		'meta_action' => "varchar(32) NOT NULL DEFAULT ''",
		'meta_params' => "varchar(128) NOT NULL DEFAULT ''",
		'meta_h1' => "varchar(255) NOT NULL DEFAULT ''",
		'meta_title' => "varchar(255) NOT NULL DEFAULT ''",
		'meta_keys' => "varchar(255) NOT NULL DEFAULT ''",
		'meta_description' => "varchar(255) NOT NULL DEFAULT ''",
	);

	var $indexes = array(
		'UNIQUE KEY meta_key' => array('site_id','meta_action','meta_params')
	);

	public function edit($action, $params, $data)
	{
		if (!is_array($data) || empty($data)) return false;
		
		$action = $this->db->escape($action);
		$params = $this->db->escape($params);
		
		$set = array();
		
		foreach ($data as $field => $value)
		{
			$set[] = "`".$field."` = '".$this->db->escape($value)."'";
		}
		
		$set = join(', ', $set);
		
		return $this->db->query("INSERT INTO `".$this->table."` SET ".$set.", `meta_action` = '$action', `meta_params` = '$params'".$this->getBySiteAndAccount(",")." ON DUPLICATE KEY UPDATE $set");
	}
	
	public function remove($action, $params)
	{
		$action = $this->db->escape($action);
		$params = $this->db->escape($params);
		
		return $this->db->query("DELETE FROM ".$this->table." WHERE meta_action = '$action' AND meta_params = '$params'".$this->getBySiteAndAccount());
	}

        public function getByItem($action, $params)
        {
		$action = $this->db->escape($action);
		$params = $this->db->escape($params);
		return $this->db->row("
			SELECT *
			FROM
				`".$this->table."`
			WHERE
				`meta_action` = '".$action."' AND
				`meta_params` = '".$params."'".$this->getBySiteAndAccount()
		);
        }
}