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




function smarty_function_gravatar($params)
{
	$url = 'http://www.gravatar.com/avatar/';

	if (empty($params['email'])) $params['email'] = '';
	
	$url .= md5(strtolower(trim($params['email'])));

	$ps = array();
	if (isset($params['size']))
	{
		$ps[] = 's='.$params['size'];
	}

	if (isset($params['rating']))
	{
		$ps[] = 'r='.$params['rating'];
	}

	if (isset($params['default'])) 
	{
		$parsed = parse_url($params['default']);
		if (!empty($parsed["host"]) && $parsed["host"] != "localhost")
		{
			$ps[] = 'd='.urlencode($params['default']);
		}
	}
	
	$ps = join("&", $ps);

	return $url.(!empty($ps)?("?".$ps):"");
}