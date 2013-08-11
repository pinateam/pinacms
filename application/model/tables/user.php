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

class UserGateway extends TableDataGateway
{
	var $table = "cody_user";
	var $fields = array(
		'user_id' => "int(10) NOT NULL AUTO_INCREMENT",
		'account_id' => "int(10) NOT NULL DEFAULT '0'",
		'user_title' => "varchar(255) NOT NULL DEFAULT ''",
		'user_login' => "varchar(32) NOT NULL DEFAULT ''",
		'user_password' => "varchar(64) NOT NULL DEFAULT ''",
		'user_email' => "varchar(64) NOT NULL DEFAULT ''",
		'activation_token' => "varchar(32) NOT NULL DEFAULT ''",
		'restore_token' => "varchar(32) NOT NULL DEFAULT ''",
		'user_status' => "enum('new','active','suspensed','disabled') NOT NULL DEFAULT 'new'",
		'access_group_id' => "int(10) NOT NULL DEFAULT '1'",
		'user_gender' => "enum('male','female','unspecified') NOT NULL DEFAULT 'unspecified'",
		'user_created' => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
		'user_updated' => "timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'facebook_id' => 'bigint(64) UNSIGNED NOT NULL DEFAULT 0',
		'twitter_id' => 'bigint(64) UNSIGNED NOT NULL DEFAULT 0'
	);

	var $indexes = array(
        'PRIMARY KEY' => 'user_id',
		'UNIQUE KEY user_login' => 'user_login',
		'UNIQUE KEY user_email' => 'user_email',
		'KEY facebook_id' => 'facebook_id',
		'KEY twitter_id' => 'twitter_id'
	);

	var $useAccountId = true;

	public function reportAccessGroupIdByUserId($user_id)
	{
		$q = "SELECT access_group_id FROM cody_user ";

		
		//if (Site::id()) $q .= "LEFT JOIN cody_site ON cody_site.account_id = cody_user.account_id ";
		

		$q .= "WHERE cody_user.user_id = '".Session::get('auth_user_id')."' ";

		
		$q .= "AND (cody_user.account_id = '".Site::accountId()."' OR cody_user.access_group_id = 2) LIMIT 1";
		//if (Site::id()) $q .= "AND (cody_site.site_id = '".Site::id()."' OR access_group_id = 2)";
		

		return $this->db->one($q);
	}

	public function reportExists($id)
	{
		$q = "SELECT count(*) FROM cody_user ";

		$q .= "WHERE cody_user.user_id = '".Session::get('auth_user_id')."' ";

		
		$q .= "AND (cody_user.account_id = '".Site::accountId()."' OR cody_user.access_group_id = 2) LIMIT 1";
		

		return $this->db->one($q);
	}

	public function getByLoginOrEmail($user_login, $user_email)
	{
		$user_login = $this->db->escape($user_login);
		$user_email = $this->db->escape($user_email);
		return $this->db->row("SELECT * FROM ".$this->table." WHERE user_login = '".$user_login."' OR user_email = '".$user_email."' LIMIT 1");
	}

	public function getByActivationToken($token)
	{
		$token = $this->db->escape($token);
		return $this->db->row("SELECT * FROM ".$this->table." WHERE activation_token = '".$token."' LIMIT 1");
	}

	public function getByRestoreToken($token)
	{
		$token = $this->db->escape($token);
		return $this->db->row("SELECT * FROM ".$this->table." WHERE restore_token = '".$token."' LIMIT 1");
	}

        public function getShortByid($id)
        {
		$id = intval($id);
                return $this->db->row("SELECT user_email
                                       FROM ".$this->table."
                                       WHERE user_id = '".$id."'
                                       LIMIT 1");
        }

	public function reportEmailByid($id)
        {
		$id = intval($id);
                return $this->db->one("SELECT user_email
                                       FROM ".$this->table."
                                       WHERE user_id = '".$id."'
                                       LIMIT 1");
        }

        public function reportTitle($id)
        {
		$id = intval($id);
                return $this->db->one("SELECT `user_login`
                                       FROM `".$this->table."`
                                       WHERE `user_id` = '".$id."'
                                       LIMIT 1
                                      ");
        }

	public function reportAutocomplete($q)
	{
		$fields = array(
			'user_id',
			'user_title',
			'user_login'
		);

		$q = $this->db->escape($q);

		$query = "";
		foreach($fields as $field)
		{
			if (!empty($query)) $query .= " UNION ";

			$query .= "
				(SELECT `". $field ."` as v
				FROM `".$this->table."`
				WHERE `". $field ."` LIKE '".$q."%' ".$this->getBySiteAndAccount().")";
		}

		return $this->db->col($query);
	}
}
