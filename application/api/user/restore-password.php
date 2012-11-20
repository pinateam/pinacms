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

function createPassword($length = 8, $allowed_symbols = '23456789abcdeghkmnpqsuvxyz')
{
    $keystring = '';

    while (true)
    {
        $keystring='';

        for($i=0;$i<$length;$i++)
        {
            $keystring .= $allowed_symbols{mt_rand(0,strlen($allowed_symbols)-1)};
        }

        if (!preg_match('/cp|cb|ck|c6|c9|rn|rm|mm|co|do|cl|db|qp|qb|dp/', $keystring))
            break;
    }

    return $keystring;
}

include_once PATH_TABLES."user.php";
$user = new UserGateway();
$u = $user->getByRestoreToken($request->param('token'));

if (empty($u['user_id']))
{
    $request->stop(lng('wrong_data'), 'token');
}

$password = createPassword();

$user->edit($u['user_id'], array('restore_token' => '', 'user_password' => passwordHash($password)));

if (empty($u['user_email'])) $request->stop("wrong_email");

require_once PATH_MODEL .'mailer/MailFactory.php';
$mailer = MailFactory::getMailer();
$mailer->setTo($u['user_email']);
$mailer->setSubject(lng("password_recovery")." - ".lng("action_completed"));
$mailer->setBodyAction("user.restore-password-notification", array("password" => $password));
$mailer->send();

$request->ok(lng('password_has_been_restored'));
