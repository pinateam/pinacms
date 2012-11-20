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



class ActiveRecord
{
	protected $gatewayName = '';
	protected $data = array();
	protected $id = 0;

	public function __construct($gatewayName = '')
	{
		if (!empty($gatewayName))
		{
			$this->gatewayName = $gatewayName;
		}

		$gwName = $this->gatewayName;
		$this->gw = new $gwName();
	}

	public function init($id)
	{
		$this->id = $id;
	}

	public function read()
	{
		$this->data = $this->gw->get($this->id);
		if (empty($this->data)) return false;
		return true;
	}

	public function save()
	{
		if ($this->id) return $this->gw->edit($this->id, $this->data);

		$this->id = $this->gw->add($this->data);

		return !empty($this->id);
	}

	public function fetch()
	{
		return $this->data;
	}
}