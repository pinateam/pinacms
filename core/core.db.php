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



class DB
{
	private $debug = array();

	private $db = 'sys';

	private $conn = null;

	public function __construct($conn)
	{
		$this->init($conn);
	}

	public function init($conn)
	{
		$this->conn = $conn;
	}

	public function query($sql, $ignore = false)
	{
		if (empty($this->conn)) return false;
		
		list($msec, $sec) = explode(' ', microtime());
		$s_time = (float)$msec + (float)$sec;

		$rc = mysql_query($sql, $this->conn);

		list($msec, $sec) = explode(' ', microtime());
		$time_total = ((float)$msec + (float)$sec - $s_time);

		if (mysql_errno($this->conn) && !$ignore)
		{
			$this->outError($sql);
		}

		if (DEFINED("DEBUG_DB") && DEBUG_DB)
		{
			$debug['query'] = $sql;
			$debug['time'] = $time_total;

			$this->debug[] = $debug;
		}

		return $rc;
	}

	public function table($sql, $key = '', $add = true, $removeKey = false)
	{
		$rc = $this->query($sql);

		if (empty($rc)) return false;

		$result = array();

		if (!empty($key))
		{
		    while ($row = mysql_fetch_assoc($rc))
		    {
			$id = $row[$key];
			if ($removeKey) unset($row[$key]);
			if ($add)
				$result[$id] [] = $row;
			else
				$result[$id] = $row;
		    }
		}
		else
		{
		    while ($row = mysql_fetch_assoc($rc))
		    {
			$result [] = $row;
		    }
		}

		mysql_free_result($rc);

		return $result;
	}

	public function row($sql)
	{
		$rc = $this->query($sql);

		if (empty($rc)) return false;

		return mysql_fetch_assoc($rc);
	}

	public function col($sql)
	{
		$rc = $this->query($sql);

		if (empty($rc)) return false;

		$result = array();

		while ($row = mysql_fetch_row($rc))
		{
			if (!isset($row[0])) return false;

			$result [] = $row[0];
		}

		return $result;
	}

	public function one($sql)
	{
		$rc = $this->query($sql);

		if (empty($rc)) return false;

		$row = mysql_fetch_row($rc);

		if (!isset($row[0])) return false;

		return $row[0];
	}
	
	public function num($sql)
	{
		$rc = $this->query($sql);
		return mysql_num_rows($rc);
	}

	public function insertId()
	{
		return mysql_insert_id($this->conn);
	}

	public function loop($sql)
	{
		return new DBLoop($this->query($sql));
	}
	
	public function escape($str)
	{
		if (is_array($str))
		{
			foreach ($str as $k => $tmp)
			{
				$str[$k] = $this->escape($str[$k]);
			}
		}
		else
		{
			$str = mysql_real_escape_string($str, $this->conn);
		}
		
		return $str;
	}

	function outError($sql)
	{
		$errno = mysql_errno($this->conn);
		$error = mysql_error($this->conn);
		$err = empty($errno) ? $error : ($error . ' (' . $errno . ')');
		echo '<div style="background-color: white;">';
		echo '<b><font color="darkred">INVALID SQL:</font></b><font color="black">' . $err . '</font><br />';
		echo '<b><font color="darkred">FAILED QUERY:</font></b><font color="black">' . $sql . '</font><br />';
		echo '</div>';
		flush();

		$fp = fopen(PATH."var/log/mysql-".@date("Y-m-d-H-i-s").".log", "a");
		fwrite($fp, "\r\n\r\n".$err."\r\n\r\n".$sql);
		fclose($fp);
		//exit;
	}

	function errno()
	{
		return mysql_errno($this->conn);
	}

	function error()
	{
		return mysql_error($this->conn);
	}
	
	public function getDebug()
	{
		return $this->debug;
	}

	public function getDebugTotal()
	{
		$total = 0;
		foreach ($this->debug as $d)
		{
			$total += $d["time"];
		}
		return $total;
	}
}

class DBLoop
{
	private $rc;

	public function __construct($rc)
	{
		$this->rc = $rc;
	}

	public function next()
	{
		if (empty($this->rc)) return false;

		return mysql_fetch_assoc($this->rc);
	}

	public function stop()
	{
		if (empty($this->rc)) return false;

		mysql_free_result($this->rc);
	}
}

function getDB($alias = 'default')
{
	static $dbs = array();

	if (!empty($dbs[$alias]))
	{
		return $dbs[$alias];
	}

        static $configDB = array(
            'default' => array('host' => DB_HOST, 'base' => DB_BASE, 'port' => DB_PORT, 'user' => DB_USER, 'pass' => DB_PASS),
        );

	$rc = @mysql_pconnect($configDB[$alias]['host'].':'.$configDB[$alias]['port'], $configDB[$alias]['user'], $configDB[$alias]['pass']);//, true);
	if (empty($rc) || !in_array(mysql_errno($rc), array(0, 1146))) die('db connect error');
	//if (empty($rc) || mysql_errno($rc)) die('db connect error');

	mysql_select_db($configDB[$alias]['base'], $rc);
	if (empty($rc) || mysql_errno($rc)) die('db access error');

	mysql_query('SET NAMES '. DB_CONNECTION_CHARSET, $rc);

	$db = new DB($rc);
	$dbs[$alias] = $db;

	return $dbs[$alias];
}