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



class BaseRequest
{
    var $data = array();
    var $redirect = "";

    function __construct($data = array())
    {
        $this->data = $data;
    }

    function set($name, $variable)
    {
    	$this->data[$name] = $variable;
    }

    function setRedirect($redirect)
    {
        $this->redirect = $redirect;
    }

    function redirect()
    {
        if (empty($this->redirect)) $this->redirect = !empty($_SERVER["HTTP_REFERER"])?$_SERVER["HTTP_REFERER"]:href(array("action" => "home"));
        redirect($this->redirect);
    }

    // успешное выполнение запроса
    function ok($message = '') {}

    function getHandler()
    {
        if (empty($this->data["action"])) return 'access-denied';

        $action = $this->data["action"];
        $action = str_replace('/', '',  $action);
        $action = str_replace('.', '/', $action);

        return $action;
    }

    // выполнение контроллера сопровождается предупреждением
    function warning($message, $subject = '') {}

    // выполнение контроллера сопровождается ошибкой.
    // $message - текст ошибки
    // $subject - код ошибки
    function error($message, $subject = '') {}

    // проверяет встречались ли ошибки при выполнении запроса и завершает
    // выполнение в случае найденных ошибок
    function trust() {}

    // выполнение контроллера прерывается ошибкой
    // $message - текст ошибки
    // $subject - код ошибки
    function stop($message, $subject = '') {}

    // получаем параметр запроса к контроллеру по его названию
    function param($name)
    {
        if (!isset($this->data[$name])) return false;
        
        return $this->data[$name];
    }

    function params($ps = "")
    {
        if (empty($ps)) return $this->data;

		if (!is_array($ps)) $ps = explode(' ', $ps);

		$res = array();
		if (is_array($ps))
		foreach ($ps as $p)
		{
			$res[$p] = isset($this->data[$p])?$this->data[$p]:null;
		}
		return $res;
    }

    function acceptParams($ps)
    {
	    if (!is_array($ps))
	    {
			$ps = explode(' ', $ps);
	    }

	    $ps = array_flip($ps);

	    foreach ($this->data as $k => $v)
	    {
		    if (!isset($ps[$k])) unset($this->data[$k]);
	    }
    }

	function filterParamsSub($fs, &$data)
	{
		foreach ($data as $k => $v)
		{
			if (is_array($data[$k]))
			{
				$this->filterParamsSub($fs, $data[$k]);
				continue;
			}

			foreach ($fs as $f)
			{
				if (empty($f)) continue;
				$data[$k] = call_user_func($f, $data[$k]);
			}
		}
	}

	function filterParams($clean_functions, $ps)
	{
		if (!is_array($ps))
		{
			$ps = explode(' ', $ps);
		}

		$fs = explode(' ', $clean_functions);
		foreach ($ps as $p)
		{
			if (empty($p) || !isset($this->data[$p])) continue;

			if (is_array($this->data[$p]))
			{
				$this->filterParamsSub($fs, $this->data[$p]);
				continue;
			}

			foreach ($fs as $f)
			{
			    if (empty($f)) continue;

			    $this->data[$p] = call_user_func($f, $this->data[$p]);
			}
		}
	}

	function filterAllParams($clean_functions)
	{
		if (empty($this->data) || !is_array($this->data)) return;
		$fs = explode(' ', $clean_functions);
		foreach ($this->data as $k => $v)
		{
			if (is_array($this->data[$k]))
			{
				$this->filterParamsSub($fs, $this->data[$k]);
				continue;
			}

			foreach ($fs as $f)
			{
				if (empty($f)) continue;
				$this->data[$k] = call_user_func($f, $this->data[$k]);
			}
		}
	}

	// связываем результат выполнения контроллера
	function result($name, $value) {}

	function addLocation($caption, $url = "") {}

	function isAvailable()
	{
		return 
			isset($this->data["action"]) && 
			isModuleActive($this->data["action"]) && 
			isModulePermitted($this->data["action"]);
	}

	function run() {}
}