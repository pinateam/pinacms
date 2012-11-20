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



$request->filterParams("strip_tags trim", "user_email");

validateCaptcha($request);
validateUserEmail($request);

$request->trust();

require_once PATH_TABLES."user.php";
$user = new UserGateway();
$u = $user->getBy('user_email', $request->param('user_email'));

if (empty($u['user_id']))
{
    $request->stop(lng('undefined_email'));
}

$token = randomToken();

$user->edit($u['user_id'], array('restore_token' => $token));

require_once PATH_MODEL .'mailer/MailFactory.php';
$mailer = MailFactory::getMailer();
$mailer->setTo($u['user_email']);
$mailer->setSubject(lng("password_recovery"));
$mailer->setBodyAction("user.restore-password-request-notification", array("token" => $token));
$mailer->send();

$request->ok(lng('restore_password_email_has_been_sent'));
