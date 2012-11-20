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


require_once PATH_CORE.'classes/TableDataGateway.php';

class WorkGateway extends TableDataGateway
{
	var $table = "cody_work";
	var $primaryKey = "work_id";
	var $fields = array(
		"work_id",
		"work_group_id",
		"site_id",
		"work_title",
		"work_description",	    
		"work_enabled",
	        "work_order"
	
	);
	var $orderBy = 'work_order ASC';
	var $useSiteId = true;

	function findAvailableBySiteAnd($field, $needle, $paging = false)
	{
		$siteId = intval($this->siteId);
		return $this->db->table("SELECT * FROM ".$this->table." WHERE ".$this->constructByCondition($field, $needle)." AND site_id = '".$siteId."' AND work_enabled = 'Y'".$this->getOrderBy());
	}
}


	
	


