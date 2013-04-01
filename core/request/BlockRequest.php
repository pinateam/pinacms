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



require_once PATH_CORE."request/BaseRequest.php";
require_once PATH_CORE."templater/templater.php";

class BlockRequest extends BaseRequest
{
	var $view;

	var $error_messages = array();

	var $__result = '';

	function __construct($view, $data)
	{
		if (empty($view))
		{
			$view = new Templater();
		}

		$this->view = $view;

		parent::__construct($data);
	}

	function setLayout($layout = "page")
	{
		if (empty($layout)) return;

		$this->layout = $layout;
	}

	function ok($message = '')
	{
		// заканчиваем отрисовку блока, запускаем view
	}

	function warning($message = "", $subject = '')
	{
		// не выводим сообщение на экран, так как считаем, что предупреждения для BlockRequest не нужны,
		// и продолжаем работу
	}

	function error($message = "", $subject = '')
	{
		// выводим сообщение на экран или не выводим блок вообще
		// вызываем исключение, которое будет обработано в блоке
		$this->error_messages [] = $message;
	}

	function trust()
	{
		if (!empty($this->error_messages))
		{
			if (defined(BLOCK_EXCEPTIONS))
			{
				throw new Exception(join("\n", $this->error_messages));
			}
			else
			{
				$this->result("error_messages", $this->error_messages);
				#die(join("\n", $this->error_messages));
			}
		}
	}

	function stop($message = "", $subject = '')
	{
		if (defined("BLOCK_EXCEPTIONS") && BLOCK_EXCEPTIONS)
		{
			throw new Exception($message);
		}
		else
		{
			$this->error_messages [] = $message;
			$this->result("error_messages", $this->error_messages);
			#die($message);
		}
	}

	function result($name, $value)
	{
		// привязываем к view соответствующие переменные
		$this->view->assign($name, $value);
	}

    function run()
    {
	#echo "\r\n<!--\r\nenter ".$this->data["action"]."\r\n-->\r\n";
	#list($msec, $sec) = explode(' ', microtime());
	#$s_time = (float)$msec + (float)$sec;

        if (!$this->isAvailable()) return '';

	$_cached = $this->cacheGet("block");

	if (!empty($_cached))
	{
		#list($msec, $sec) = explode(' ', microtime());
		#$time_total = ((float)$msec + (float)$sec - $s_time);

		#echo "\r\n<!--\r\nleave ".$this->data["action"]." cached ".$time_total."\r\n-->\r\n";

		return $_cached;
	}

        $action = $this->getHandler();
        
        if (!file_exists(PATH_CONTROLLERS.$action.".php")) return;

        try
	{
		$request = $this;
		include PATH_CONTROLLERS.$action.'.php';
	}
	catch (Exception $e)
	{
		echo $e->getMessage();
		return;
	}
        
        $t = $request->view->fetch('blocks/'.$action.'.tpl');

        //$t = url_rewrite($t);
        $t = lng_rewrite($t);

	$this->cacheSet("block", $t);

	#list($msec, $sec) = explode(' ', microtime());
	#$time_total = ((float)$msec + (float)$sec - $s_time);

	#echo "\r\n<!--\r\nleave ".$this->data["action"]." ".$time_total."\r\n-->\r\n";

        return $t;
    }
}