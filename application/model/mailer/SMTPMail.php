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



    require_once PATH_CORE .'classes/BaseMail.php';
    require_once PATH_LIB .'PHPMailer/class.phpmailer.php';

    class SMTPMail extends BaseMail
    {
        private $mail;

        function __construct()
        {
            $this->mail = new PHPMailer();
            $this->mail->IsSMTP();
            $this->mail->SMTPDebug = 0;//2 to echo debug info
            $this->mail->SMTPAuth = true;
            $this->mail->Port = MAIL_SMTP_PORT;
            $this->mail->Host = MAIL_SMTP_HOST;
            $this->mail->Username = MAIL_SMTP_USER;
            $this->mail->Password = MAIL_SMTP_PASS;
        }

        public function setTo($to)
        {
            $this->mail->AddAddress($to);
        }

        public function setFrom($from)
        {
            $this->mail->SetFrom($from);
        }

        public function setSubject($subject)
        {
            $this->mail->Subject = $subject;
        }

        public function setBody($body)
        {
            $this->mail->Body = $body;
        }

        public function send()
        {
		$this->writeLog("", "", "", $this->mail->Body);
		return $this->mail->Send();
		//$this->mail->ErrorInfo();
        }
    }