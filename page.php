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

include "init.php";

if (Site::domain() && Site::domain() != $_SERVER["HTTP_HOST"])
{
	redirect(Site::baseUrl().trim($_SERVER["REQUEST_URI"],"/"));
}

include PATH_CORE."core.dispatcher.php";
include PATH_CORE."classes/Breadcrumbs.php";
include PATH_CORE."request/PageRequest.php";
include PATH_CORE."request/BlockRequest.php";

$data = $_GET;

if (empty($data["action"]) && empty($data["path"]) && !empty($data["dispatch"]))
{
	$data = dispatch($data["dispatch"]);
}
elseif (empty($data["action"]) && !empty($data["path"]))
{
	$a = strstr($_SERVER["REQUEST_URI"], "?");
	parse_str(trim($a, "?"), $data);
	unset($a);
}
elseif (empty($data["action"]) && empty($data["dispatch"]))
{
	$data["action"] = "home";
}

$request = new PageRequest($data);
if (!empty($data['printable']))
{
	$request->setLayout("print");
}

if ($config->get("core", "frontend_status") == "closed" && strpos($action, "manage") === false && strpos($action, "dashboard") === false)
{
	require_once PATH_CONTROLLERS."closed.php";
	exit;
}

$request->run();

if (DEFINED("DEBUG_DB") && DEBUG_DB)
{
	$db = GetDB();
	$debug = $db->getDebug();
	file_put_contents(PATH."var/temp/page-".$data["action"]."-".date("Y-m-d-H-i-s").".txt", print_r($db->getDebug(), 1));
}
