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


class Language extends BaseConfig
{
	private static $code = 'ru';
	var $baseName = 'string';
	
	/**
	 *
	 * Установка/извлечение кода текущего языка сайта
	 *
	 * @param string $code - двубуквенный код языка. Если параметр пуст,
	 *   функция вернет текущее значение. Иначе - установит новое значение
	 *   и вернет предыдущее
	 *
	 * Функция возвращает код языка (текущий или предыдущий)
	 *
	 */
	public static function code($code = '')
	{
		if ($code == '') return self::$code;
		
		$old_code = self::$code;
		
		self::$code = $code;
		
		return $old_code;
	}
}


function getLanguage()
{
	static $language = '';
	if (!empty($language)) return $language;

	$language = new Language;
	return $language;
}