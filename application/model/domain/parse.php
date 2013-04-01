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



ini_set("memory_limit", "512M");

require_once PATH_TABLES."parse.php";

class ParseDomain
{
	var $toDownload = array();
	
	function downloadPageWithElements($parseId)
	{
		if (empty($parseId)) return false;
		
		$this->download($parseId);
		$this->parse($parseId);

		$parseGateway = new ParseGateway;
		$ps = $parseGateway->findBy("parent_parse_id", $parseId);
		print_r($ps);
		foreach ($ps as $p)
		{
			$this->download($p["parse_id"]);
		}
	}

	function downloadAll()
	{
		$parseGateway = new ParseGateway;
		$parseGateway->orderBy = ' RAND()';
		$ps = $parseGateway->findAll();

		foreach ($ps as $p)
		{
			$this->download($p["parse_id"]);
			/*
			$this->parse($p["parse_id"]);

			if (is_array($this->toDownload))
			{
				while (count($this->toDownload))
				{
					$data = array_pop($this->toDownload);
					$this->download($data["parse_id"]);
					$this->parse($data["parse_id"]);
				}
			}*/
		}
	}


	function downloadNew()
	{
		$parseGateway = new ParseGateway;
		$parseGateway->orderBy = ' RAND()';
		$ps = $parseGateway->findBy('parse_file', '');

		foreach ($ps as $p)
		{
			if (!empty($p["parse_file"])) continue;
			
			$this->download($p["parse_id"]);
		}
	}

	function parse($parseId)
	{
		if (empty($parseId)) return false;

		$parseGateway = new ParseGateway;
		$p = $parseGateway->get($parseId);

		if (empty($p["parse_file"])) return false;

		if (strpos($p["parse_file"], ".gz") == (strlen($p["parse_file"]) - 3))
		{
			$zd = gzopen(PATH_FILES."parse/".$p["parse_file"], "r");
			$content = gzread($zd, 1000000);
			gzclose($zd);
		}
		else
		{
			$content = @file_get_contents(PATH_FILES."parse/".$p["parse_file"]);
		}

		if (empty($content)) return false;

		require_once PATH_TABLES."parse.php";
		$parseGateway = new ParseGateway;

		$urls = $this->mineUrls($content, 'all', $p["parse_url"]);
		//echo $content;
		//print_r($urls);exit;

		if (!empty($urls) && is_array($urls))
		foreach ($urls as $parse_url)
		{
			if (empty($parse_url)) continue;

			$count = $parseGateway->reportCountBy("parse_url", $parse_url);

			if (!empty($count)) continue;
			if (strlen($parse_url) > 255) continue;

			$data = array(
				"parent_parse_id" => $p["parse_id"],
				"parse_url" => $parse_url,
				"parse_content" => ""
			);

			$data["parse_id"] = $parseGateway->add($data);
			//array_push($this->toDownload, $data);
		}
	}

	function load($url)
	{		
		$url = html_entity_decode($url);

		return file_get_contents($url);
	}

	function download($parseId)
	{
		if (empty($parseId)) return false;

		$parseGateway = new ParseGateway;
		$p = $parseGateway->get($parseId);

		if (empty($p["parse_url"])) return false;

		//temporary do not upload existed files
		if (!empty($p["parse_file"])) return false;

		$url = $p["parse_url"];

		$file = $this->getFileName($url);

		//temporary do not upload existed files
		if (file_exists($file)) return false;

		$content = $this->load($url);

		$file = $this->getFileName($url);
		$this->saveFile(PATH_FILES."/parse/".$file, $content);

		$type = "";
		if (@is_array($http_response_header))
		foreach ($http_response_header as $h)
		{
			if (stripos($h, "Content-Type:") === false) continue;

			preg_match("/Content-Type:([^;]*);?/i", $h, $matches);

			if (!empty($matches[1]))
			{
				$type = trim($matches[1]);
			}
		}

		$title = "";
		preg_match("/\<title\>([^\<]*)\<\/title\>/i", $content, $matches);
		if (!empty($matches[1]))
		{
			$title = trim($matches[1]);
		}

		require_once PATH_TABLES."parse.php";

		$parseGateway = new ParseGateway;
		$parseGateway->edit($p["parse_id"], array(
		    "parse_file" => $file,
		    "parse_type" => $type,
		    "parse_updated" => date("Y-m-d H:i:s")
		));

		$parseGateway->edit($p["parse_id"], array(
		    "parse_title" => $title
		));
	}

	function getFileName($url)
	{
		if (strpos($url, "http://") === 0)
		{
			$url = substr($url, strlen("http://"));
		}
		if (strpos($url, "https://") === 0)
		{
			$url = substr($url, strlen("https://"));
		}

		if ($url[strlen($url) - 1] == "/")
		{
			$url .= "index";
		}

		$url = strtolower(str_replace(array(":", "?", "&amp;"), "-", $url));
		$md5 = md5($url);
		return substr($md5, 0, 2)."/".substr($md5, 2, 2)."/".$url;
	}

	function prepareDir($file)
	{
		$pos = 1;
		while ($pos = strpos($file, "/", $pos))
		{
			$dir = substr($file, 0, $pos);
			//echo "mkdir ".$dir."\r\n";
			@mkdir($dir, 0777);
			$pos = $pos + 1;
		}
	}

	function saveFile($file, $content)
	{
		if (empty($content)) return false;
		
		$this->prepareDir($file);
		echo $file."\t\n";
		return file_put_contents($file, $content);
	}

	function mineUrls($content, $type, $base)
	{
		$patterns = array(
			'all' => 'all',//'/(<[^<>]+(href|src)[ ]*=[ ]*["\'])([^"\']*)((#[^"\'>]+)?["\'])/iUS',
			'img' => '/(<img[^<>]+(src)[ ]*=[ ]*["\'])([^"\']*)((#[^"\'>]+)?["\'])/iUS',
			'a' => '/(<a[^<>]+(href)[ ]*=[ ]*["\'])([^"\']*)((#[^"\'>]+)?["\'])/iUS',
		        //'sitemap' => '/(<(loc)>(\/[^<]+)<\/(loc)>)/iUS',
			'sitemap' => '/(<(loc)>([^<]+)<\/(loc)>)/iUS',
			//'a_popup' => '/(window\.(open)\(\'([^\']*)\')/iUS',
			'css' => '/(<link[^<>]+(href)[ ]*=[ ]*["\'])([^"\']*)((#[^"\'>]+)?["\'])/iUS',
			'js' => '/(<script[^<>]+(src)[ ]*=[ ]*["\'])([^"\']*)((#[^"\'>]+)?["\'])/iUS',
			'img_css' => '/(\s*(url)\(["\']?([^\)]*)["\']?\))/iUS',
			'img_js' => '/((["\'])([^"\']*\.(swf|png|css))["\'])/iUS',
		);

		if (empty($patterns[$type])) return array();

		$base_url = parse_url($base);
		
		$base_path = "/";
		$pos = @strrpos($base_url["path"], "/");
		if ($pos !== false && $pos != 0)
		{
			$base_path = substr($base_url["path"], 0, $pos)."/";
		}
		
		$matches = array();
		if ($patterns[$type] == 'all')
		{
			$matches[3] = array();
			$matches_loop = array();
			foreach ($patterns as $pattern)
			{
				if ($pattern == 'all') continue;

				preg_match_all($pattern, $content, $matches_loop);

				if (!empty($matches_loop[3]))
				{
					$matches[3] = array_merge($matches[3], $matches_loop[3]);
				}
			}
		}
		else
		{
			preg_match_all($patterns[$type], $content, $matches);
		}

		$result = array();
		if (!empty($matches[3]) && is_array($matches[3]))
		foreach ($matches[3] as $m)
		{
			if (stripos($m, "javascript") !== false) continue;

			$m = trim($m, "'");
			$m = trim($m, '"');

			$url = @parse_url($m);

			$parse_url = "";
			if (empty($url["host"]) && strpos($m, "//") !== 0)
			{
				if (!empty($m) && $m[0] == "/")
				{
					$parse_url = $base_url["scheme"]."://".$base_url["host"].$m;
				}
				elseif (!empty($m) && $m[0] == "?")
				{
					$parse_url = $base_url["scheme"]."://".$base_url["host"].$base_url["path"].$m;
				}
				else
				{
					$parse_url = $base_url["scheme"]."://".$base_url["host"].$base_path.$m;
				}
			}
			elseif ($url["host"] == $base_url["host"])
			{
				$parse_url = $m;
			}
			elseif (strpos($url["host"], str_replace("www.", ".", $base_url["host"])) !== false)
			{
				$parse_url = $m;
				if (empty($url["path"]))
				{
					$parse_url .= "/";
				}
			}

			if (false)
			{
				$parse_url = $parse_url . ":::referer:::" . $base;
			}

			$result[$m] = $parse_url;
		}


		return $result;
	}
}