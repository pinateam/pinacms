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



class DomainObject
{
	public $id;

	// may be abs
	static protected function loadEmpty()
	{
		assert(false);
		return new NullObject();
	}

	static protected function getGateway()
	{
		assert(false);
		return new NullGateway();
	}

	// убиваем инициализацию не существующих полей
	protected function __set($key, $val)
	{
	}

	// функция, инициализирующая класс на основе массива.
	// упрошает работу, ухудшила бы абстракцию, если была бы опубликована в публичном доступе
	public function fill($data)
	{
		if (!is_array($data)) return;

		foreach ($data as $k => $v)
		{
			// если поле не существует, то оно все равно не будет проинициализированно
			// из-за переопределенного метода __set
			$this->$k = $v;
		}
	}

	public function getId()
	{
		return $this->id;
	}

	public function isLoaded()
	{
		return !empty($this->id);
	}
}