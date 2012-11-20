<?php

    define ('PATH', dirname(__FILE__).'/');
    define ('PATH_CORE', PATH.'core/');
    define ('PATH_CONFIG', PATH.'config/');

    define ('PATH_CONTROLLERS', PATH.'application/controllers/');
    define ('PATH_API', PATH.'application/api/');
    define ('PATH_TABLES', PATH.'application/model/tables/');
    define ('PATH_DOMAIN', PATH.'application/model/domain/');
    define ('PATH_FILTERS', PATH.'application/filters/');
    define ('PATH_MODEL', PATH.'application/model/');
    define ('PATH_PAYMENT', PATH.'application/model/payment/');
    define ('PATH_API_TEST', PATH.'test/api/');
    define ('PATH_CONTROLLER_TEST', PATH.'test/controller/');
    define ('CATEGORY_THUMB_WIDTH', '100');
    define ('CATEGORY_THUMB_HEIGHT', '100');

    define ('PATH_VALIDATION', PATH.'application/validation/');

    define ('PATH_ATTACHMENTS', PATH.'attachments/');
    define ('PATH_LIB', PATH.'lib/');
    define ('PATH_SMARTY', PATH_LIB.'smarty/');
    define ('PATH_PHPMAILER', PATH_LIB.'phpmailer-lite/');

    define ('PATH_COMPILED_TEMPLATES', PATH.'var/compiled/');
    define ('PATH_CACHE', PATH.'var/cache/');

    define ('PATH_LAYOUTS', PATH.'application/layouts/');
    define ('PATH_VIEW', PATH.'application/view/');
    define ('PATH_DEBUG', PATH.'var/debug/');
    define ('PATH_TEMP', PATH.'var/temp/');

    include_once PATH_CONFIG."config.server.php";
	
    define('SITE_ATTACHMENTS', SITE.'attachments/');

    define('PATH_IMAGES', PATH.'images/');
    define('SITE_IMAGES', SITE.'images/');

    define('SITE_CSS', SITE.'style/css/');
    define('SITE_JS', SITE.'js/');
    define('SITE_LIB', SITE.'lib/');
    define('SITE_STYLE_IMAGES', SITE.'style/images/');

    include_once PATH_CORE."core.php";
    include_once PATH_CORE."core.db.php";
    include_once PATH_CORE."core.session.php";

    include_once PATH_CORE."classes/Cache.php";

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
    //$config->setTemporary("catalog", "product_2", "Турум-пурум");

    // Устанавливаем текущий язык сайта
    $l = $config->get('core', 'language_code');
    Language::code(!empty($l)?$l:'en');