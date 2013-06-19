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

class SubscriptionGateway extends TableDataGateway
{
	var $table = "cody_subscription";
	var $fields = array(
		'subscription_id' => "int(10) NOT NULL AUTO_INCREMENT",
		'site_id' => "int(10) NOT NULL DEFAULT '0'",
		'user_id' => "int(10) NOT NULL DEFAULT '0'",
		'subscription_email' => "varchar(64) NOT NULL DEFAULT ''",
		'subscription_created' => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP"
	);

	var $indexes = array(
                'PRIMARY KEY' => 'subscription_id',
		'KEY site_id' => 'site_id'
	);

	var $useSiteId = true;

        public function getByEmail($email)
        {
		return $this->db->one("SELECT `subscription_id` FROM `$this->table` WHERE `subscription_email` = '".$this->db->escape(trim($email))."'".$this->getBySiteAndAccount());
        }
}