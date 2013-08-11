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



function getColumn(&$data, $name, $key = false)
{
	$result = array();

	if (is_array($data))
	foreach ($data as $d)
	{
		if (empty($key))
		{
			$result [] = $d[$name];
		}
		else
		{
			$result [$d[$key]] = $d[$name];
		}
	}

	return $result;
}

function joinData($data, $join, $name, $id = "id")
{
    if (empty($data) || empty($join) || empty($name)) return $data;

    foreach ($data as $k=>$v)
    {
        if (isset($join[$v[$id]]))
        {
            $data[$k][$name] = $join[$v[$id]];
        }
    }
    return $data;
}

function merge($a1, $a2)
{
    if (is_array($a1) && is_array($a2)) return array_merge($a1, $a2);
    if (is_array($a1) && !is_array($a2)) return $a1;

    return $a2;
}

function redirect($location = SITE)
{
	global $_SERVER;
	global $session;

	if (isset($session))
	{
		$session->save();

		if (!empty($session->id) && !isset($HTTP_COOKIE_VARS[$session->name]) && !eregi($session->name."=", $location)) {
			$location .= ((strpos($location, '?') != false)?'&':'?').$session->name."=".$session->id;
		}
	}

	@header("Location: ".$location);
	if (strpos($_SERVER["HTTP_USER_AGENT"],'Opera')!==false || @preg_match("/Microsoft|WebSTAR|Xitami/", getenv("SERVER_SOFTWARE"))) {
		@header("Refresh: 0; URL=".$location);
	}

	echo "<META http-equiv=\"Refresh\" content=\"0;URL=$location\">";

	flush();
	exit();
}

function sendMail($email, $subject, $message)
{
	if (empty($email)) return;

	$lend = "\r\n";
	$headers = "From: ".MAIL_REPLY.$lend."X-Mailer: PHP/".phpversion().$lend."MIME-Version: 1.0".$lend;
	$headers .= "Content-Type: text/plain; charset=".MAIL_CHARSET.$lend;
	$headers .= "Content-Disposition: inline".$lend."Content-Transfer-Encoding: 8bit".$lend;
	
	if (MAIL_DEBUG)
	{
		static $mail_debug_counter = 0;
		if (!file_exists(PATH_DEBUG)) @mkdir(PATH_DEBUG, 0777);
		$f = fopen(PATH_DEBUG."email-".time().($mail_debug_counter++).".txt", "w");
		fwrite($f, "headers: \r\n".$headers);
		fwrite($f, "\r\ntarget: \r\n".$email);
		fwrite($f, "\r\nsubject: \r\n".$subject);
		fwrite($f, "\r\nmessage: \r\n".$message);
		fclose($f);
	}

	if (preg_match('/([^ @,;<>]+@[^ @,;<>]+)/S', MAIL_REPLY, $m))
		return @mail($email,$subject,$message,$headers, "-f".$m[1]);
	else
		return @mail($email,$subject,$message,$headers);
}

function href_constructParams($params)
{
	$request = '';
	
	if (is_array($params))
	{
		foreach ($params as $name => $value)
		{
			if ($name == "action" || $name == "api" || $name == "anchor") continue;
			
			if (!is_array($value))
			{
				$request .= '&'.$name.'='.$value;
			}
			else
			{
				foreach ($value as $val)
				{
					$request .= '&'.$name.'[]='.$val;
				}
			}
		}
	}
	
	return $request;
}

function href($params = array())
{
    if (empty($params['action']) && empty($params['api'])) return '';

    $base_url = Site::baseUrl();

    
    if (!empty($params["site_id"]))
    {
	    $base_url = Site::baseUrl($params["site_id"], isset($params["site_test"])?$params["site_test"]:NULL);
	    unset($params["site_id"]);
	    unset($params["site_test"]);
    }
    

    if (!empty($params['api']))
    {
        return $base_url.'api.php?action='.$params["api"].href_constructParams($params).(!empty($params["anchor"])?("#".$params["anchor"]):"");
    }

    if (!defined("SIMPLE_URL"))
    {
        global $config_dispatcher;

        $tmp = $params;
        unset($tmp["anchor"]);

        if (is_array($config_dispatcher))
        foreach ($config_dispatcher as $k=>$rule)
        {
            if ($rule["action"] != $tmp["action"]) continue;

            unset($rule["pattern"]);

            $hardPattern = strpos($config_dispatcher[$k]["pattern"], "{") !== false;
            $needToAddress = array_diff($tmp, $rule);

            if (!$needToAddress && !$hardPattern)
            {
                return SITE.$config_dispatcher[$k]["pattern"].(!empty($params["anchor"])?("#".$params["anchor"]):"");
            }

            if ($hardPattern)
            {
                preg_match_all("/{([\w]*):/", $config_dispatcher[$k]["pattern"], $matches);
                if (array_diff($matches[1], array_keys($tmp))) continue;
                if (array_diff(array_keys($needToAddress), $matches[1])) continue;

                $keys = array("any}", "num}", "str}");
                $vals = array("", "", "");
                foreach ($matches[1] as $kk)
                {
                    $keys[] = "{".$kk.":";
                    $vals[] = $tmp[$kk];
                }
                $url = str_replace($keys, $vals, $config_dispatcher[$k]["pattern"]);
                if (strpos($url, "{") === false) return $url.(!empty($params["anchor"])?("#".$params["anchor"]):"");
            }
        }
    }

	return $base_url.'page.php?action='.$params["action"].href_constructParams($params).(!empty($params["anchor"])?("#".$params["anchor"]):"");
}

function use_base_params($params)
{
	if (!empty($params["base"]) && is_array($params["base"]) && count($params["base"]))
	{
		$params = array_merge($params["base"], $params);
		unset($params["base"]);
	}
	elseif (!empty($params["base"]) && !is_array($params["base"]))
	{
		$base = array();
		parse_str($params["base"], $base);
		$params = array_merge($base, $params);
		unset($params["base"]);
	}
	elseif (isset($params["base"]) && empty($params["base"]))
	{
		unset($params["base"]);
	}

	return $params;
}


function pingDomain($domain)
{
	if (empty($domain)) return false;

	$hp = explode(':', $domain);

	if (!isset($hp[0])) return false;

	$host = $hp[0];
	$port = isset($hp[1])?$hp[1]:'80';

	$errno = '';
	$errstr = '';

	$handle = @fsockopen($host, $port, $errno, $errstr, 30);
	if ($handle)
	{
		fclose($handle);
		return true;
	}
	return false;
}

function isEmail($email)
{
	if (empty($email)) return false;
	@list($user, $domain) = @explode('@', $email);
	if (empty($user) || empty($domain)) return false;
	
	$regexp = "^[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z](?:[a-z0-9-]*[a-z0-9])?$";

	return preg_match("/".$regexp."/Di", stripslashes($email));
}

function imgName($subject, $name)
{
	return SITE_IMAGES.$subject."/".substr($name, 0, 2)."/".substr($name, 2, 2)."/".$name;
}

function fileUrl($path, $name)
{
	return SITE.$path.substr($name, 0, 2)."/".substr($name, 2, 2)."/".$name;
}

function filePath($path, $name)
{
	return PATH.$path.substr($name, 0, 2)."/".substr($name, 2, 2)."/".$name;
}

function passwordHash($password)
{
	$salt = substr(str_replace('+', '.', base64_encode(sha1(microtime(true), true))), 0, 22);
	return crypt($password, '$2a$12$' . $salt);
}

function passwordVerify($password, $hash)
{
	return $hash == crypt($password, $hash);
}

function randomToken()
{
	return md5(rand().time());
}

function ass($condition, $message)
{
	if (!$condition)
	{
		dump(debug_backtrace(), $message);
	}
}

class ChoosyStack
{
	private $data = array();
	public function push($data)
	{
		if (empty($data)) return false;

		array_push($this->data, $data);

		return true;
	}

	public function pop()
	{
		if (empty($this->data)) return false;

		return array_pop($this->data);
	}

	public function fetch()
	{
		return $this->data;
	}
}

function dump($dump, $title = '')
{
	echo "<hr />";
	if ($title) echo "<h3>".$title."</h3>";
	echo "<pre>";
	print_r($dump);
	echo "</pre>";
}

function es($s)
{
	return mysql_real_escape_string($s);
}

function doMagicQuotesGpc()
{
	global $_POST, $_GET;
	if (ini_get("magic_quotes_gpc"))
	{
		foreach ($_POST as $k=>$v)
		{
			if (is_string($_POST[$k]))
			{
				$_POST[$k] = stripslashes($_POST[$k]);
			}
		}

		foreach ($_GET as $k=>$v)
		{
			if (is_string($_GET[$k]))
			{
				$_GET[$k] = stripslashes($_GET[$k]);
			}
		}
	}
}

function cleanInput()
{
	$input = loadCILibrary("Input");
}

function loadCILibrary($name)
{
	static $libraries;

	if (isset($libraries[$name]))
	{
		return $libraries[$name];
	}

	if (!defined("BASEPATH")) define('BASEPATH', PATH);

	require_once PATH_LIB."ci/".$name.".php";
	$className = "CI_".$name;
	$libraries[$name] = new $className;
	return $libraries[$name];
}

function mineArray($subject, $a)
{
	if (!is_array($a)) return false;
	if (empty($subject)) return $a;

	$l = strlen($subject);

	$r = array();
	foreach ($a as $k => $v)
	{
		if (strpos($k, $subject) === 0)
		{
			$r[substr($k, $l)] = $v;
		}
	}
	return $r;
}

function mineSubArray($subject, $a)
{
	if (!is_array($a)) return false;
	if (empty($subject)) return $a;

	$l = strlen($subject);

	$r = array();
	foreach ($a as $k => $v)
	{
		if (strpos($k, $subject) === 0)
		{
			$r[trim(substr($k, $l), "_")] = $v;
			unset($a[$k]);
		}
	}
	$a[trim($subject, "_")] = $r;
	return $a;
}

function isModuleActive($module)
{
	static $default_modules = array(
		"system",
		"home", "dashboard", "access-denied", "fatal-error", "version",
	        "image", "string",
		"config", "module", "cart", "user", "post"
	);

	static $enabled_modules = false;
	static $disabled_modules = false;

	if ($enabled_modules === false)
	{
		$enabled_modules = array();
		$disabled_modules = array();

		$db = GetDB();
		
		$modules = $db->table("SELECT module_key, module_enabled FROM cody_module WHERE site_id = '".Site::id()."'");
		

		
		foreach ($modules as $v)
		{
			if ($v["module_enabled"] == 'Y')
			{
				$enabled_modules [] = $v["module_key"];
			}
			else
			{
				$disabled_modules [] = $v["module_key"];
			}
		}

		$enabled_modules = array_merge($default_modules, $enabled_modules);
	}

#	echo $module;
#	echo "DISABLED: ";
#	print_r($disabled_modules);
#	echo "ENABLED: ";
#	print_r($enabled_modules);

	while ($pos = strrpos($module, "."))
	{
		if (in_array($module, $disabled_modules)) return false;
		if (in_array($module, $enabled_modules)) return true;

		$module = substr($module, 0, $pos);
	}

	if (in_array($module, $disabled_modules)) return false;
	if (in_array($module, $enabled_modules)) return true;

	return false;

}

// отличие функции проверяющей права от функции проверяющей включенность модуля состоит в том, что
// по умолчанию считается, что к модулю с непроставленными правами может иметь доступ любой
// основание для запрета доступа к модулю, если явно не указаны права для этой группы:
// - если права на доступ к модулю выданы кому-то еще
function isModulePermitted($module)
{
	$db = getDB();

	static $as = false;
	static $agids = array();

	if ($as === false)
	{
		$as = $db->table("SELECT a.module_key, access_group_id, a.access_enabled FROM cody_access a");
	}

	
	$siteId = Site::id();
	$agid = 0;
	if (Session::get('auth_user_id'))
	{
		if (isset($agids[$siteId][Session::get('auth_user_id')]))
			$agid = $agids[$siteId][Session::get('auth_user_id')];
		else
		{
			require_once PATH_TABLES."user.php";
			$userGateway = new UserGateway;
			$agid = $agids[$siteId][Session::get('auth_user_id')] = $userGateway->reportAccessGroupIdByUserId(Session::get('auth_user_id'));
		}
	}

	

	

	$enabled_modules = array();
	$disabled_modules = array();
	foreach ($as as $a)
	{
		if ($a["access_group_id"] == $agid && $a["access_enabled"] == "Y")
		{
			$enabled_modules [] = $a["module_key"];
		}

		if ($a["access_group_id"] == $agid && $a["access_enabled"] == "N")
		{
			$disabled_modules [] = $a["module_key"];
		}

		if ($a["access_group_id"] != $agid)
		{
			$disabled_modules [] = $a["module_key"];
		}
	}

#	echo "DISABLED: ";
#	print_r($disabled_modules);
#	echo "ENABLED: ";
#	print_r($enabled_modules);

	while ($pos = strrpos($module, "."))
	{
#		echo $module.":";

#		if (in_array($module, $enabled_modules)) echo "yes";
#		if (in_array($module, $disabled_modules)) echo "no";

		if (in_array($module, $enabled_modules)) return true;
		if (in_array($module, $disabled_modules)) return false;

		$module = substr($module, 0, $pos);
	}

	if (in_array($module, $enabled_modules)) return true;
	if (in_array($module, $disabled_modules)) return false;

	return true;
}

function getGatewayClassName($filename, $postfix = 'Gateway')
{
	$gatewayClassName = str_replace('.php', '', $filename) . $postfix;
	$gatewayClassName = strtoupper($gatewayClassName{0}).substr($gatewayClassName, 1, strlen($gatewayClassName));

	while($pos = strpos($gatewayClassName, '_'))
	{
		$gatewayClassName = substr_replace($gatewayClassName, '', $pos, 1);
		$gatewayClassName{$pos} = strtoupper($gatewayClassName{$pos});
	}
	$gatewayClassName = str_replace('_', '', $gatewayClassName);

	return $gatewayClassName;
}

function lng_rewrite($content)
{
	preg_match_all('/#\$\!([^#^\$^\!]*)\!\$#/iUS', $content, $matches);
	if (empty($matches[0])) return $content;

	$db = getDB();
	$ss = $db->table
	("
		SELECT string_key, string_value
		FROM cody_string WHERE string_key IN ('".join("','", $matches[1])."') AND
			language_code = '".Language::code()."'"
	);

	$from = array();
	$to = array();
	foreach ($ss as $s)
	{
		$from [] = "#$!".$s["string_key"]."!$#";
		$to [] = $s["string_value"];
	}

	$content = str_replace($from, $to, $content);
	return $content;
}

function lng_rewrite_cached($content)
{
	preg_match_all('/#\$\!([^#^\$^\!]*)\!\$#/iUS', $content, $matches);
	if (empty($matches[0])) return $content;

	$lng = getLanguage();

	$from = array();
	$to = array();
	foreach ($matches[1] as $s)
	{
		$from [] = "#$!".$s."!$#";
		$to [] = $lng->get('', $s);
	}

	$content = str_replace($from, $to, $content);
	return $content;
}

function lng_key($key)
{
	return "#$!".$key."!$#";
}

function lng($key)
{
	$db = getDB();
	$value = $db->one("SELECT string_value FROM cody_string WHERE string_key = '".$key."'
		AND language_code = '".Language::code()."'");

	if (empty($value)) return lng_key($key);

	return $value;
}

function format_price($price, $html = false)
{
	$config = getConfig();
	$format = $config->get("order", "price_format");
	if (empty($format)) $format = '%';

	if ($html)
	{
		$price = sprintf("%.02f", $price);
		$tmp = explode(".", $price);
		$price = '';
		if (isset($tmp[0])) $price .= $tmp[0];
		if (isset($tmp[1])) $price .= '<sup>'.$tmp[1].'</sup>';
		$price = '<span class="value">'.$price."</span>";

		$formatArr = explode("%", $format);
		foreach ($formatArr as $k => $v)
		{
			if (empty($v)) continue;
				
			$formatArr[$k] = '<span class="currency">'.trim($v).'</span>';
		}

		$price = join($price, $formatArr);

	}
	else
	{
		$price = str_replace("%", sprintf("%.02f", $price), $format);
	}

	return $price;
}

function filter_only_positive($v)
{
	return $v < 0 ? 0 : $v;
}

function filter_only_y_n($v)
{
	return $v != 'Y' ? 'N' : 'Y';
}

function filter_dotted_price($v)
{
	return str_replace(',', '.', $v);
}

function filter_http($v)
{
	if (strpos(strtolower($v), 'http://') !== 0 && !empty($v))
	{
		$v = 'http://'.$v;
	}
	return $v;
}

function filter_datetime($v)
{
	$config = getConfig();
	$df = $config->get("appearance", "date_format");
	if (empty($df)) $df = "d.m.Y";
	
	$tf = $config->get("appearance", "time_format");
	if (empty($tf)) $tf = "H:i";

	$data = parseByDataTimeFormat($df." ".$tf, $v);

	if (empty($data["Y"]))
	{
		$data["Y"] = date("Y");
	}
	if (!isset($data["H"]) && isset($data["h"]) && isset($data["A"]))
	{
		if (strcasecmp($data["A"], "PM") == 0) $data["H"] = $data["h"] + 12;
	}

	if (!isset($data["H"]) && isset($data["h"]))
	{
		$data["H"] = $data["h"];
	}

	if (!isset($data["s"])) $data["s"] = 0;

	return date("Y-m-d H:i:s", mktime($data["H"], $data["i"], $data["s"], $data["m"], $data["d"], $data["Y"]));
}

function parseByDataTimeFormat($f, $v)
{
	$base = array("d", "m", "Y", "H", "h", "i", "s", "A");
	$vals = array("(\d+)", "(\d+)", "(\d+)", "(\d+)", "(\d+)", "(\d+)", "(\d+)", "(\w+)");

	$f_pattern = $f;
	$f_pattern = str_replace(array("/", ".", ":", " "), array("\/", "\.", "\:", "[ ]+"), $f_pattern);
	$f_pattern = str_replace($base, $vals, $f_pattern);
	$f_pattern = "/".$f_pattern."/si";

	preg_match($f_pattern, $v, $f_matches);

	//print_r($f_matches);

	$f_base_pattern = $f;
	$f_base_pattern = str_replace(array("/", ".", ":"), array("\/", "\.", "\:"), $f_base_pattern);
	$f_base_pattern = str_replace($base, "(\w)", $f_base_pattern);
	$f_base_pattern = "/".$f_base_pattern."/si";

	preg_match($f_base_pattern, $f, $f_base_matches);

	//print_r($f_base_matches);

	$parsed = array();
	foreach ($f_matches as $k => $temp)
	{
		$parsed[$f_base_matches[$k]] = $temp;
	}
	return $parsed;
}

function parseDate($str)
{
	$str  = trim($str);
	@list($date, $time) = explode(" ", $str);
	
	if (empty($date) && empty($time)) return 0;
	
	@list($day, $month, $year) = explode(".", $date);
	
	if (empty($year)) $year = date("Y");
	
	@list($hour, $min, $sec) = explode(":", $time);
	if (empty($sec)) $sec = 0;
	
	#print_r(array((int)$hour, (int)$min, (int)$sec, (int)$month, (int)$day, (int)$year));
	
	return mktime((int)$hour, (int)$min, (int)$sec, (int)$month, (int)$day, (int)$year);
}



	$_1_2[1]="одна "; $_1_2[2]="две "; $_1_19[1]="один "; $_1_19[2]="два "; $_1_19[3]="три "; $_1_19[4]="четыре "; $_1_19[5]="пять "; $_1_19[6]="шесть "; $_1_19[7]="семь "; $_1_19[8]="восемь "; $_1_19[9]="девять "; $_1_19[10]="десять "; $_1_19[11]="одиннацать "; $_1_19[12]="двенадцать "; $_1_19[13]="тринадцать "; $_1_19[14]="четырнадцать ";
	$_1_19[15]="пятнадцать "; $_1_19[16]="шестнадцать "; $_1_19[17]="семнадцать "; $_1_19[18]="восемнадцать "; $_1_19[19]="девятнадцать "; $des[2]="двадцать ";

	$des[3]="тридцать "; $des[4]="сорок "; $des[5]="пятьдесят "; $des[6]="шестьдесят "; $des[7]="семьдесят "; $des[8]="восемдесят "; $des[9]="девяносто "; $hang[1]="сто ";
	$hang[2]="двести "; $hang[3]="триста "; $hang[4]="четыреста "; $hang[5]="пятьсот "; $hang[6]="шестьсот "; $hang[7]="семьсот "; $hang[8]="восемьсот "; $hang[9]="девятьсот ";

	$namerub[1]="рубль "; $namerub[2]="рубля "; $namerub[3]="рублей "; $nametho[1]="тысяча "; $nametho[2]="тысячи "; $nametho[3]="тысяч ";

	$namemil[1]="миллион "; $namemil[2]="миллиона "; $namemil[3]="миллионов "; $namemrd[1]="миллиард "; $namemrd[2]="миллиарда "; $namemrd[3]="миллиардов ";	$kopeek[1]="копейка "; $kopeek[2]="копейки "; $kopeek[3]="копеек ";

	function semantic($i,&$words,&$many,$f)
	{
		global $_1_2, $_1_19, $des, $hang, $namerub, $nametho, $namemil, $namemrd;
		$words="";
		$fl=0;

		if($i >= 100)
		{
		  $jkl = intval($i / 100);
		  $words.=$hang[$jkl];
		  $i%=100;
		}

		if($i >= 20)
		{
		  $jkl = intval($i / 10);
		  $words.=$des[$jkl];
		  $i%=10;
		  $fl=1;
		}

		switch($i)
		{
		  case 1: $many=1; break;
		  case 2:
		  case 3:
		  case 4: $many=2; break;
		  default: $many=3; break;
		}

		if($i)
		{
		  if($i < 3 && $f == 1)
		   $words.=$_1_2[$i];
		  else
		   $words.=$_1_19[$i];
		}
	}

	function num2str($L, $first_upper = false)
	{
		global $_1_2, $_1_19, $des, $hang, $namerub, $nametho, $namemil, $namemrd, $kopeek;

		$s=" ";
		$s1=" ";
		//считаем количество копеек, т.е. дробной части числа
		$kop=intval(( $L*100 - intval($L)*100 ));
		//отбрасываем дробную часть
		$L=intval($L);

		if($L>=1000000000)
		{
		  $many=0;
		  semantic(intval($L / 1000000000),$s1,$many,3);
		  $s.=$s1.$namemrd[$many];
		  $L%=1000000000;
		  //если ровно сколько-то миллиардов, то хватит считать
		  if($L==0)
		  {
		   $s.="рублей ";
		  }
		}

		if($L >= 1000000)
		{
		  $many=0;
		  semantic(intval($L / 1000000),$s1,$many,2);
		  $s.=$s1.$namemil[$many];
		  $L%=1000000;
		  //аналогично если ровно сколько-то миллионов, то хватит считать
		  if($L==0)
		  {
		   $s.="рублей ";
		  }
		}

		if($L >= 1000)
		{
		  $many=0;
		  semantic(intval($L / 1000),$s1,$many,1);
		  $s.=$s1.$nametho[$many];
		  $L%=1000;
		  if($L==0)
		  {
		   $s.="рублей ";
		  }
		}


		if($L != 0)
		{
		  $many=0;
		  semantic($L,$s1,$many,0);
		  $s.=$s1.$namerub[$many];
		}

		//Копейки цифрами. Чтоб были буквами - эти две строки убрать, а предыдущие раскоментировать
		semantic($kop,$s1,$many,1);
		$s .= $kop.'0 '.$kopeek[$many];

		mb_internal_encoding("UTF-8");
		if ($first_upper&&strlen($s)>0) $s = mb_strtoupper(mb_substr($s, 1, 1)) . mb_substr($s, 2);

		return trim($s);
	}

	function prepareDir($file)
	{
		$pos = 1;
		while ($pos = strpos($file, "/", $pos))
		{
			$dir = substr($file, 0, $pos);
			//echo "mkdir ".$dir."\r\n";
			@mkdir($dir, 0777);
                        //@chmod($dir, 0777);
			$pos = $pos + 1;
		}
	}
        
        function fileExistsByUrl($url)
        {
                $headers = @get_headers($url);
                // проверяем ли ответ от сервера с кодом 200 - ОК
                if(strpos($headers[0], '200') !== false) 
                {
                        return true;
                }
                
                return false;
        }
        
        function getFiles($dir, $extension = '')
        {
                if(!file_exists($dir))
                {
                    return false;
                }
                
                $dh  = opendir($dir);
                $files = array();
                while (false !== ($filename = readdir($dh)))
                {
                        if(($filename == '.') || ($filename == '..') || (is_dir($dir.$filename)))
                        {
                                continue;
                        }
                        $path_parts = pathinfo($dir . $filename);
                        if($path_parts['extension'] == $extension)
                        {
                                $files[] = $filename;
                        }
                }
                return $files;
        }

        function extractZip($extractDir, $zipFile)
        {
                $zipArchive = new ZipArchive();
                if(!$zipArchive->open($zipFile))
                {
                        return false;
                }

                $zipArchive->extractTo($extractDir);
                $zipArchive->close();
        }

        function base64UrlDecode($input) 
		{
			return base64_decode(strtr($input, '-_', '+/'));
 		}
 
		function parseSignedRequest($signed_request, $secret) 
		{
			list($encoded_sig, $payload) = explode('.', $signed_request, 2);

			// decode the data
			$sig = base64UrlDecode($encoded_sig);
			$data = json_decode(base64UrlDecode($payload), true);

			if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
				return null;
			}

			// check sig
			$expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
				if ($sig !== $expected_sig) {
				error_log('Bad Signed JSON signature!');
				return null;
			}
 
			return $data;
		}

		function prepareIntElem($elem)
		{
			return (int)$elem;
		}