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



define ("NOT_CACHED", null);

class Cache
{
	static public $debug = array();
	static public $data = array();
	static public function set($subject, $key, $value)
	{
		if (!isset(self::$data[$subject])) self::$data [$subject] = array();
		self::$data [$subject] [$key] = $value;

		if (defined("CACHE_DISK")) self::save($subject, $key, $value);
	}

	static public function get($subject, $key)
	{
		if (defined("CACHE_DISK") && (!isset(self::$data[$subject]) || !isset(self::$data[$subject][$key])))
		{
			$res = self::load($subject, $key);
			if ($res !== false) self::$data[$subject][$key] = $res;
		}
	
		if (!isset(self::$data[$subject])) return NOT_CACHED;
		if (!isset(self::$data[$subject][$key])) return NOT_CACHED;

		return self::$data[$subject][$key];
	}

	static public function retire($subject, $key)
	{
		if (defined("CACHE_DISK")) self::remove($subject, $key);

		unset(self::$data [$subject] [$key]);
	}

	static public function filename($subject, $key)
	{
		if (defined("DEBUG")) $time_start = microtime(1);

		if (defined("CACHE_DISK_MAKE_PATHS")) @mkdir(PATH_CACHE.$subject);

		if (defined("DEBUG")) self::$debug[] = array("query" => "create dir ".$subject."(".$key.")", "time" => microtime(1) - $time_start);

		return PATH_CACHE.$subject."/".$key.".cache";
	}

	static public function save($subject, $key, $value)
	{
		if (defined("DEBUG")) $time_start = microtime(1);

		@file_put_contents(self::filename($subject, $key), serialize($value));

		if (defined("DEBUG")) self::$debug[] = array("query" => "save ".$subject."(".$key.")", "time" => microtime(1) - $time_start);
	}

	static public function load($subject, $key)
	{
		if (defined("DEBUG")) $time_start = microtime(1);

		$str = @file_get_contents(self::filename($subject, $key));
		if ($str === false) return false;

		if (defined("DEBUG")) self::$debug[] = array("query" => "load ".$subject."(".$key.")", "time" => microtime(1) - $time_start);

		return unserialize($str);
	}

	static public function remove($subject, $key)
	{
		if (defined("DEBUG")) $time_start = microtime(1);

		@unlink(self::filename($subject, $key));

		if (defined("DEBUG")) self::$debug[] = array("query" => "read ".$subject."(".$key.")", "time" => microtime(1) - $time_start);
	}

	static public function getDebugTotal()
	{
		$total = 0;
		foreach (self::$debug as $t)
		{
			$total += $t["time"];
		}
		return $total;
	}
}