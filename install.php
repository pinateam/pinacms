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
* @copyright � 2010 Dobrosite ltd.
*/

define('PATH', dirname(__FILE__).'/');
define('PATH_CONFIG', PATH.'config/');

include_once PATH_CONFIG."config.server.php";
include_once PATH_CONFIG."config.path.php";

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

	require_once PATH_DOMAIN .'db-update.php';

	$dbUpdateDomain = new DBUpdateDomain();
	$dbUpdateDomain->update();

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