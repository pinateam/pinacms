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

class PersonGateway extends TableDataGateway
{
	var $table = "cody_person";
	var $primaryKey = "person_id";
	var $fields = array(
		'person_id' => "INT(11) NOT NULL AUTO_INCREMENT",
		'site_id' => "INT(11) NOT NULL DEFAULT '0'",

		'person_title' => "varchar(256) NOT NULL DEFAULT ''",
		'person_position' => "varchar(256) NOT NULL DEFAULT ''",
		'person_description' => "TEXT NOT NULL",
		'person_order' => "INT(11) NOT NULL DEFAULT '0'",
		'person_enabled' => "VARCHAR(1) NOT NULL DEFAULT 'Y'",

		'person_email' => "VARCHAR(64) NOT NULL DEFAULT ''",
		'person_phone' => "VARCHAR(32) NOT NULL DEFAULT ''",
	);

	var $indexes = array(
		'PRIMARY KEY' => 'person_id',
		'KEY site_id' => 'site_id'
	);
	
	var $orderBy = 'person_order ASC';

	var $useSiteId = true;
}