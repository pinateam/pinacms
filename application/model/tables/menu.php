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

class MenuGateway extends TableDataGateway
{
	var $table = 'cody_menu';
	var $orderBy = 'menu_order';

	var $useSiteId = true;

	var $fields = array(
		'menu_id' => "int(11) NOT NULL AUTO_INCREMENT",
		'site_id' => "int(10) NOT NULL DEFAULT '0'",
		'menu_key' => "varchar(64) NOT NULL DEFAULT ''",
		'menu_title' => "varchar(255) NOT NULL DEFAULT ''",
		'menu_order' => "int(11) NOT NULL DEFAULT '0'",
	);

	var $indexes = array(
		'PRIMARY KEY' => 'menu_id',
		'UNIQUE KEY menu_key' => array('menu_key', 'site_id')
	);

	public function put($data)
	{
		$this->db->query("
			INSERT INTO `".$this->table."` ".$this->constructSetCondition($data, true)."
			ON DUPLICATE KEY UPDATE ".$this->constructSetCondition($data, true, "")."
		");
		return $this->db->insertId();
	}

}