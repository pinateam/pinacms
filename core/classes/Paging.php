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



class Paging
{
	public $current;
	public $perPage;
	public $total;

	public function __construct($current, $perPage)
	{
		$this->current = $current;
		$this->perPage = $perPage;
	}

	static public function create($current, $perPage)
	{
		$p = new Paging($current, $perPage);
		return $p;
	}

	public function setTotal($total)
	{
		$this->total = $total;
	}

	public function getTotal()
	{
		return $this->total;
	}

	public function getStart()
	{
		if ($this->current < 1) return 0;
		
		$pagesCount = $this->getPagesCount();
		
		if ($pagesCount < 1) $pagesCount = 1;

		if (!empty($pagesCount) && $this->current > $pagesCount) $this->current = $pagesCount;
		
		return ($this->current - 1) * $this->perPage;
	}
	
	public function getCurrent()
	{
		if ($this->current == 0) return 1;
		
		return $this->current;
	}

	public function getCount()
	{
		return $this->perPage;
	}
	
	public function getPagesCount()
	{
		return ceil($this->total / $this->perPage);
	}

	public function slice($ids)
	{
		return array_slice($ids, $this->getStart(), $this->getCount());
	}

	public function fetch()
	{
		return array(
			'current' => $this->getCurrent(),
			'total'   => $this->getPagesCount(),
			'items'   => $this->total
		);
	}
}
