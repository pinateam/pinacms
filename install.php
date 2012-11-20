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

header('Content-Type: text/html; charset='.SITE_CHARSET);

if (!empty($_GET["mode"]) && $_GET["mode"] == "install")
{
	$dir = PATH."application/install/";
	$modules = array();

	if (is_dir($dir)) {
		if ($dh = opendir($dir))
		{
			while (($file = readdir($dh)) !== false)
			{
				if (strpos($file, '.') === false && is_dir($dir.$file))
				{
					$modules [] = $file;
				}
			}
			closedir($dh);
		}
	}

	foreach ($modules as $m)
	{
		if (file_exists($dir.$m."/database.php"))
		{
			include $dir.$m."/database.php";
		}
	}


	foreach ($modules as $m)
	{
		if (file_exists($dir.$m."/module.php"))
		{
			include $dir.$m."/module.php";
		}
	}

	require_once 'application/model/core/StringImport.php';
	$import = new StringImport();
	$import->setInputCoding('UTF-8');
	$import->setOutputCoding('UTF-8');
	$import->import();

	redirect("install.php?mode=complete");
}
elseif (!empty($_GET["mode"]) && $_GET["mode"] == "complete")
{
	echo '<html>
<body style="text-align:center;font:1em Arial,sans-serif; line-height: 18px; ">
	<img src="style/images/logo.png" />
	<p>
	Installation has been completed;
	<a href="page.php">Go to site</a>
	</p>
	<p>© 2010-'.date('Y').' «Dobrosite Ltd». All rights reserved.</p>
</body>
</html>';
}
else
{
	echo '<html>
<body style="text-align:center;font:1em Arial,sans-serif; line-height: 18px; ">
	<img src="style/images/logo.png" />
	<p>
		<a href="install.php?mode=install">Install Pina</a>
	</p>
	<p>© 2010-'.date('Y').' «Dobrosite Ltd». All rights reserved.</p>
</body>
</html>';
}