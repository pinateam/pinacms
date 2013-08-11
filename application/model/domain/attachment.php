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



class AttachmentDomain
{
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

		$r = Site::baseUrl()."attachments/";
		
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

		$r = PATH_ATTACHMENTS;
		
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

		if (in_array($ext, array("php", "exe", "rb"))) return false;

		require_once PATH_CORE."core.latin.php";
		$souce_filename = strtolower(latin_generateToken($pathinfo["filename"]));

		$filename = AttachmentDomain::newFileName($souce_filename, $ext);

		$filepath = AttachmentDomain::getFilePath($filename, $ext);

		AttachmentDomain::prepareDir($filename, $ext);

		if (!move_uploaded_file($_FILES[$item]['tmp_name'], $filepath))
		{
			return false;
		}

		$imageId = AttachmentDomain::prepareData($filename, $ext);

		/*
		if ($few)
		{
			$a = Session::get($key."_uploaded_file");
			if (!is_array($a)) $a = array();
			
			$a[] = $imageId;
			$imageId = $a;
			
		}

		Session::set($key."_uploaded_file", $imageId);

		return AttachmentDomain::getFileUrl($filename);
		 */
		return $imageId;
	}

	static function prepareDir($filename, $ext = false)
	{
		if (!empty($ext))
		{
			$filename .= ".".$ext;
		}

		$baseDir = PATH_ATTACHMENTS;

		
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

	static function prepareData($filename, $ext = false)
	{
		$filesize = filesize(self::getFilePath($filename, $ext));

		if (empty($filesize)) return false;

		$data['attachment_filename'] = $filename.(!empty($ext)?(".".$ext):"");
		$data['attachment_type'] = "application/".$ext;
		$data['attachment_size'] = $filesize;

		require_once PATH_TABLES."attachment.php";
		$gw = new AttachmentGateway;
		return $gw->add($data);
	}

	static function saveCopy($filepath, $gateway, $filename, $data)
	{
		if (empty($filepath)) return;
		if (!file_exists($filepath)) return false;

		$filename = self::prepareFilename($filepath, $filename);

		copy($filepath, self::getFilePath($filename));

		$data["attachment_id"] = self::prepareData($filename);

		$gateway->put($data);

		return $filename;
	}

	static function saveUrl($source, $gateway, $filename, $data)
	{
		if (empty($source)) return;

		$filename = self::prepareFilename($source, $filename);

		$image_content = file_get_contents($source);
		if (empty($image_content)) return false;

		file_put_contents(self::getFilePath($subject, $filename), $image_content);
		unset($image_content);

		$data["attachment_id"] = self::prepareData($filename);
		
		$gateway->put($data);

		return $filename;
	}

	function remove($filename)
	{
		@unlink(self::getFilePath($subject, $filename));
	}
}