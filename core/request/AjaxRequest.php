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



/*
 * Запрос, который предназначен для вызова через AJAX и возвращает данные в формате JSON,
 * где поля:
 * r - результат (ok или fail) - от слова Result
 * e - список ошибок - от слова Error
 * w - список предупреждений - от слова Warning
 * t - адрес редиректа в случае необходимости перенаправить пользователя
 * на определенную страницу после выполнения запроса - от слова Target
 *
 * Список ошибок и предупреждений состоит из массива объектов с полями:
 * s - имя эдемента, который критикуется - от слова Subject
 * m - сообщение - от слова Message
 */

require_once PATH_CORE."request/BaseRequest.php";

class AjaxRequest extends BaseRequest
{

	var $errors = array();
	var $warnings = array();
	var $values = array();

	var $results = array();

	function makePacket($r)
	{
		$packet = array(
			"r" => $r,
		);
		if ($this->warnings)
		{
			$packet["w"] = $this->warnings;
		}
		if ($this->errors)
		{
			$packet["e"] = $this->errors;
		}
		if ($this->results)
		{
			$packet["d"] = $this->results;
		}
		if ($this->redirect)
		{
			$packet["t"] = $this->redirect;
		}
		return $packet;
	}

	function ok($message = '')
	{
		$this->results['message'] = $message;
		echo json_encode($this->makePacket("ok"));
	}

	function warning($message, $subject = '')
	{
		$this->warnings[] = array("s" => $subject, "m" => $message);
	}

	function error($message, $subject = '')
	{
		$this->errors[] = array("s" => $subject, "m" => $message);
	}

	function trust()
	{
		if (is_array($this->errors) && count($this->errors) > 0)
		{
			echo json_encode($this->makePacket("fail"));
			die();
		}
	}

	function stop($message, $subject = '')
	{
		$this->errors[] = array("s" => $subject, "m" => $message);
		$this->trust();
	}

	function result($name, $value)
	{
		// закидываем результаты выполнения запроса во временный буфер,
		// чтобы потом отдать через json или xml
		$this->results[$name] = $value;
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