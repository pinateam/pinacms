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
	var $fields = array
	(
		"site_id", "user_id", "post_title", "post_text", "blog_id", "post_rating",
		"post_enabled", "post_moderated", "post_created", "post_updated"
	);

	var $useSiteId = true;

	public function findByBlogId($blogId)
	{
		$siteId = intval($this->siteId);
		$blogId = intval($blogId);
		return $this->db->table("SELECT * FROM `".$this->table."` WHERE site_id = '".$siteId."' AND blog_id = '".$blogId."'".(!empty($this->orderBy)?(" ORDER BY ".$this->orderBy):""));
	}
        
        public function findEnabledByBlogId($blogId)
        {
		$siteId = intval($this->siteId);
		$blogId = intval($blogId);
		return $this->db->table("SELECT * FROM `".$this->table."` WHERE site_id = '".$siteId."' AND blog_id = '".$blogId."' AND post_enabled = 'Y'".(!empty($this->orderBy)?(" ORDER BY ".$this->orderBy):""));
        }
}