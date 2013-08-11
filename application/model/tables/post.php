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

class PostGateway extends TableDataGateway
{
	var $table = "cody_post";
	var $fields = array(
		'post_id' => "int(10) NOT NULL AUTO_INCREMENT",
		'site_id' => "int(10) NOT NULL DEFAULT '0'",
		'user_id' => "int(10) NOT NULL DEFAULT '0'",
		'post_title' => "varchar(255) NOT NULL DEFAULT ''",
		'post_text' => "text NOT NULL",
		'blog_id' => "int(10) NOT NULL DEFAULT '0'",
		'image_id' => "int(10) NOT NULL DEFAULT '0'",
		'post_rating' => "int(1) NOT NULL DEFAULT '0'",
		'post_enabled' => "varchar(1) NOT NULL DEFAULT 'N'",
		'post_approved' => "varchar(1) NOT NULL DEFAULT 'N'",
		'post_created' => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
		'post_updated' => "timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'post_published' => "timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
	);

	var $indexes = array(
		'PRIMARY KEY' => 'post_id',
		'KEY site_id' => 'site_id',
		'KEY blog_id' => 'blog_id',
		'KEY user_id' => 'user_id',
		'KEY post_published' => 'post_published'
	);

	var $useSiteId = true;

	public function findByBlogId($blogId)
	{
		$blogId = intval($blogId);
		return $this->db->table("SELECT * FROM `".$this->table."` WHERE blog_id = '".$blogId."'".$this->getBySiteAndAccount().$this->getOrderBy());
	}
        
        public function findEnabledByBlogId($blogId)
        {
		$blogId = intval($blogId);
		return $this->db->table("SELECT * FROM `".$this->table."` WHERE blog_id = '".$blogId."' AND post_enabled = 'Y'".$this->getBySiteAndAccount().$this->getOrderBy());
        }
}