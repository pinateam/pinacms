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

class PageRequest extends BaseRequest {

    var $view;
    var $layout = "page";

    function __construct($data = array())
    {
        parent::__construct($data);

        @header('Content-type: text/html; charset='.SITE_CHARSET);

        $this->view = new Templater();

    	$this->view->assign("request_warnings", SessionHistory::get("request_warnings"));
    	$this->view->assign("request_errors", SessionHistory::get("request_errors"));
    	$this->view->assign("request_confirmations", SessionHistory::get("request_confirmations"));
    	SessionHistory::drop("request_warnings");
    	SessionHistory::drop("request_errors");
    	SessionHistory::drop("request_confirmations");

    	$this->layout = "page";
    }

    function setLayout($layout = "page")
    {
	    if (empty($layout)) return;

	    $this->layout = $layout;
    }

    function ok($message = "")
    {
        if (!empty($message))
        {
            Breadcrumbs::add($message, href($this->data));
        }
    }

    function warning($message, $subject = '')
    {
        // выводим сообщение на экран и продолжаем работу
        SessionHistory::add("request_warnings", array("message" => $message, "subject" => $subject));
    }

    function error($message, $subject = '')
    {
        // кладем сообщение в сессию
        SessionHistory::add("request_errors", array("message" => $message, "subject" => $subject));
    }

    function trust()
    {
        $errors = SessionHistory::get("request_errors");
        if (is_array($errors) && count($errors) > 0)
        {
            $this->redirect();
        }
    }

    function stop($message, $subject = '')
    {
        // кладем сообщение в сессию и перенаправляем на "страница не найдена"
        SessionHistory::add("request_errors", array("message" => $message, "subject" => $subject));
        $this->redirect();
    }

    function result($name, $value)
    {
        // привязываем к view соответствующие переменные
        $this->view->assign($name, $value);
    }

    function addLocation($caption, $url = "")
    {
	   Breadcrumbs::add($caption, $url);
    }

    function run()
    {
        if (!$this->isAvailable())
	{
		$this->data["action"] = 'access-denied';
	}

        $action = $this->getHandler();
        
        if (!file_exists(PATH_CONTROLLERS.$action.".php"))
	{
		$this->data["action"] = 'access-denied';
		$action = $this->getHandler();
	}

	$this->result("main", !empty($this->data["action"])?$this->data["action"]:"");

        $request = $this;
        include PATH_CONTROLLERS.$action.".php";

        $bs = Breadcrumbs::fetch();
        $this->view->assign("breadcrumbs", $bs);

        // запускаем показывать view
        $t = $this->view->fetch("layout/".$this->layout.".tpl");

        $t = url_rewrite($t);
        $t = lng_rewrite($t);
        echo $t;
    }
}