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


class Sorting
{
	private $field;
	private $direction;

	public function __construct($field, $direction)
	{
		$this->field = $field;
		if (in_array($direction, array('asc', 'desc')))
		{
			$this->direction = $direction;
		}
		else
		{
			$this->direction = $direction?'asc':'desc';
		}

	}
	
	public function getField()
	{
		return $this->field;
	}
	
	public function getDirection()
	{
		return $this->direction;
	}

	public function setField($field)
	{
		$this->field = $field;
	}
	
	public function setDirection($direction)
	{
		$this->direction = $direction;
	}

	public function fetch()
	{
		return array("field" => $this->field, "direction" => $this->direction);
	}

	public function load($data)
	{
		$this->field = $data["field"];
		$this->direction = $data["direction"];
	}

	public function isEmpty()
	{
		return empty($this->field);
	}
}