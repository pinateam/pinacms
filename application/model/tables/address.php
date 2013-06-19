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

    class AddressGateway extends TableDataGateway
    {
            var $table = 'cody_address';
            var $primaryKey = 'address_id';

            var $fields = array(
                    'address_id' => "int(10) NOT NULL AUTO_INCREMENT",
                    'user_id' => "int(10) NOT NULL DEFAULT '0'",
                    'address_title' => "varchar(32) NOT NULL DEFAULT ''",
                    'address_firstname' => "varchar(128) NOT NULL DEFAULT ''",
                    'address_lastname' => "varchar(128) NOT NULL DEFAULT ''",
                    'address_middlename' => "varchar(128) NOT NULL DEFAULT ''",
                    'address_street' => "varchar(255) NOT NULL DEFAULT ''",
                    'address_city' => "varchar(255) NOT NULL DEFAULT ''",
                    'address_county' => "varchar(64) NOT NULL DEFAULT ''",
                    'address_state_key' => "varchar(2) NOT NULL DEFAULT ''",
                    'address_country_key' => "varchar(2) NOT NULL DEFAULT ''",
                    'address_zip' => "varchar(32) NOT NULL DEFAULT ''",
                    'address_zip4' => "varchar(32) NOT NULL DEFAULT ''",
                    'address_phone' => "varchar(32) NOT NULL DEFAULT ''",
                    'address_fax' => "varchar(32) NOT NULL DEFAULT ''",
            );
            var $indexes = array(
                    'PRIMARY KEY' => 'address_id'
            );

	    public function getShortByid($id)
	    {
	    	$id = intval($id);
	        return $this->db->row("SELECT user_zipcode, user_country_key, user_state_key, user_address
	                               FROM ".$this->table."
	                               WHERE user_id = '".$id."'
	                               LIMIT 1");
	    }

		public function getByType($type, $user_id)
		{
			if (empty($type)) return false;

			$type = $this->db->escape($type);
			$user_id = intval($user_id);

			return $this->db->row("
				SELECT a.* FROM
					cody_user_config c, cody_address a
				WHERE
					c.".$type."_address_id = a.address_id
					AND c.user_id = '".$user_id."'
				LIMIT 1
			");
		}
    }
