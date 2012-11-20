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


class ExtManager
{
	private static $instance   = null;
	private static $extensions = array();
	
	private function __construct()
	{
	}

	private function __clone()
	{
	}
	
	public static function instance()
	{
		if (self::$instance == null) self::$instance = new ExtManager();
		return self::$instance;
	}
	
	public function add($method, $extension)
	{
		self::$extensions[$method][] = $extension;
	}
	
	public function get($method = '')
	{
		if ($method == '')
		{
			$backtrace = debug_backtrace();
			$method = $backtrace[1]['class'].'::'.$backtrace[1]['function'];
		}
	
		if (isset(self::$extensions[$method]) && is_array(self::$extensions[$method]))
		{
			$return = self::$extensions[$method];
		}
		else
		{
			$return = array();
		}
		
		return $return;
	}

	public function clear($method)
	{
		self::$extensions[$method] = array();
	}
}