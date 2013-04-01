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


	require_once PATH_LIB .'compress/jsmin.php';

	class Resourses
	{
		static $resourses = array();

		public static function buildResourse($type, $url)
		{
			switch ($type) {
				case 'css':
					return '<link rel="stylesheet" type="text/css" href="'.htmlspecialchars($url).'" />';
				break;
				case 'js':
					return '<script type="text/javascript" src="'.htmlspecialchars($url).'"></script>';
				break;
				
				default:
					return;
				break;
			}
		}

		public static function getCacheResourse($type)
		{
	                return self::buildResourse($type, self::getCacheFileUrl($type));
		}

		public static function getCacheFileUrl($type)
		{
			Resourses::createCacheFile($type);

			
			if(Site::id() != 0)
	                {
	                        $cacheFileUrl = SITE_CACHE .'sites/'. Site::path() .'/'. $type .'/'. self::getCacheFileName($type);
	                }
	                else
	                {
			
	                        $cacheFileUrl = SITE_CACHE . $type .'/'. self::getCacheFileName($type);
			
	                }
			

	                return $cacheFileUrl;
		}

		public static function createCacheFile($type)
		{
			$cacheFileName = self::getCacheFileName($type);
			//echo $type .'-'. $cacheFileName .'<br />';
			
	                if(Site::id() != 0)
	                {
	                        $cacheFilePath = PATH_CACHE .'sites/'. Site::path() .'/'. $type .'/';
	                }
	                else
	                {
			
	                        $cacheFilePath = PATH_CACHE . $type .'/';
			
	                }
			

	                $cacheFile = $cacheFilePath . $cacheFileName;
	                prepareDir($cacheFile);

	                if(file_exists($cacheFile)) return;

			$fp = fopen($cacheFile, 'w', 0777);
                        chmod($cacheFile, 0777);
			$pattern = '#(..\/images/)#';

			
			if(Site::id() != 0)
			{
				$replacement = SITE .'style/sites/'. Site::path() .'/images/';
			}
			else
			{
			
				$replacement = SITE .'style/images/';
			
			}
			

			foreach(self::getResoursePathes($type) as $resourse)
			{
				if(!file_exists($resourse['file']))
				{
					continue;
				}

				$content = file_get_contents($resourse['file']);
				$content = preg_replace($pattern, $replacement, $content);

				if($type == 'css')
				{
					// Remove comments
					$content = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content);
					// Remove tabs, spaces, newlines, etc...
					$content = str_replace(array("\r", "\n", "\t", '  ', '   '), '', $content);
				}
				if($type == 'js')
				{
					$content = JSMin::minify($content);
					$content .= ";\r\n\r\n";
				}

				fwrite($fp, $content);
			}
			fclose($fp);
		}

		public static function getCacheFileName($type)
		{
			return md5(serialize(self::getResoursePathes($type))) .'.'. $type;
		}

		public static function getResourse($type, $fileName)
		{
			switch ($type) 
			{
				case 'css':
					$filePath = self::getCSSPath(true);
					$file = $filePath . $fileName;
					$resourse = '<link rel="stylesheet" type="text/css" href="'.htmlspecialchars($file).'" />';
				break;

				case 'js':
					$filePath = self::getJSPath(true);
					$file = $filePath . $fileName;
					$resourse = '<script type="text/javascript" src="'.htmlspecialchars($file).'"></script>';
				break;
				
				default:
					return;
				break;
			}              

	                return $resourse;
		}

		public static function getCSSPath($url = false)
		{
			if(!$url)
			{
				$filePath = PATH .'style/';
			}
			else
			{
				$filePath = SITE .'style/';
			}

			
			if(Site::id() != 0 && file_exists($filePath .'sites/'. Site::path() .'/css/'))
			{
			        $filePath .= 'sites/'. Site::path() .'/css/';
			}
			else
			{
			
				$filePath .= 'css/';
			
			}
			

			return $filePath;
		}

		public static function getJSPath($url = false)
		{
			if(!$url)
			{
				$filePath = PATH .'js/';
			}
			else
			{
				$filePath = SITE .'js/';
			}
			
			if(Site::id() != 0 && file_exists($filePath .'sites/'. Site::path() .'/'))
			{
			        $filePath .= 'sites/'. Site::path() .'/';
			}
			

			return $filePath;
		}

		public static function getFilePath($type, $fileName)
		{
			switch ($type) 
			{
				case 'css':
					$filePath = self::getCSSPath();
				break;

				case 'js':
					$filePath = self::getJSPath();
				break;
				
				default:
					return;
				break;
			}

	                $file = $filePath . $fileName;
	                return $file;
		}

		public static function set($type, $fileName)
		{
			$file = self::getFilePath($type, $fileName);
			self::$resourses[$type][] = array(
				'file'      => $file,
				'filesize'  => @filesize($file),
                        	'filectime' => @filectime($file)
			);
		}

		public static function getResoursePathes($type)
		{
			return self::$resourses[$type];
		}
	}