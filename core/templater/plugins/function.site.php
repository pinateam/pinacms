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



function smarty_function_site($params, &$view)
{
	if (!empty($params["js"]))
	{
		global $__loaded_js;
		$__loaded_js[] = SITE_JS.$params["js"];
		return SITE_JS.$params["js"];
	}

	if (!empty($params["img"]))
	{
		if (Site::path())
		{
			$sitePath = PATH .'style/sites/'. Site::path() .'/images/'. $params['img'];

			if (file_exists($sitePath))
			{
				return SITE .'style/sites/'. Site::path() .'/images/'. $params['img'];
			}
		}

                return SITE_STYLE_IMAGES.$params["img"];
	}

	if (!empty($params["css"]))
	{
		if (empty($params["browser"]))
		{
			global $__loaded_css;
			$__loaded_css[] = SITE_CSS.$params["css"];
		}
		return SITE_CSS.$params["css"];
	}

	if (!empty($params["lib"]))
	{
		return Site::baseUrl(Site::domain()?Site::id():0).'lib/'.$params["lib"];
	}
}
