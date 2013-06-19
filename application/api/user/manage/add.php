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



$request->filterParams("trim", "user_password");
$request->filterParams("strip_tags trim", "user_status user_login");

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
validateUniqueUsernameAndEmail($request);
validateNotEmpty($request, "user_status", lng("enter_status"));

$request->trust();

$data = $request->params();
$data['user_password'] = passwordHash($data['user_password']);

include_once PATH_TABLES."user.php";
$user = new UserGateway;
$user_id = $user->add($data);

if (empty($user_id))
{
	$request->stop(lng('wrong_data'));
}

include_once PATH_TABLES."address.php";
$userAddress = new AddressGateway;

$register_data = mineArray("register_", $data);
$register_data["user_id"] = $user_id;
$register_address_id = $userAddress->add($register_data);

$shipping_address_id = $register_address_id;
if ($request->param("user_same_address") != "same")
{
	$shipping_data = mineArray("shipping_", $data);
	$shipping_data["user_id"] = $user_id;
	$shipping_address_id = $userAddress->add($shipping_data);
}

include_once PATH_TABLES."user_config.php";
$userConfig = new UserConfigGateway();
$userConfig->add(
	array(
	    "user_id" => $user_id,
	    "register_address_id" => $register_address_id,
	    "shipping_address_id" => $shipping_address_id,
	)
);

include_once PATH_TABLES."account.php";
$accountGateway = new AccountGateway();
$accountId = $accountGateway->add(array("user_id" => $user_id));

$request->result("id", $user_id);

$request->setRedirect(href(array("action" => "user.manage.edit", "user_id" => $user_id)));
$request->ok(lng('user_has_been_created'));
