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
	if (empty($params["type"]) || empty($params["img"])) return '';

	if (strpos($params["img"], "http") === 0)
	{
		return $params["img"];
	}

	if (!empty($params["width"]) || !empty($params["height"]))
	{
		require_once PATH_DOMAIN."image.php";

		$srcPath = PATH_IMAGES.Site::id()."/".$params["type"]."/".$params["img"];
		
		$tmpName = ImageDomain::tmpName("png", $params["type"]."-".$params["img"]."-".$params["width"]."-".filectime($srcPath));
		@mkdir(PATH_IMAGES.Site::id()."/cache/");
		$filepath = PATH_IMAGES.Site::id()."/cache/".$tmpName;

		if (!file_exists($filepath))
		{
			if (!empty($params["width"]))
			{
				ImageDomain::resize($srcPath, $params["width"], 0, $filepath);
			}
			elseif (!empty($params["height"]))
			{
				ImageDomain::resize($srcPath, 0, $params["height"], $filepath);

			}
		}

		$params["type"] = "cache";
		$params["img"] = $tmpName;

		/*
		return href(array(
		    'action' => 'image.thumb',
		    'src' => $params["type"]."/".$params["img"],
		    'width' => $params["width"]
		));
		*/
	}

	return Site::baseUrl()."images/".Site::id()."/".$params["type"]."/".$params["img"];
}