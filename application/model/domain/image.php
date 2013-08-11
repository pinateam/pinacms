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



class ImageDomain
{	
	static function resize($src, $width, $height, $dst = false)
	{
		if (!is_file($src)) return;

		$size = getimagesize($src);

		if ($size === false) return;

		$src_mime = $size['mime'];
		$src_width = $size[0];
		$src_height = $size[1];

		$format = strtolower(substr($src_mime, strpos($src_mime, '/') + 1));

		if (!in_array($format, array("png", "jpeg", "gif"))) return;

		$icfunc = 'imagecreatefrom'.$format;

		if (!function_exists($icfunc)) return;

		$isrc = $icfunc($src);

		if (empty($isrc)) return;

		$x_ratio = $width  / $src_width;
		$y_ratio = $height / $src_height;

		if ($height == 0) {
			$y_ratio = $x_ratio;
			$height  = $y_ratio * $src_height;
		} elseif ($width == 0) {
			$x_ratio = $y_ratio;
			$width   = $x_ratio * $src_width;
		}

		$ratio       = min($x_ratio, $y_ratio);
		$use_x_ratio = ($x_ratio == $ratio);

		$new_width   = $use_x_ratio  ? $width  : floor($src_width * $ratio);
		$new_height  = !$use_x_ratio ? $height : floor($src_height * $ratio);
		$new_left    = $use_x_ratio  ? 0 : floor(($width - $new_width)   / 2);
		$new_top     = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);

		$idest = imagecreatetruecolor($width, $height);

		imagefill($idest, 0, 0, 0xFFFFFF);
		imagecopyresampled($idest, $isrc, $new_left, $new_top, 0, 0, $new_width, $new_height, $src_width, $src_height);

		if (empty($dst))
		{
			header('Content-Type: image/'.$format);
			header('Content-Disposition: inline; filename="'.basename($src).'"');

			$icfunc = 'image'.$format;
			$icfunc($idest);
		}
		else
		{
			$dstInfo = pathinfo($dst);
			$format = $dstInfo["extension"];
			if ($format == "jpg") $format = "jpeg";
			if (in_array($format, array("png", "jpeg", "gif")))
			{
				$icfunc = 'image'.$format;
				$icfunc($idest, $dst);
			}
		}

		@imagedestroy($isrc);
		@imagedestroy($idest);
	}

	static function tmpName($ext, $key = false)
	{
		$uniqueId = md5($key?$key:(Session::get("auth_user_id").time().rand()));
		$filename = $uniqueId.'.'.strtolower($ext);
		return $filename;
	}

	static function newFileName($souce_filename, $ext)
	{
		if (empty($ext)) return '';
		
		$postfix = "";
		do
		{
			$filename = $souce_filename.$postfix;
			$filepath = self::getFilePath($filename, $ext);
			$postfix = strval(intval($postfix) + 1);
		} while (file_exists($filepath));
		
		return $filename;
	}

	static function getFileUrl($filename, $ext = false)
	{
		if (!empty($ext))
		{
			$filename .= ".".$ext;
		}

		$r = Site::baseUrl()."images/";
		
		$r .= Site::id()."/";
		
		$hash = md5($filename);
		$r .= substr($hash, 0, 2)."/".substr($hash, 2, 2);
		$r .= "/".$filename;

		return $r;
	}

	static function getFilePath($filename, $ext = false)
	{
		if (!empty($ext))
		{
			$filename .= ".".$ext;
		}

		$r = PATH_IMAGES;
		
		$r .= Site::id()."/";
		
		$hash = md5($filename);
		$r .= substr($hash, 0, 2)."/".substr($hash, 2, 2);
		$r .= "/".$filename;

		return $r;
	}

	static function upload($item = 'Filedata')
	{
		global $_FILES;

		if (!is_uploaded_file($_FILES[$item]['tmp_name'])) return false;

		$pathinfo = pathinfo($_FILES[$item]['name']);
		$ext = strtolower($pathinfo["extension"]);

		if (!in_array($ext, array("jpg", "jpeg", "png", "gif"))) return false;

		require_once PATH_CORE."core.latin.php";
		$souce_filename = strtolower(latin_generateToken($pathinfo["filename"]));

		$filename = ImageDomain::newFileName($souce_filename, $ext);

		$filepath = ImageDomain::getFilePath($filename, $ext);

		ImageDomain::prepareDir($filename, $ext);

		if (!move_uploaded_file($_FILES[$item]['tmp_name'], $filepath))
		{
			return false;
		}

		$imageId = ImageDomain::prepareData($filename, $ext);

		/*
		if ($few)
		{
			$a = Session::get($key."_uploaded_file");
			if (!is_array($a)) $a = array();
			
			$a[] = $imageId;
			$imageId = $a;
			
		}

		Session::set($key."_uploaded_file", $imageId);

		return ImageDomain::getFileUrl($filename);
		 */
		return $imageId;
	}

	static function prepareDir($filename, $ext = false)
	{
		if (!empty($ext))
		{
			$filename .= ".".$ext;
		}

		$baseDir = PATH_IMAGES;

		
		$baseDir .= Site::id();
		@mkdir($baseDir, 0777);
		

		$hash = md5($filename);
		$first = substr($hash, 0, 2);
		$second = substr($hash, 2, 2);
		@mkdir($baseDir."/".$first, 0777);
		@mkdir($baseDir."/".$first."/".$second, 0777);
	}

	static function prepareFilename($filepath, $filename)
	{
		$sourcePathinfo = pathinfo($filepath);
		$targetPathinfo = pathinfo($filename);

		if (empty($targetPathinfo['extension']) || $targetPathinfo['extension'] != $sourcePathinfo['extension'])
		{
			$filename = $filename.".".$sourcePathinfo['extension'];
		}

		self::prepareDir($filename);

		return $filename;
	}

	static function prepareData($filename, $ext = false, $originalImageId = 0)
	{
		$imgInfo = getimagesize(self::getFilePath($filename, $ext));

		if (empty($imgInfo)) return false;

		$data['original_image_id'] = $originalImageId;
		$data['image_filename'] = $filename.(!empty($ext)?(".".$ext):"");
		$data['image_width']  = $imgInfo[0];
		$data['image_height'] = $imgInfo[1];
		$data['image_type'] = $imgInfo['mime'];
		$data['image_size'] = filesize(self::getFilePath($filename, $ext));

		require_once PATH_TABLES."image.php";
		$imageGateway = new ImageGateway;
		$imageId = $imageGateway->add($data);

		return $imageId;
	}

	static function saveCopy($filepath, $filename)
	{
		if (empty($filepath)) return;
		if (!file_exists($filepath)) return false;

		$filename = self::prepareFilename($filepath, $filename);

		copy($filepath, self::getFilePath($filename));

		return self::prepareData($filename);
	}

	static function saveUrl($source, $filename)
	{
		if (empty($source)) return;

		$filename = self::prepareFilename($source, $filename);

		$image_content = file_get_contents($source);
		if (empty($image_content)) return false;

		file_put_contents(self::getFilePath($subject, $filename), $image_content);
		unset($image_content);

		return self::prepareData($filename);
	}

	static function save($gateway, $data)
	{
		/* deprecated?? */
	}

	function remove($filename)
	{
		@unlink(self::getFilePath($subject, $filename));
	}

	function parseImageId($text)
	{
		preg_match_all('/(<img[^<>]+src[ ]*=[ ]*["\'])([^"\']*images\/)([^&^"^\']*)(["\'])/iUS', $text, $matches);
		if (!empty($matches) && !empty($matches[3]))
		{
			if (is_array($matches[3]))
			foreach ($matches[3] as $img)
			{
				$pathinfo = pathinfo($img);

				require_once PATH_TABLES."image.php";
				$imageGateway = new ImageGateway;
				$imageId = $imageGateway->reportIdBy("image_filename", $pathinfo['basename']);
				if (!empty($imageId))
				{
					return $imageId;
				}
			}
		}
		return 0;
	}
}