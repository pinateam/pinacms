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



require_once PATH_DOMAIN . "image.php";
$imageId = ImageDomain::upload('userfile');

if (empty($imageId))
{
	echo lng("access_denied");
	exit;
}

require_once PATH_TABLES."image.php";
$imageGateway = new ImageGateway;
$image = $imageGateway->get($imageId);

if (empty($image))
{
	$request->stop(lng('internal_error'));
}

$request->set("image_id", $imageId);
$request->run("gallery.manage.add");

$config = getConfig();
$maxWidth = $config->get("image", "editor_max_width");
$maxHeight = $config->get("image", "editor_max_height");

if ($maxWidth || $maxHeight)
{
	if ($image["image_width"] > $maxWidth || $image["image_height"] > $maxHeight)
	{
		$filepath = ImageDomain::getFilePath($image["image_filename"]);
		$pathinfo = pathinfo($filepath);
		$filenameResized = ImageDomain::newFileName($pathinfo["filename"], $pathinfo["extension"]);
		ImageDomain::prepareDir($filenameResized, $pathinfo["extension"]);
		$filepathResized = ImageDomain::getFilePath($filenameResized, $pathinfo["extension"]);

		ImageDomain::resize(
			$filepath,
			($image["image_width"] > $maxWidth && ($image["image_width"] > $image["image_height"] || !$maxHeight)) ? $maxWidth : 0,
			($image["image_height"] > $maxHeight && ($image["image_height"] > $image["image_width"] || !$maxWidth)) ? $maxHeight : 0,
			$filepathResized
		);

		$imageId = ImageDomain::prepareData($filenameResized, $pathinfo["extension"], $imageId);
		if (!empty($imageId))
		{
			$image = $imageGateway->get($imageId);
		}
	}
}

$resultFilename = ImageDomain::getFileUrl($image["image_filename"]);
$result = "File has been uploaded";
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