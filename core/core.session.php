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



class Session
{
    static function init($id = false)
    {
	if (!empty($id)) session_id($id);
        session_start();
    }

    static function get($key)
    {
	if (isset($_SESSION[$key]))
	{
		return $_SESSION[$key];
	}

	return false;
    }

    static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    static function exists($key)
    {
        return isset($_SESSION[$key]);
    }

    static function drop($key)
    {
	unset($_SESSION[$key]);
    }

    static function id()
    {
	    return session_id();
    }
}

class SessionHistory
{
    static function getKey($str)
    {
        return '__histr__'.$str;
    }

    static function add($list, $value)
    {
        $v = Session::get(self::getKey($list));
        if (!is_array($v))
        {
            $v = array();
        }
        $v[] = $value;
        Session::set(self::getKey($list), $v);
    }

    static function has($list, $value)
    {
        if (!Session::exists(self::getKey($list))) return array();

        return in_array($value, Session::get(self::getKey($list)));
    }

    static function get($list)
    {
        return Session::get(self::getKey($list));
    }

    static function drop($list)
    {
        Session::drop(self::getKey($list));
    }
}