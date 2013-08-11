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
	private static $isTest = "";
	
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
		
		if (!empty(self::$isTest))
		{
			$postfix = '';
			$config = getConfig();
			$rootTestDomain = $config->get("wizard", "root_test_domain");
			if (!empty(self::$isTest) && !empty($rootTestDomain))
			{
				$pos = strpos($domain, ".".$rootTestDomain);
				if (
					$pos === false ||
					($pos !== false && strlen($domain) != $pos + strlen(".".$rootTestDomain))
				)
				{
					$postfix = ".".$rootTestDomain;
				}
			}
			return self::$domain.$postfix;
		}
		if (!empty(self::$domain)) return self::$domain;
		

		return SITE_HOST;
	}

	static function template($useSession = true)
	{
		
		$isRoot = Site::id() == 0;
		
		

		if ($useSession)
		{
			
			$sessionKey = "site_template_".Site::id();
			
			
			if (Session::get($sessionKey)) self::$template = Session::get($sessionKey);
		}
		
		if (empty(self::$template) && $isRoot)
		{
			$config = getConfig();
			self::$template = $config->get("site", "template");
		}

		if (empty(self::$template) && defined("TEMPLATE_DEFAULT") && TEMPLATE_DEFAULT != '')
		{
			self::$template = TEMPLATE_DEFAULT;
		}

		return self::$template;
	}

	static function baseUrl($id = false, $isTest = NULL)
	{
		

		
		if ($id === false) $id = self::$id;
		if ($isTest === NULL) $isTest = self::$isTest;

		$id = intval($id);
		if (empty($id)) return SITE;

		$domain = self::$domain;
		$path = '';
		if ($id != self::$id)
		{
			$db = getDB();
			$site = $db->row("SELECT * FROM cody_site WHERE site_id = '".$id."'");
			$domain = $site["site_domain"];
		}

		if (empty($domain))
		{
			$domain = SITE_BASE;
			$path = SITE_PATH;
		}
		else
		{
			$postfix = '';
			$config = getConfig();
			$rootTestDomain = $config->get("wizard", "root_test_domain");
			if (!empty($isTest) && $rootTestDomain)
			{
				$pos = strpos($domain, ".".$rootTestDomain);
				if (
					$pos === false ||
					($pos !== false && strlen($domain) != $pos + strlen(".".$rootTestDomain))
				)
				{
					$postfix = ".".$rootTestDomain;
				}
			}
			$domain = "http://".$domain.$postfix."/";
			$path = "";
		}

		return $domain.$path;
		
	}

	
	static function initById($siteId, $isTest = false)
	{
		$siteId = intval($siteId);

		if ($siteId == 0)
		{
			self::$id = 0;
			self::$accountId = 0;
			self::$domain = SITE_HOST;
			self::$path = 'root';
			self::$template = '';
			self::$isTest = $isTest;
		}

		$db = getDB();
		$site = $db->row("SELECT * FROM cody_site WHERE site_id = '".$siteId."'");
		if (empty($site)) return false;

		self::$id = $site["site_id"];
		self::$accountId = $site["account_id"];
		self::$domain = $site["site_domain"];
		self::$path = $site["site_path"];
		self::$template = $site["site_template"];
		self::$isTest = $isTest;

		return true;
	}

	static function initByPath($host = '', $path = '')
	{
		if (empty($host)) return false;

		$host = str_replace("www.", "", $host);

		if (strcasecmp($host, SITE_HOST) == 0 || strcasecmp("www.".$host, SITE_HOST) == 0)
		{
			self::$id = 0;
			self::$accountId = 0;
			self::$domain = SITE_HOST;
                        self::$path = 'root';
			self::$template = '';
			self::$isTest = false;
			return true;
		}

		if (false && strpos($path, "lib/") !== false)
		{
			self::$id = 0;
			self::$accountId = 0;
			self::$domain = SITE_HOST;
			self::$path = 'root';
			self::$template = '';
			self::$isTest = false;
			return true;
		}

		#echo "HOST: ".$host."<br />";
		#echo "PATH: ".$path."<br />";

		$db = getDB();
		$isTest = false;
		$site = $db->row("SELECT * FROM cody_site WHERE site_domain = '".$db->escape($host)."' OR site_domain = 'www.".$db->escape($host)."'");

		$config = getConfig();
		$rootTestDomain = $config->get("wizard", "root_test_domain");
		if (empty($site) && $rootTestDomain)
		{
			$pos = strpos($host, ".".$rootTestDomain);
			if ($pos !== false && strlen($host) == $pos + strlen(".".$rootTestDomain))
			{
				$host = substr($host, 0, $pos);
				$isTest = true;
				$site = $db->row("SELECT * FROM cody_site WHERE site_domain = '".$db->escape($host)."' OR site_domain = 'www.".$db->escape($host)."'");
			}
		}

		if (empty($site)) return false;

		self::$id = $site["site_id"];
		self::$accountId = $site["account_id"];
		self::$domain = $site["site_domain"];
		self::$path = $site["site_path"];
		self::$template = $site["site_template"];
		self::$isTest = $isTest;

		return true;
	}
	
}