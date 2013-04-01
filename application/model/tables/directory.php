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

class DirectoryGateway extends TableDataGateway
{
	var $table = "cody_directory";
	var $fields = array(
		'site_id' => "int(10) NOT NULL DEFAULT '0'",
		'module_key' => "varchar(32) NOT NULL DEFAULT ''",
		'directory_key' => "varchar(32) NOT NULL DEFAULT ''",
		'directory_value' => "varchar(255) NOT NULL DEFAULT ''",
		'directory_title' => "varchar(255) NOT NULL DEFAULT ''",
	);

	var $indexes = array(
		'PRIMARY KEY' => array('site_id','module_key','directory_key','directory_value'),
		'KEY language_code' => array('site_id','module_key','directory_key')
	);

	var $useSiteId = true;

	public function reportTitle($key, $value)
	{
		$key = $this->db->escape($key);
		$value = $this->db->escape($value);
		return $this->db->one
		("
			SELECT directory_title
			FROM ".$this->table."
			WHERE
				directory_key='".$key."' AND
				directory_value = '".$value."'".
				$this->getBySiteAndAccount()."
			LIMIT 1"
		);
	}

	public function findByKey($key)
	{
		$key = $this->db->escape($key);
		return $this->db->table("
			SELECT directory_value, directory_title
			FROM ".$this->table."
			WHERE
				directory_key='".$key."'".
				$this->getBySiteAndAccount()
		);
	}
	public function edit($directory_key, $directory_value, $data)
	{
		$directory_key = $this->db->escape($directory_key);
		$directory_value = $this->db->escape($directory_value);
		
		return $this->db->query("
			UPDATE `".$this->table."` ".$this->constructSetCondition($data)."
			WHERE directory_key= '".$directory_key."' AND directory_value='".$directory_value."'
			".$this->getBySiteAndAccount()
		);
	}
	public function remove($directory_key, $directory_value)
	{
		$directory_key = $this->db->escape($directory_key);
		$directory_value = $this->db->escape($directory_value);

		return $this->db->query("
			DELETE FROM `".$this->table."`
			WHERE directory_key= '".$directory_key."' AND directory_value='".$directory_value."'
			".$this->getBySiteAndAccount()
		);
	}
	
	public function getByKeyAndValue($directory_key, $directory_value)
	{
		return $this->db->row("
			SELECT * FROM `".$this->table."`
			WHERE
				".$this->constructByCondition("directory_value", $directory_value)." AND
				".$this->constructByCondition("directory_key", $directory_key)."
				".$this->getBySiteAndAccount()."
			LIMIT 1"
		);
	}
	
	public function findNotDirectory()
	{
		return $this->db->table("
			SELECT * FROM `".$this->table."`
			WHERE
				`directory_key` <> 'directory'
				".$this->getBySiteAndAccount().
			$this->getOrderBy()
		);
	}
	
	public function getDirectoryByValue($value)
	{
		return $this->db->row("
			SELECT * FROM `".$this->table."`
			WHERE
				".$this->constructByCondition("directory_value", $value)." AND
				directory_key = 'directory'
				".$this->getBySiteAndAccount()."
			LIMIT 1"
		);
	}


}