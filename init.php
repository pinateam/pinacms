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

    define('PATH', dirname(__FILE__).'/');
    define('PATH_CONFIG', PATH.'config/');

    require_once PATH_CONFIG."config.server.php";
    require_once PATH_CONFIG."config.path.php";

    include_once PATH_CORE."core.php";
    include_once PATH_CORE."core.db.php";
    include_once PATH_CORE."core.session.php";

    include_once PATH_CORE."classes/BaseConfig.php";
    include_once PATH_CORE."classes/Config.php";
    include_once PATH_CORE."classes/Language.php";
    include_once PATH_CORE."classes/Site.php";

    include_once PATH_CORE."validation.core.php";
    include_once PATH_VALIDATION."validation.user.php";
    include_once PATH_VALIDATION."validation.post.php";

    Session::init(!empty($_POST["sssid"])?$_POST["sssid"]:false);
	
    mb_internal_encoding(SITE_CHARSET);
    mb_regex_encoding(SITE_CHARSET);

    if (function_exists('date_default_timezone_set'))
    {
        date_default_timezone_set(SITE_TIMEZONE);
    }

    
    if (!empty($_POST["site_id"]) || !empty($_GET["site_id"]))
    {
	    $siteId = !empty($_POST["site_id"])?$_POST["site_id"]:$_GET["site_id"];
	    if (!Site::initById($siteId))
	    {
		    require_once PATH_CONTROLLERS."access-denied.php";
		    exit;
	    }
    }
    elseif (!Site::initByPath(
	    !empty($_SERVER["HTTP_HOST"])?$_SERVER["HTTP_HOST"]:SITE_HOST,
	    !empty($_SERVER["REQUEST_URI"])?$_SERVER["REQUEST_URI"]:SITE_PATH))
    {
	    require_once PATH_CONTROLLERS."access-denied.php";
	    exit;
    }
    

    $config = getConfig();

$l = $config->get('core', 'language_code');
if (empty($l) && defined("DEFAULT_LANGUAGE_CODE") && DEFAULT_LANGUAGE_CODE)
{
	$l = DEFAULT_LANGUAGE_CODE;
}
Language::code(!empty($l)?$l:'en');

if (Session::get("auth_user_id"))
{
	require_once PATH_TABLES."user.php";
	$userGateway = new UserGateway;
	if (!$userGateway->reportExists(Session::get("auth_user_id")))
	{
		Session::drop("auth_user_id");
	}
}