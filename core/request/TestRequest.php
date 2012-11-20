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



/*
 * Запрос, который предназначен для выполнения утилитарных операций
 * Он не предполагает какой-либо отрисовки результата выполнения.
 * Все результаты, ошибки и предупреждения он складывает в сессию,
 * к которой при случае и должен обращаться вызывающий запрос.
 */

require_once PATH_CORE."request/BaseRequest.php";
require_once PATH_CORE."templater/templater.php";

class TestRequest extends BaseRequest
{
        private $request_warnings = array();
        private $request_errors = array();
        private $result = array();
        private $message = '';

	function ok($message = 'ok')
	{
                throw new Exception('ok');
	}

	function warning($message, $subject = '')
	{
		$this->request_warnings[$subject] = $message;
	}

	function error($message, $subject = '')
	{
		$this->request_errors[$subject] = $message;
	}

	function trust()
	{//print_r($this->request_errors);die;
                if(count($this->request_errors) > 0)
                {
                        throw new Exception('error');
                }
	}

	function stop($message, $subject = '')
	{//echo $message;die;
		throw new Exception('error');
	}

	function result($name, $value)
	{
                $this->result[$name] = $value;
	}

        function getErrors()
        {
                return $this->request_errors;
        }

        function getResult()
        {
                return $this->result;
        }

	function run($action = '')
	{
		if (!empty($action)) $this->data["action"] = $action;

		if (!$this->isAvailable())
		{
			$this->data["action"] = 'access-denied';
		}

		$action = $this->getHandler();
//echo $action;die;
		if (!file_exists(PATH_API.$action.".php"))
		{
			$this->data["action"] = 'access-denied';
			$action = $this->getHandler();
		}

		$request = $this;
		include PATH_API.$action.".php";
	}
}