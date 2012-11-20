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



class BaseMail
{
        var $type = 'text/plain';
        var $to;
        var $from;
        var $subject;
        var $body;
        var $headers;

        public function setHtml(){}
        public function setTo(){}
        public function setFrom(){}
        public function setSubject(){}
        public function setBody(){}
        
        public function send(){}

	public function setBodyAction($action, $params = false)
	{
		require_once PATH_CORE."request/BlockRequest.php";
		require_once PATH_CORE."core.dispatcher.php";

		if (empty($params)) $params = array();
		$params ["action"] = $action;

		$request = new BlockRequest(false, $params);
		$request->setLayout("mail");
		$request->result("main", $action);

		$handler = $request->getHandler();

		if (!isModuleActive($action) || !isModulePermitted($action))
		{
			return false;
		}

		if (file_exists(PATH_CONTROLLERS.$handler.".php"))
		{
			require_once PATH_CONTROLLERS.$handler.".php";
		}
		else
		{
			if (is_array($params))
			foreach ($params as $name => $value)
			{
				$request->view->assign($name, $value);
			}
		}

		$body = $request->view->fetch('layout/mail.tpl');
		$body = lng_rewrite($body);
		$body = url_rewrite($body);
		$this->setBody($body);
	}

	public function writeLog($email, $headers, $subject, $message)
	{
		static $mail_debug_counter = 0;
		if (!file_exists(PATH_DEBUG)) @mkdir(PATH_DEBUG, 0777);
		$f = fopen(PATH_DEBUG."email-".time().($mail_debug_counter++).".txt", "w");
		fwrite($f, "headers: \r\n".$headers);
		fwrite($f, "\r\ntarget: \r\n".$email);
		fwrite($f, "\r\nsubject: \r\n".$subject);
		fwrite($f, "\r\nmessage: \r\n".$message);
		fclose($f);
	}
}