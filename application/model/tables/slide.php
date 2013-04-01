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

class SlideGateway extends TableDataGateway
{
	var $table = 'cody_slide';
	var $orderBy = 'slide_order ASC';
	var $fields = array(
		'slide_id' => "int(10) NOT NULL AUTO_INCREMENT",
		'site_id' => "int(10) NOT NULL DEFAULT '0'",
		'slide_filename' => "varchar(255) NOT NULL DEFAULT '0'",
		'slide_width' => "int(1) NOT NULL DEFAULT '0'",
		'slide_height' => "int(1) NOT NULL DEFAULT '0'",
		'slide_type' => "varchar(20) NOT NULL DEFAULT ''",
		'slide_size' => "int(10) NOT NULL DEFAULT '0'",
		'slide_alt' => "varchar(32) NOT NULL DEFAULT ''",
		'slide_href' => "varchar(64) NOT NULL DEFAULT ''",
		'slide_enabled' => "varchar(1) NOT NULL DEFAULT 'N'",
		'slide_order' => "int(1) NOT NULL DEFAULT '0'",
	);

	var $indexes = array(
                'PRIMARY KEY' => 'slide_id',
		'KEY site_id' => 'site_id',
		'KEY slide_enabled' => 'slide_enabled',
	);

	var $useSiteId = true;

	function findAvailable()
	{
		return $this->db->table("SELECT * FROM ".$this->table." WHERE slide_enabled = 'Y'".$this->getBySiteAndAccount().$this->getOrderBy());
	}
}