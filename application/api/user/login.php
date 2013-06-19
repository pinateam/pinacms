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



$request->filterParams("strip_tags trim", "user_login");

validateNotEmpty($request, "user_login", lng('enter_user_login'));

$request->trust();

require_once PATH_TABLES."user.php";

$user = new UserGateway();
$user->useAccountId = false;
$u = $user->getBy('user_login', $request->param("user_login"));


if ($u["access_group_id"] != "2" && $u["account_id"] != Site::accountId())
{
	$request->stop(lng('wrong_password'), "user_password");
}


validatePassword($request, $u["user_password"]);

if ($u['user_status'] == 'disabled')
{
	$request->error(lng('your_profile_has_been_disabled'));
}

if ($u['user_status'] == 'new' && (time() - $u['user_created'] > 86400)) // более суток
{
	$request->error(lng('your_profile_has_not_been_activated'));
}

$request->trust();

Session::set("auth_user_id", $u['user_id']);
$redirectAction = $request->param('redirect_action');
if (!empty($redirectAction))
{
	$request->setRedirect((href(array('action' => $redirectAction))));
}

$request->ok();