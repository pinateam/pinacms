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

    class PHPMail extends BaseMail
    {
        public function setHtml()
        {
            $this->type = 'text/html';
        }

        public function setTo($to)
        {
            $this->to = $to;
        }

        public function setFrom($from)
        {
            $this->from = $from;
        }

        public function setSubject($subject)
        {
            $this->subject = '=?utf-8?b?'. base64_encode($subject) .'?=';
        }

        public function setBody($body)
        {
            $this->body = $body;
        }

        private function createHeader()
        {
            $header = "Content-type: text/plain; charset=\"utf-8\"\r\n";
            $header .= "From: ". $this->from ." <". $this->from ."> \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Date: ". date('D, d M Y h:i:s O') ."\r\n";

            $this->headers = $header;
        }

        private function checkData()
        {
            if(empty($this->to) || empty($this->subject) || empty($this->body))
            {
                return false;
            }
            else
            {
                $this->createHeader();
                return true;
            }
        }

        public function send()
        {
            if(!$this->checkData())
            {
                return 'Указаны не все параметры';
            }

	    $this->writeLog($this->to, $this->headers, $this->subject, $this->body);

            if(mail($this->to, $this->subject, $this->body, $this->headers, '-f'. $this->from ))
                return true;
            else
                return false;
        }
    }