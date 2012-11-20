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
	var $fields = array
	(
		"account_id", "user_title", "user_login", "user_password", "user_email", "activation_token", "restore_token",
		"user_status", "access_group_id", "user_gender", "user_created", "user_updated"
	);

	var $useAccountId = true;

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
}