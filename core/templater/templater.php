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



include_once PATH_SMARTY.'Smarty.class.php';
include_once PATH_SMARTY.'Smarty_Compiler.class.php';
		
class Templater extends Smarty
{
	function Templater()
	{
		$this->strict_resources = array ();
		array_unshift($this->plugins_dir, PATH.'core'.DIR_SEP.'templater'.DIR_SEP.'plugins');

		$this->use_sub_dirs = false;
		$this->template_dir = array();
		$this->template_dir[] = PATH_VIEW."sites/".Site::path().'/';
		if (Site::template())
		{
			$this->template_dir[] = PATH_VIEW."templates/".Site::template().'/';
		}
		$this->template_dir[] = PATH_VIEW."default/";

		$this->compile_dir = PATH_COMPILED_TEMPLATES.md5(Site::path());
		@mkdir($this->compile_dir);

		$this->cache_dir = PATH_CACHE;
		$this->secure_dir = PATH_LAYOUTS;

		$config = getConfig();
		$this->assign("config", $config->fetch());

		$this->setLayout();
		return parent::Smarty();
	}

	public function setLayout($layout = 'page')
	{
		$this->layout = $layout;
	}
}

?>
