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


	// Версия PHP
	$php_version_expected = '5.0';
	$php_version_value = phpversion();
	
	$php_version = array(
		'expected' => $php_version_expected,
		'value' => $php_version_value,
		'warning_type' => version_compare($php_version_value, $php_version_expected, '>=') ? 'ok' : 'error'
	);
	
	// Обязательные расширения PHP
	$php_extensions_required = array(
		'curl'      => array('title' => 'CURL', 'info' => lng('env_test_ext_curl_info'), 'loaded' => extension_loaded('curl')),
		'gd'        => array('title' => 'GD', 'info' => lng('env_test_ext_gd_info'), 'loaded' => extension_loaded('gd')),
		'mbstring'  => array('title' => 'Multibyte String', 'info' => lng('env_test_ext_mbstring_info'), 'loaded' => extension_loaded('mbstring')),
		'mysql'     => array('title' => 'MySQL', 'info' => lng('env_test_ext_mysql_info'), 'loaded' => extension_loaded('mysql')),
		'tokenizer' => array('title' => 'Tokenizer', 'info' => lng('env_test_ext_tokenizer_info'), 'loaded' => extension_loaded('tokenizer')),
		'iconv'     => array('title' => 'Функция iconv', 'info' => lng('env_test_ext_iconv_info'), 'loaded' => function_exists('iconv')),
		'simplexml' => array('title' => 'SimpleXML', 'info' => lng('env_test_ext_simplexml_info'), 'loaded' => extension_loaded('simplexml')),
	);
	
	// Проверка значений PHP-директив
	$safe_mode_expected = 'Off';
	$safe_mode_value = ini_get('safe_mode') ? 'On' : 'Off';
	
	$magic_quotes_runtime_expected = 'Off';
	$magic_quotes_runtime_value = ini_get('magic_quotes_runtime') ? 'On' : 'Off';
	
	$magic_quotes_sybase_expected = 'Off';
	$magic_quotes_sybase_value = ini_get('magic_quotes_sybase') ? 'On' : 'Off';
	
	$use_cookies_expected = 'On';
	$use_cookies_value = ini_get('session.use_cookies') ? 'On' : 'Off';
	
	$use_trans_sid_expected = 'On';
	$use_trans_sid_value = ini_get('session.use_trans_sid') ? 'On' : 'Off';
	
	$memory_limit_expected = '32M';
	$memory_limit_value = ini_get('memory_limit');
	
	$php_directives = array(
		'safe_mode' => array(
			'expected' => '= '.$safe_mode_expected,
			'value' => $safe_mode_value,
			'warning_type' => $safe_mode_expected == $safe_mode_value ? 'ok' : 'error'
		),
		'magic_quotes_runtime' => array(
			'expected' => '= '.$magic_quotes_runtime_expected,
			'value' => $magic_quotes_runtime_value,
			'warning_type' => $magic_quotes_runtime_expected == $magic_quotes_runtime_value ? 'ok' : 'error'
		),
		'magic_quotes_sybase' => array(
			'expected' => '= '.$magic_quotes_sybase_expected,
			'value' => $magic_quotes_sybase_value,
			'warning_type' => $magic_quotes_sybase_expected == $magic_quotes_sybase_value ? 'ok' : 'error'
		),
		'session.use_cookies' => array(
			'expected' => '= '.$use_cookies_expected,
			'value' => $use_cookies_value,
			'warning_type' => $use_cookies_expected == $use_cookies_value ? 'ok' : 'error'
		),
		'session.use_trans_sid' => array(
			'expected' => '= '.$use_trans_sid_expected,
			'value' => $use_trans_sid_value,
			'warning_type' => $use_trans_sid_expected == $use_trans_sid_value ? 'ok' : 'warning'
		),
		'memory_limit' => array(
			'expected' => '>= '.$memory_limit_expected,
			'value' => $memory_limit_value,
			'warning_type' => return_bytes($memory_limit_value) >= return_bytes($memory_limit_expected) ? 'ok' : 'warning'
		),
	);
	
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
	
	// Вывод результатов
	$request->result('php_version', $php_version);
	$request->result('php_extensions_required', $php_extensions_required);
	$request->result('php_directives', $php_directives);
	$request->result('apache_modules_recommended', $apache_modules_recommended);

	$request->addLocation(lng("settings"), href(array("action" => "config.manage.home")));
	$request->setLayout('admin');
	$request->ok(lng('environment_testing'));
	
	// Функция перевода значения memory_limit в байты
	function return_bytes($val) {
		$val = trim($val);
		$last = strtolower($val[strlen($val) - 1]);
		
		switch($last) {
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
			case 'k':
				$val *= 1024;
		}

		return $val;
	}