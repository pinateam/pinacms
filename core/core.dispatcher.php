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



$config_dispatcher = array();

function dispatch($page)
{
    include PATH."config/config.dispatcher.php";

    require_once PATH_TABLES."url.php";
    $urlGateway = new UrlGateway;
    $data = $urlGateway->getBy("url_key", $page);

    if ($data)
    {
	    $result = array("action" => $data["url_action"]);
	    $params= explode('&', $data["url_params"]);
	    foreach ($params as $param)
	    {
		    $t = explode("=", $param);
		    $result [$t[0]] = $t[1];
	    }
	    return $result;
    }

    $result = array();
    foreach ($config_dispatcher as $rule)
    {
        if (empty($rule["pattern"])) continue;
        $pattern = dispatch_getPattern($rule["pattern"]);

        if (!preg_match("/".$pattern."/", $page, $values)) continue;

        array_shift($values);
        preg_match_all("/{(\w*):/", $rule["pattern"], $matches);
        $titles = $matches[1];

        $result = $rule;
	unset($result["pattern"]);
        foreach ($titles as $pos => $title)
        {
            $result[$title] = $values[$pos];
        }

        return $result;
    }

    $result = array(
        "action" => "access-denied"
    );

    return $result;
}

function dispatch_getPattern($pattern)
{
    $pattern = str_replace(".", "\.", $pattern);
    $pattern = str_replace("/", "\/", $pattern);
    $pattern = preg_replace("/{\w*:/", "(:", $pattern);
    $pattern = str_replace(":any}", ".*)", $pattern);
    $pattern = str_replace(":num}", "\d*)", $pattern);
    $pattern = str_replace(":str}", "\w*)", $pattern);
    return $pattern;
}

function url_rewrite($content, $onlyAHref = true)
{
	if (defined("SIMPLE_URL")) return $content;
	#return preg_replace_callback('/(<a[^<>]+href[ ]*=[ ]*["\'])([^"\']*page.php)\?(action=[^"\'>]+)((#[^"\'>]+)?["\'])/iUS', "url_rewrite_callback", $content);
	if($onlyAHref)
        {
                preg_match_all('/<a[^<>]+href[ ]*=[ ]*["\']([^"\']*page.php)\?(action=([^&^"^\']*?)[&]*?([^"\'>]*?))(#[^"\'>]+)?["\']/iUS', $content, $matches);
        }
        else
        {
                preg_match_all('/([^"\']*page.php)\?(action=([^&^"^\']*?)[&]*?([^"\'>]*?))["\']?/iUS', $content, $matches);
        }
	$replaces = array();

	$domain = Site::domain();
	if (empty($domain)) $domain = SITE_HOST;

	if (is_array($matches))
	foreach ($matches[0] as $k => $v)
	{
		if (trim($matches[1][$k], "/") != "page.php" && strpos($matches[1][$k], "://".$domain."/") === false)
		{
			continue;
		}

		$key = md5($matches[3][$k].":".$matches[4][$k]);
		$replaces[$key] = array(
		    "from" => $v,
		    "action" => $matches[3][$k],
		    "params" => $matches[4][$k]
		);
	}

	$db = getDB();
	$sql = "";
	foreach ($replaces as $v)
	{
		if (!empty($sql)) $sql .= " OR ";
		$sql .= " (url_action = '".$db->escape($v["action"])."' AND url_params = '".$v["params"]."')";
        }

	if (!empty($sql))
	{
		$useCache = class_exists("Memcache") && defined("MEMCACHE_HOST") && MEMCACHE_HOST;
		if ($useCache)
		{
			$memcache = new Memcache;
			$memcache->pconnect(MEMCACHE_HOST);

			$_key = "sql:url:".md5($sql);

			$_cached = $memcache->get($_key);
		}

		if (!empty($_cached))
		{
			$data = unserialize($_cached);
		}
		else
		{
			
			$data = $db->table("SELECT * FROM cody_url WHERE site_id = '".Site::id()."' AND (".$sql.")");
			

			

			if ($useCache)
			{
				$memcache->set($_key, serialize($data));
			}
		}
		if (is_array($data))
		foreach ($data as $v)
		{
			$key = md5($v["url_action"].":".$v["url_params"]);
			$replaces[$key]["to"] = $v["url_key"];
		}
	}

	include PATH."config/config.dispatcher.php";

	foreach ($replaces as $hash => $replace)
	{
		if (!empty($replace["to"])) continue;
		foreach ($config_dispatcher as $rule)
		{
			if ($replace["action"] == $rule["action"])
			{
				$ps= explode('&', $replace["params"]);
				$params = array();
				if (is_array($ps))
				foreach ($ps as $param)
				{
					if (empty($param)) continue;
					$t = explode("=", $param);
					$params[$t[0]] = @$t[1];
				}
				preg_match_all("/{([^:]*):/i", $rule["pattern"], $matches);
				$rule_params = $matches[1];

				$diff = array_diff(
					array_merge(array_keys($params), $rule_params),
					array_intersect(array_keys($params), $rule_params)
				);

				if (count($diff) == 0)
				{
					$pattern = str_replace(array(":any}", ":num}", ":str}"), "}", $rule["pattern"]);
					$from = array();
					$to = array();
					foreach ($params as $k => $v)
					{
						$from [] = "{".$k."}";
						$to [] = $v;
					}
					$replaces[$hash]["to"] = str_replace($from, $to, $pattern);
				}
			}
		}
	}

	$from = array();
	$to = array();

	$base_url = Site::baseUrl();

	foreach ($replaces as $v)
	{
		if (!isset($v["to"])) continue;
		
		$from [] = $v["from"];

                if($onlyAHref)
                {
                        $pos = strpos($v["from"], "href=");
                        $to [] = substr($v["from"], 0, $pos).'href="'.$base_url.$v["to"].(!empty($v["to"])?'.html':'').'"';
                }
                else
                {
                        $pos = 0;
                        $to [] = substr($v["from"], 0, $pos).$base_url.$v["to"].(!empty($v["to"])?'.html':'');
                }		
	}

	return str_replace($from, $to, $content);
}