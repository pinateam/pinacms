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
* @copyright � 2010 Dobrosite ltd.
*/

if (!defined('PATH')){ exit; }



	require_once PATH_TABLES.'user.php';
	require_once PATH_TABLES.'address.php';

	$user = new UserGateway();
	$u = $user->get($request->param("user_id"));

	$address = new AddressGateway();
	$u["register_address"] = $address->getByType('register', $u["user_id"]);
	$u["shipping_address"] = $address->getByType('shipping', $u["user_id"]);
	
	include_once PATH_TABLES."account.php";
	$accountGateway = new AccountGateway();
	$a = $accountGateway->getBy("user_id", $u["user_id"]);
	$u["account_id"] = $a["account_id"];
	
	$request->result('user', $u);

	$request->result("user_status_editor", array(
	    array("value" => "active", "caption" => lng('enabled'), "color" => "green"),
	    array("value" => "disabled", "caption" => lng('disabled'), "color" => "red"),
	));

	$request->setLayout('admin');
	$request->addLocation("Пользователи", href(array("action" => "user.manage.home")));
	$request->ok(!empty($u["user_title"])?$u["user_title"]:$u["user_login"]);