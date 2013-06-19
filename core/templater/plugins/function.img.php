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



function smarty_function_img($params, &$view)
{
	if (empty($params['img']) && !empty($params["image_id"]))
	{
		require_once PATH_TABLES."image.php";
		$imageGateway = new ImageGateway;
		$image = $imageGateway->get($params["image_id"]);
		if (!empty($image["image_filename"]))
		{
			$params["img"] = $image["image_filename"];
		}
	}

	if (empty($params["img"])) return '';

	$hash = md5($params["img"]);
	$first = substr($hash, 0, 2);
	$second = substr($hash, 2, 2);

	if (strpos($params["img"], "http") === 0)
	{
		return $params["img"];
	}

	if (!empty($params["width"]) || !empty($params["height"]))
	{
		require_once PATH_DOMAIN."image.php";

		$srcPath = PATH_IMAGES.Site::id()."/".$first."/".$second."/".$params["img"];
		

		if (!file_exists($srcPath))
		{
			return '';
		}

		$key = $params["img"];
		if (!empty($params["width"])) $key .= "-".$params["width"];
		if (!empty($params["height"])) $key .= "-".$params["height"];
		$key .= "-".filectime($srcPath);
		
		$tmpName = $key.".png";//ImageDomain::tmpName("png", $key);

		@mkdir(PATH_CACHE."images", 0777);
		@mkdir(PATH_CACHE."images/".Site::id(), 0777);
		
		$hash = md5($tmpName);
		$first = substr($hash, 0, 2);
		$second = substr($hash, 2, 2);

		@mkdir(PATH_CACHE."images/".Site::id()."/".$first, 0777);
		@mkdir(PATH_CACHE."images/".Site::id()."/".$first."/".$second, 0777);

		$filepath = PATH_CACHE."images/".Site::id()."/".$first."/".$second."/".$tmpName;

		if (!file_exists($filepath))
		{
			if (!empty($params["width"]) && !empty($params["height"]))
			{
				ImageDomain::resize($srcPath, $params["width"], $params["height"], $filepath);
			}
			elseif (!empty($params["width"]))
			{
				ImageDomain::resize($srcPath, $params["width"], 0, $filepath);
			}
			elseif (!empty($params["height"]))
			{
				ImageDomain::resize($srcPath, 0, $params["height"], $filepath);

			}
		}

		return Site::baseUrl()."cache/images/".Site::id()."/".$first."/".$second."/".$tmpName;

		/*
		return href(array(
		    'action' => 'image.thumb',
		    'src' => $params["type"]."/".$params["img"],
		    'width' => $params["width"]
		));
		*/
	}

	return Site::baseUrl()."images/".Site::id()."/".$first."/".$second."/".$params["img"];
}