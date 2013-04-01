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
	var $fields = array(
		'module_key' => "varchar(32) NOT NULL DEFAULT ''",
		'site_id' => "int(10) NOT NULL DEFAULT '0'",
		'module_title' => "varchar(255) NOT NULL DEFAULT ''",
		'module_description' => "varchar(255) NOT NULL DEFAULT ''",
		'module_enabled' => "varchar(1) NOT NULL DEFAULT 'N'",
		'module_version' => "varchar(16) NOT NULL DEFAULT '1.00'",
		'module_config_action' => "varchar(64) NOT NULL DEFAULT ''",
		'module_group' => "varchar(32) NOT NULL DEFAULT ''",
	);

	var $indexes = array(
		'PRIMARY KEY' => array('module_key','site_id'),
		'KEY module_enabled' => array('module_enabled', 'site_id')
	);

	var $useSiteId = true;

	public function findConfigurable()
	{
		return $this->db->table("
			SELECT * FROM `".$this->table."`
			WHERE module_config_action != ''".$this->getBySiteAndAccount()
		);
	}
}