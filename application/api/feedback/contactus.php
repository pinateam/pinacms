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



validateUserEmail($request);
validateNotEmpty($request, "name", lng('enter_name'));
validateNotEmpty($request, "message", lng('enter_message'));

$request->trust();

$config = getConfig();

require_once PATH_MODEL .'mailer/MailFactory.php';
$mailer = MailFactory::getMailer();
$mailer->setTo($config->get("feedback", "email")?$config->get("feedback", "email"):MAIL_ADMIN);
$mailer->setSubject(lng('contact_us_form').": ".$request->param("subject"));

$mailer->setBodyAction("feedback.contactus-notification", array(
    "site_domain" => Site::domain(),
    "name" => $request->param("name"),
    "user_email" => $request->param("user_email"),
    "order_id" => $request->param("order_id"),
    "message" => $request->param("message"),
    "user_phone" =>$request->param("user_phone")
));

@$mailer->send();

$request->run('uservoice.create-ticket');

$request->ok(lng("email_has_been_sent"));