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

class ApiRequest extends BaseRequest
{
	function ok($message = '')
	{
		// кладем сообщение в сесиию, чтобы потом вывести еполего
		SessionHistory::add("request_confirmations", array("message" => $message));
	}

	function warning($message, $subject = '')
	{
		// добавляем предупреждение в очередь предупреждений, чтобы вывести их
		// после загрузки странички
		SessionHistory::add("request_warnings", array("message" => $message, "subject" => $subject));
	}

	function error($message, $subject = '')
	{
		SessionHistory::add("request_errors", array("message" => $message, "subject" => $subject));
	}

	function trust()
	{
		// проверяем есть ли ошибки и завершаем выполнение редиректом
		$errors = SessionHistory::get("request_errors");
		if (is_array($errors) && count($errors) > 0)
		{
			$this->redirect();
		}
	}

	function stop($message, $subject = '')
	{
		// кладем сообщение в сессию, помечаем поле с ошибкой и завершаем
		// выполнение редиректом
		SessionHistory::add("request_errors", array("message" => $message, "subject" => $subject));
		$this->redirect();
	}

	function result($name, $value)
	{
		SessionHistory::add("request_results", array($name => $value));
	}

	function run($action = '')
	{
		if (!empty($action)) $this->data["action"] = $action;

		if (!$this->isAvailable())
		{
			return false;
		}

		$action = $this->getHandler();

		if (!file_exists(PATH_API.$action.".php"))
		{
			return false;
		}

		$request = $this;
		include PATH_API.$action.".php";

		return true;
	}
}