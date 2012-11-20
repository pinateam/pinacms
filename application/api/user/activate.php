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



$request->filterParams("strip_tags trim", "token");

validateNotEmpty($request, "token", lng('wrong_data_format'));

$request->trust();

require_once PATH_TABLES."user.php";
$user = new UserGateway();
$u = $user->getByActivationToken($request->param("token"));

if (empty($u['user_id']))
{
    $request->stop(lng('wrong_data'), 'token');
}

$user->edit($u['user_id'], array('activation_token' => '', 'user_status' => 'active'));

require_once PATH_MODEL .'mailer/MailFactory.php';
$mailer = MailFactory::getMailer();

if (!empty($u['user_email']))
{
	$mailer->setTo($u['user_email']);
	$mailer->setSubject(lng('your_profile_has_been_activated'));
	$mailer->setBodyAction("user.activate-notification");
	$mailer->send();
}

$mailer->setTo(MAIL_ADMIN);
$mailer->setSubject(SITE.": ".lng('profile_has_been_activated').": ".$u['user_login']);
$mailer->setBodyAction("user.activate-notification-admin", array("user_login" => $u['user_login']));
$mailer->send();

$request->ok(lng('activation_has_been_completed'));
