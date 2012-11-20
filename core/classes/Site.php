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



class Site {
	private static $id = 0;
	private static $accountId = 0;
	private static $domain = "";
	private static $path = "";
	private static $template = "";

	static function id()
	{
		return self::$id;
	}

	static function accountId()
	{
		return self::$accountId;
	}

	static function path()
	{
		return self::$path;
	}

	static function domain()
	{
		return self::$domain;
	}

	static function template()
	{
		return self::$template;
	}

	static function baseUrl($id)
	{
		$id = intval($id);
		if (empty($id)) return SITE;

		$domain = self::$domain;
		$path = self::$path;
		if ($id != self::$id)
		{
			$db = getDB();
			$site = $db->row("SELECT * FROM cody_site WHERE site_id = '".$id."'");
			$domain = $site["site_domain"];
			$path = $site["site_path"];
		}

		if (empty($domain))
		{
			$domain = SITE_BASE;
			$path = SITE_PATH.$path."/";
		}
		else
		{
			$domain = "http://".$domain."/";
			$path = "";
		}
		
		return $domain.$path;
	}

	static function initById($siteId)
	{
		$siteId = intval($siteId);
		$db = getDB();
		$site = $db->row("SELECT * FROM cody_site WHERE site_id = '".$siteId."'");
		if (empty($site)) return false;

		self::$id = $site["site_id"];
		self::$accountId = $site["account_id"];
		self::$domain = $site["site_domain"];
		self::$path = $site["site_path"];
		self::$template = $site["site_template"];

		return true;
	}

	static function initByPath($host = '', $path = '')
	{
		if (empty($host)) return false;

		if (strcasecmp($host, SITE_HOST) == 0)
		{
			self::$id = 0;
			self::$domain = SITE_HOST;
                        self::$path = 'root';
			return true;
		}

		if (false && strpos($path, "lib/") !== false)
		{
			self::$id = 0;
			self::$domain = SITE_HOST;
                        self::$path = 'root';
			return true;
		}

		#echo "HOST: ".$host."<br />";
		#echo "PATH: ".$path."<br />";

		$host = str_replace("www.", "", $host);
		$db = getDB();
		$site = $db->row("SELECT * FROM cody_site WHERE site_domain = '".$db->escape($host)."' OR site_domain = 'www.".$db->escape($host)."'");
		if (empty($site)) return false;

		self::$id = $site["site_id"];
		self::$accountId = $site["account_id"];
		self::$domain = $site["site_domain"];
		self::$path = $site["site_path"];
		self::$template = $site["site_template"];

		return true;
	}
}