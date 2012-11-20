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



$data = $_GET;

if (empty($data["action"]) && empty($data["path"]) && !empty($data["dispatch"]))
{
	$data = dispatch($data["dispatch"]);
}

$request->result("main_link", $data["dispatch"]?$data["dispatch"]:$_SERVER["REQUEST_URI"]);
//echo "<!-- ".print_r($_SERVER, 1)."-->";

if (!empty($data["action"]))
{
	$params = '';
	foreach ($data as $k=>$v)
	{
		if ($k == 'action') continue;
		if (!empty($params)) $params .= '&';
		$params = $params . $k.'='.$v;
	}

	$request->result("main_action", $data["action"]);
	$request->result("main_params", $params);

	//echo "<!-- ".print_r($data["action"], 1).print_r($params,1)."-->";
}

$request->set("menu_key", "main");

include PATH_CONTROLLERS."menu/list.php";