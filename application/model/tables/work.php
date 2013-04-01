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
		'work_id' => "INT(11) NOT NULL AUTO_INCREMENT",
		'site_id' => "INT(11) NOT NULL DEFAULT '0'",
		'work_group_id' => "INT(11) NOT NULL DEFAULT '0'",
		'work_order' => "INT(11) NOT NULL DEFAULT '0'",

		'work_description' => "TEXT NOT NULL",
		'work_title' => "varchar(256) NOT NULL DEFAULT ''",
		'work_enabled' => "VARCHAR(1) NOT NULL DEFAULT 'Y'",
	);

	var $indexes = array(
                'PRIMARY KEY' => 'work_id',
		'KEY site_id' => 'site_id'
	);

	var $orderBy = 'work_order ASC';
	var $useSiteId = true;

	function findAvailableBySiteAnd($field, $needle, $paging = false)
	{
		return $this->db->table("SELECT * FROM ".$this->table." WHERE ".$this->constructByCondition($field, $needle)." AND work_enabled = 'Y'".$this->getBySiteAndAccount().$this->getOrderBy());
	}
}


	
	


