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

class PostCommentGateway extends TableDataGateway
{

	var $table = "cody_post_comment";
	var $primaryKey = "comment_id";
	var $fields = array(
		"site_id","post_id","visitor_name","visitor_email", "visitor_ip",
		"comment_message","comment_approved","comment_created","user_id",
		"visitor_site","comment_updated","answer_comment_id","rating"

	);

	var $useSiteId = true;

	public function findBySiteAndPostAndApproved($post_id, $comment_approved)
	{
		$post_id = intval($post_id);
		$siteId = intval($this->siteId);

		$approved = '';

		if ($comment_approved) $approved = "comment_approved = '".$comment_approved."'";

		$sql = "SELECT *
			FROM `$this->table`
			WHERE `post_id` = '".$post_id."' AND `site_id` = '".$siteId."' AND $approved
			ORDER BY `comment_created`";

		return $this->db->table($sql);
	}

	public function reportUserId($commentId)
	{
		$commentId = intval($commentId);

		$sql = "SELECT user_id FROM `$this->table`
			WHERE `comment_id` = '".$commentId."'"; 	

		return $this->db->one($sql);
	}	

}