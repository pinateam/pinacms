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

class ModuleGateway extends TableDataGateway
{
	var $table = "cody_module";
	var $primaryKey = "module_key";
	var $orderBy = "module_title";
	var $fields = array
	(
		"module_key", "site_id", "module_title", "module_description", "module_enabled", "module_version", "module_config_action",
	);

	var $useSiteId = true;

	public function edit($id, $data)
	{
		Cache::retire($this->table, $id);
		$siteId = intval($this->siteId);
		return $this->db->query("UPDATE `".$this->table."` ".$this->constructSetCondition($data)." WHERE `".$this->table."`.`".$this->primaryKey."` = '".$id."' AND `".$this->table."`.`site_id` = '".$siteId."'");
	}

	public function findConfigurable()
	{
		$siteId = intval($this->siteId);
		return $this->db->table("SELECT * FROM `".$this->table."` WHERE module_config_action != '' AND site_id = '".$siteId."'");
	}

        public function findKeysBaseSite()
        {
                return $this->db->col("
                    SELECT `module_key`
                    FROM `".$this->table."`
                    WHERE `site_id` = '0';
                ");
        }
}