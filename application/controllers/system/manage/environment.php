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



	
	// Рекомендуемые модули Apache
	$apache_modules_recommended = array();
	if (function_exists("apache_get_modules"))
	{
		$apache_modules = apache_get_modules();

		$apache_modules_recommended = array(
			'mod_deflate' => array('title' => 'Deflate', 'info' => lng('env_test_apache_deflate_info'), 'loaded' => in_array('mod_deflate', $apache_modules)),
			'mod_rewrite' => array('title' => 'ModRewrite', 'info' => lng('env_test_apache_rewrite_info'), 'loaded' => in_array('mod_rewrite', $apache_modules)),
		);
	}

	$request->result('php_version', EnvironmentDomain::checkPhpVersion());
	$request->result('php_extensions_required', EnvironmentDomain::checkPhpExtensions());
	$request->result('php_directives', EnvironmentDomain::checkPhpDirectives());
	$request->result('apache_modules_recommended', EnvironmentDomain::checktRecommendedApacheModules());

	$request->addLocation(lng("settings"), href(array("action" => "config.manage.home")));
	$request->setLayout('admin');
	$request->ok(lng('environment_testing'));
	
