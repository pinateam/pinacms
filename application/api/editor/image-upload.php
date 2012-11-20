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

if (!defined('PATH')){ exit; }



include_once PATH_CORE."core.latin.php";
include_once PATH_DOMAIN."image.php";
include_once PATH_TABLES."photo.php";

@mkdir(PATH_IMAGES.Site::id()."/common/");

$pathinfo = pathinfo($_FILES['userfile']['name']);
$ext = strtolower($pathinfo["extension"]);

$souce_filename = latin_generateToken($pathinfo["filename"]);

$filename = ImageDomain::newFileName(Site::id(), 'common', $souce_filename, $ext);
$filepath = ImageDomain::getFilePath(Site::id(), 'common', $filename, $ext);

if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $filepath))
{
	$request->stop();
}

if (isModuleActive("gallery"))
{
	$photoFilename = ImageDomain::newFileName(Site::id(), 'photo', $souce_filename, $ext);
	ImageDomain::saveCopy(Site::id(), 'photo', $filepath, new PhotoGateway(), $photoFilename,
		array("site_id" => Site::id(), "common_filename" => $filename.".".$ext)
	);
}

$config = getConfig();
$maxWidth = $config->get("image", "editor_max_width");
$maxHeight = $config->get("image", "editor_max_height");

if ($maxWidth || $maxHeight)
{
	$size = getimagesize($filepath);
	if ($size[0] > $maxWidth || $size[1] > $maxHeight)
	{
		ImageDomain::resize(
			$filepath,
			($size[0] > $maxWidth && ($size[0] > $size[1] || !$maxHeight)) ? $maxWidth : 0,
			($size[1] > $maxHeight && ($size[1] > $size[0] || !$maxWidth)) ? $maxHeight : 0,
			$filepath
		);
	}
}

$resultFilename = Site::baseUrl(Site::id())."images/".Site::id()."/common/".$filename.".".$ext;
$result = "Файл загружен";
$resultcode = "ok";

echo <<<OUT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JustBoil's Result Page</title>
<script language="javascript" type="text/javascript">
	window.parent.window.jbImagesDialog.uploadFinish({
		filename:'$resultFilename',
		result: '$result',
		resultCode: '$resultcode'
	});
</script>
</head>

<body>

Result: $result

</body>
</html>
OUT;

/*
echo '
<script language="javascript" type="text/javascript">
	window.parent.window.MarkettoImagesDialog.uploadFinish({
		filename: "'.$resultFilename.'",
		result: "'.$result.'",
		resultCode: "'.$resultcode.'"
	});
</script>
Result: "'.$result.'"';
 */