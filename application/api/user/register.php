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



if (Session::get('auth_user_id'))
{
    $request->stop(lng('registration_is_disabled_because_you_are_signed_in'));
}

validateCaptcha($request);
validateUserLogin($request);
validateNewPassword($request);
validateUserEmail($request);

validateUniqueUsernameAndEmail($request);

$request->trust();

$data = $request->params();
unset($data['new_password2']);

$data['activation_token'] = randomToken();
$data['user_password'] = passwordHash($data['new_password']);

require_once PATH_TABLES."user.php";
$user = new UserGateway;
if (!$userId = $user->add($data))
{
        $request->stop(lng('internal_error'));
}

$request->set('user_id', $userId);
$request->run('custom-field.add-value');

include_once PATH_TABLES."account.php";
$accountGateway = new AccountGateway();
$accountId = $accountGateway->add(array("user_id" => $userId));

Session::set('auth_user_id', $userId);

require_once PATH_MODEL .'mailer/MailFactory.php';
$mailer = MailFactory::getMailer();
$mailer->setTo($request->param('user_email'));
$mailer->setSubject(lng('you_have_registered_on_site'));
$mailer->setBodyAction("user.register-notification", array("token" => $data["activation_token"]));
$mailer->send();

$mailer->setTo(MAIL_ADMIN);
$mailer->setSubject(SITE.': '.lng('you_have_new_registered_user'));
$mailer->setBodyAction("user.register-notification-admin", array("user_login" => $data["user_login"]));
$mailer->send();

$redirectAction = $request->param('redirect_action');
if(!empty($redirectAction))
{
    $request->setRedirect((href(array('action' => $redirectAction))));
}

$request->ok();
