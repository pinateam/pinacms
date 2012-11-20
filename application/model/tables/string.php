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

class StringGateway extends TableDataGateway
{
	var $table = 'cody_string';
	var $fields = array
	(
		"string_key", "language_code", "string_value", "module_key"
	);

	function remove($string_key, $language_code)
	{
		$string_key = $this->db->escape($string_key);
		$language_code = $this->db->escape($language_code);
		$this->db->query("DELETE FROM ".$this->table." WHERE string_key = '".$string_key."' AND language_code = '".$language_code."'");
	}

	function editValuesByKeys($items, $language_code)
	{
		if (!is_array($items) || count($items) == 0) return;

		$sql = "REPLACE INTO ".$this->table." (language_code, string_key, string_value) VALUES ";
		$f = false;
		foreach ($items as $k => $v)
		{
			if ($f) $sql .= ",";
			$sql .= "('".$this->db->escape($language_code)."', '".$this->db->escape($k)."', '".$this->db->escape($v)."')";
			$f = true;
		}
		
		$this->db->query($sql);
	}

	function  reportExists($string_key, $language_code) {
		return $this->db->one("SELECT count(*) FROM `".$this->table."` WHERE string_key = '".$this->db->escape($string_key)."' AND language_code = '".$this->db->escape($language_code)."' LIMIT 1");
	}
}