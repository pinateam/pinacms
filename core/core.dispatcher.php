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

    $db = getDB();
    $data = $db->row("SELECT * FROM cody_url WHERE site_id = '".Site::id()."' AND url_key = '".$page."'");
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

function url_rewrite($content)
{
	#return preg_replace_callback('/(<a[^<>]+href[ ]*=[ ]*["\'])([^"\']*page.php)\?(action=[^"\'>]+)((#[^"\'>]+)?["\'])/iUS', "url_rewrite_callback", $content);
	preg_match_all('/(<a[^<>]+href[ ]*=[ ]*["\'])([^"\']*page.php)\?(action=([^&^"^\']*?)[&]*?([^"\'>]*?))((#[^"\'>]+)?["\'])/iUS', $content, $matches);
	$replaces = array();

	$domain = Site::domain();
	if (empty($domain)) $domain = SITE_HOST;

	if (is_array($matches))
	foreach ($matches[0] as $k => $v)
	{
		if (trim($matches[2][$k], "/") != "page.php" && strpos($matches[2][$k], "://".$domain."/") === false)
		{
			continue;
		}

		$key = md5($matches[4][$k].":".$matches[5][$k]);
		$replaces[$key] = array(
		    "from" => $v,
		    "action" => $matches[4][$k],
		    "params" => $matches[5][$k]
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
		$data = $db->table($q = "SELECT * FROM cody_url WHERE site_id = '".Site::id()."' AND (".$sql.")");
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

	$base_url = Site::baseUrl(Site::id());

	foreach ($replaces as $v)
	{
		if (!isset($v["to"])) continue;
		
		$from [] = $v["from"];

		$pos = strpos($v["from"], "href=");
		$to [] = substr($v["from"], 0, $pos).'href="'.$base_url.$v["to"].(!empty($v["to"])?'.html':'').'"';
	}

	return str_replace($from, $to, $content);
}