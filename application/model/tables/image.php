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

class ImageGateway extends TableDataGateway
{
	var $table = "cody_image";
	var $primaryKey = "image_id";
	var $fields = array(
		'image_id' => "INT(10) NOT NULL AUTO_INCREMENT",
		'site_id' => "INT(10) NOT NULL default '0'",
		'original_image_id' => "INT(10) NOT NULL default '0'",
		'image_filename' => "VARCHAR(255) NOT NULL default '0'",
		'image_width' => "INT(1) NOT NULL default '0'",
		'image_height' => "INT(1) NOT NULL default '0'",
		'image_type' => "VARCHAR(20) NOT NULL default ''",
		'image_size' => "INT(10) NOT NULL default '0'",
		'image_alt' => "varchar(120) NOT NULL DEFAULT ''",
	);
	var $indexes = array(
		'PRIMARY KEY' => 'image_id',
		'KEY site_id' =>  'site_id'
	);

	var $useSiteId = true;

	function findByRelationId($gateway, $key, $id)
	{
		$key = $this->db->escape($key);
		$id = $this->db->escape($id);
		
		return $this->db->table("SELECT * FROM
			".$this->table."
			LEFT JOIN ".$gateway->table." ON ".$this->table.".image_id = ".$gateway->table.".image_id
			WHERE ".$gateway->table.".".$key." = '".$id."'
		");
	}
}