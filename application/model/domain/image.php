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

	static function newFileName($subject, $souce_filename, $ext)
	{
		if (empty($ext) || empty($subject)) return '';
		
		$postfix = "";
		do
		{
			$filename = $souce_filename.$postfix;
			$filepath = self::getFilePath($subject, $filename, $ext);
			$postfix = strval(intval($postfix) + 1);
		} while (file_exists($filepath));
		
		return $filename;
	}

	static function getFileUrl($subject, $filename, $ext = false)
	{
		$r = SITE_IMAGES;
		
		$r .= Site::id()."/";
		
		$r .= $subject."/".$filename;

		if (!empty($ext))
		{
			$r .= ".".$ext;
		}

		return $r;
	}

	static function getFilePath($subject, $filename, $ext = false)
	{
		$r = PATH_IMAGES;
		
		$r .= Site::id()."/";
		
		$r .= $subject."/".$filename;
		
		if (!empty($ext))
		{
			$r .= ".".$ext;
		}

		return $r;
	}

	static function init($key, $few = false)
	{
		
		$key .= "_".Site::id();
		
		
		if ($few) $key .= "_few";
		Session::set($key."_uploaded_file", false);
	}

	static function upload($key, $few = false)
	{
		global $_FILES;
		if (empty($key)) return false;

		
		$key .= "_".Site::id();
		

		if (!is_uploaded_file($_FILES['Filedata']['tmp_name'])) return false;

		if ($few) $key .= "_few";

		$pathinfo = pathinfo($_FILES['Filedata']['name']);
		$filename = ImageDomain::tmpName($pathinfo['extension']);
		$filepath = PATH_TEMP.$filename;

		if (!move_uploaded_file($_FILES['Filedata']['tmp_name'], $filepath))
		{
			return false;
		}

		if ($few)
		{
			$a = Session::get($key."_uploaded_file");
			if (!is_array($a)) $a = array();
			
			$a[] = $filepath;
			$filepath = $a;
			
		}

		Session::set($key."_uploaded_file", $filepath);

		$sitepath = SITE."var/temp/".$filename."?rnd=".rand();
		return $sitepath;
	}

	static function getUploadedPath($subject)
	{
		
		$key = $subject."_".Site::id();
		

		return Session::get($key."_uploaded_file");
	}

	static function prepareDir($subject)
	{
		
		@mkdir(PATH_IMAGES.Site::id());
		@mkdir(PATH_IMAGES.Site::id()."/".$subject);
		

		
	}

	static function prepareFilename($filepath, $subject, $filename)
	{
		$sourcePathinfo = pathinfo($filepath);
		$targetPathinfo = pathinfo($filename);

		if (empty($targetPathinfo['extension']) || $targetPathinfo['extension'] != $sourcePathinfo['extension'])
		{
			$filename = $filename.".".$sourcePathinfo['extension'];
		}

		self::prepareDir($subject);

		return $filename;
	}

	static function prepareData($subject, $filename, $data)
	{
		$imgInfo = getimagesize(self::getFilePath($subject, $filename));
		
		$prefix = str_replace(array("product_", "category_"), "", $subject);
		$data[$prefix.'_filename'] = $filename;
		$data[$prefix.'_width']  = $imgInfo[0];
		$data[$prefix.'_height'] = $imgInfo[1];
		$data[$prefix.'_type'] = $imgInfo['mime'];
		$data[$prefix.'_size'] = filesize(self::getFilePath($subject, $filename));

		return $data;
	}

	static function saveCopy($subject, $filepath, $gateway, $filename, $data)
	{
		if (empty($filepath)) return;
		if (!file_exists($filepath)) return false;

		$filename = self::prepareFilename($filepath, $subject, $filename);

		copy($filepath, self::getFilePath($subject, $filename));

		$data = self::prepareData($subject, $filename, $data);
		$gateway->put($data);

		return $filename;
	}

	static function saveUrl($subject, $source, $gateway, $filename, $data)
	{
		if (empty($source)) return;

		$filename = self::prepareFilename($source, $subject, $filename);

		$image_content = file_get_contents($source);
		if (empty($image_content)) return false;

		file_put_contents(self::getFilePath($subject, $filename), $image_content);
		unset($image_content);

		$data = self::prepareData($subject, $filename, $data);
		$gateway->put($data);

		return $filename;
	}

	static function save($subject, $gateway, $name, $data, $few = false)
	{
		$key = $subject;
		
		$key .= "_".Site::id();
		

		if ($few) $key .= "_few";
		
		$paths = Session::get($key."_uploaded_file")?Session::get($key."_uploaded_file"):"";

		if (!$few && !is_array($paths)) $paths = array($paths);

		$prefix = str_replace(array("product_", "category_"), "", $subject);

		$i = 1;

		if (is_array($paths))
		foreach ($paths as $filepath)
		{
			if (!empty($filepath))
			{
				$pathinfo = pathinfo($filepath);
				$filename = $name.($few?(".".time().$i++):"").".".strtolower($pathinfo['extension']);

				self::prepareDir($subject);

				copy($filepath, self::getFilePath($subject, $filename));
				@unlink($filepath);
				Session::set($key."_uploaded_file", false);

				$data = self::prepareData($subject, $filename, $data);
				if ($few)
				{
					$gateway->add($data);
				}
				else
				{
					$gateway->put($data);
				}
			}
		}
	}

	function remove($subject, $filename)
	{
		@unlink(self::getFilePath($subject, $filename));
	}
}