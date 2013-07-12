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

class PhotoGateway extends TableDataGateway
{
	var $table = 'cody_photo';

	var $orderBy = 'photo_id DESC';

	var $fields = array(
		'photo_id' => "int(10) NOT NULL AUTO_INCREMENT",
		'site_id' => "int(10) NOT NULL DEFAULT '0'",
		'post_id' => "int(10) NOT NULL DEFAULT '0'",
		'common_filename' => "varchar(255) NOT NULL DEFAULT ''",
		'image_id' => "int(10) NOT NULL DEFAULT '0'",
		'photo_enabled' => "varchar(1) NOT NULL DEFAULT 'Y'",
		'vk_url' => "varchar(255) NOT NULL DEFAULT ''",
	);

	var $indexes = array(
		'PRIMARY KEY' => 'photo_id',
		'KEY site_id' => 'site_id',
		'KEY post_id' => 'post_id',
		'KEY common_filename' => 'common_filename',
		'KEY photo_enabled' => 'photo_enabled'
	);

	var $useSiteId = true;

	public function editPostIdByCommon($common, $postId)
	{
		$common = $this->db->escape($common);
		$postId = intval($postId);
		$this->db->query("UPDATE ".$this->table." SET post_id = '".$postId."' WHERE common_filename = '".$common."' AND post_id = 0".$this->getBySiteAndAccount());
	}

	public function updateUnassignedPostIdByImageId($imageId, $postId)
	{
		$imageId = intval($imageId);
		$postId = intval($postId);
		$this->db->query("UPDATE ".$this->table." SET post_id = '".$postId."' WHERE image_id = '".$imageId."' AND post_id = 0".$this->getBySiteAndAccount());

	}

	public function reportTable($enabled = '')
	{
		$cond = '';
		if (in_array($enabled, array('Y', 'N')))
		{
			$cond .= " AND photo_enabled = '".$enabled."'";
		}
		return $this->db->table("SELECT ".$this->table.".*, cody_post.post_id, cody_post.post_title FROM ".$this->table." LEFT JOIN cody_post USING(post_id) WHERE 1".$cond.$this->getBySiteAndAccount());
	}
}