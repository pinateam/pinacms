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



$request->filterParams("intval", "user_id");

validateNotEmpty($request, "user_id", lng('internal_error'));

if (!isModuleActive("access.manage.group-admin-selector-items") ||
	!isModulePermitted("access.manage.group-admin-selector-items"))
{
	if ($request->param("access_group_id") == '2')
	{
		$request->stop("internal_error");
	}
}

validateUserLogin($request);
validateUserEmail($request);
validateUserOperationPermitted($request);

$request->trust();

$data = $request->params();

if (!isModuleActive("user.manage.group-selector") ||
	!isModulePermitted("user.manage.group-selector"))
{
	unset($data["access_group_id"]);
}

if (!empty($data["user_password"]))
{
	$data["user_password"] = passwordHash($data["user_password"]);
} else {
	unset($data["user_password"]);
}

include_once PATH_TABLES."user.php";
$user = new UserGateway;
$user->edit($data["user_id"], $data);

include_once PATH_TABLES."address.php";
$address = new AddressGateway();

include_once PATH_TABLES."user_config.php";
$user_config = new UserConfigGateway();

$ra = mineArray("register_", $data);
if (!empty($ra["address_id"]))
{
	$address->edit($ra["address_id"], $ra);
}
else
{
	$ra["address_id"] = $address->add($ra);
	$user_config->edit($data["user_id"], array("register_address_id" => $ra["address_id"]));
}

if ($request->param("use_same_address") != "same")
{
	$sa = mineArray("shipping_", $data);
	if (!empty($sa["address_id"]) && $sa["address_id"] != $ra["address_id"])
	{
		$address->edit($sa["address_id"], $sa);
	}
	else
	{
		$sa["address_id"] = $address->add($sa);
		$user_config->edit($data["user_id"], array("shipping_address_id" => $sa["address_id"]));
	}
}
else
{
	$user_config->edit($data["user_id"], array("shipping_address_id" => $ra["address_id"]));
}

$request->ok(lng('user_has_been_changed'));