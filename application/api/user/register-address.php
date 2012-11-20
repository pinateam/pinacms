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



$request->filterParams("strip_tags trim", "address_firstname address_lastname address_city");
$request->filterParams("strip_tags trim", "address_zip address_state_key address_state address_county");

validateAuth($request);

validateNotEmpty($request, "address_firstname", lng("enter_address_firstname"));
validateNotEmpty($request, "address_lastname", lng("enter_address_lastname"));

validateNotEmpty($request, "address_city", lng("enter_address_city"));
validateNotEmpty($request, "address_zip", lng("enter_address_zip"));

if ($request->param("address_state_key") == '' && $request->param("address_state") == '')
{
	$request->error(lng("enter_address_state"), 
		$request->param("address_state_key") == ''?"address_state_key":"address_state"
	);
}

validateNotEmpty($request, "address_county", lng("enter_address_county"));

$request->trust();

require_once PATH_TABLES."address.php";
require_once PATH_TABLES."user_config.php";

$address = new AddressGateway();
$user_config = new UserConfigGateway();

$register_address_id = 0;
$c = $user_config->get(Session::get("auth_user_id"));
if (isset($c["register_address_id"])) $register_address_id = $c["register_address_id"];



$data = $request->params();
$data["address_country_key"] = substr($data["address_country_key"], 0, 2);
if (!empty($data["address_state_key"]))
{
	$data["address_state_key"] = substr($data["address_state_key"], 0, 2);
}

if (!empty($register_address_id))
{
	$address->edit($register_address_id, $data);
}
else
{
	$data["user_id"] = Session::get("auth_user_id");
	$register_address_id = $address->add($data);
	if ($user_config->reportExists(Session::get("auth_user_id")))
		$user_config->edit(Session::get("auth_user_id"), array("register_address_id" => $register_address_id));
	else
		$user_config->add(array("user_id"=> Session::get("auth_user_id"), "register_address_id" => $register_address_id));
}

$request->ok();