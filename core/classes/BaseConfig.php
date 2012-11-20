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
* @copyright � 2010 Dobrosite ltd.
*/

if (!defined('PATH')){ exit; }



class BaseConfig
{
	var $data = array();
	var $temp = array();
	var $fileName;
	var $baseName = 'base_config';

	function  __construct() {
		$this->fileName = $this->baseName.".".Site::id().".php";
		$this->init();
	}

	function set($module_key, $key, $value)
	{
		$this->data[$module_key][$key] = $value;
		$db = getDB();
		$db->query("
			INSERT INTO
				cody_".$this->baseName."
			SET
				site_id = '".Site::id()."',
				module_key = '".$db->escape($module_key)."',
				".$this->baseName."_key = '".$db->escape($key)."',
				".$this->baseName."_value = '".$db->escape($value)."'
			ON DUPLICATE KEY UPDATE
				".$this->baseName."_value = '".$db->escape($value)."'
		");
		$this->writeCache();
	}

	function setTemporary($module_key, $key, $value)
	{
		$this->temp[$module_key][$key] = $value;
	}

	function get($module_key, $key)
	{
		if (isset($this->temp[$module_key][$key])) return $this->temp[$module_key][$key];

		if (!isset($this->data[$module_key][$key])) return false;

		return $this->data[$module_key][$key];
	}

	function init()
	{
		if (file_exists(PATH_CACHE.$this->fileName))
		{
			//кеш существует
			//проверка актуальности кеша
			$today = mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"));
			$data_create_file = filemtime(PATH_CACHE.$this->fileName);

			if ((floor(($today - $data_create_file) / 86400 )) >= 1)
			{
				//генерация нового кеша
				unlink(PATH_CACHE.$this->fileName);
				$this->load();
				//инклудим кеш
				require_once PATH_CACHE.$this->fileName;
			}
			else
			{
				require_once PATH_CACHE.$this->fileName;
			}
		}
		else
		{
			//генерация нового кеша
			$this->load();
			//инклудим кеш
			require_once PATH_CACHE.$this->fileName;
		}
	}

	function load()
	{
		$db = getDB();

		$lines = $db->table("
			SELECT
				module_key, ".$this->baseName."_key, ".$this->baseName."_value
                        FROM
				cody_".$this->baseName."
			WHERE
				site_id = '".Site::id()."'
		");

		$this->data = array();
		foreach($lines as $key => $value)
		{
			$this->data[$value['module_key']][$value[$this->baseName.'_key']] = $value[$this->baseName.'_value'];
		}
		$this->writeCache();
	}

	function writeCache()
	{
		$body = '';
		foreach($this->data as $key => $value)
		{
			foreach($value as $k => $v)
			{
				$body .= '$this->data['."'". $key ."'".']'.'['."'". $k ."'".'] = '."'". str_replace("'", "\'", $v) ."'".';'."\n";
			}
		}

		$f = fopen(PATH_CACHE.$this->fileName, "w");
		fwrite($f, '<?php '."\n".$body."\n?>");
		fclose($f);
	}

	function retireCache()
	{
		unlink(PATH_CACHE.$this->fileName);
	}

	function fetch()
	{
		return array_merge($this->data, $this->temp);
	}
}