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

	var $fields = array
	(
		"photo_id", "site_id", "post_id",
		"common_filename",
		"photo_filename", "photo_width",
		"photo_height", "photo_type",
		"photo_size", "photo_enabled",
		"vk_url"
	);

	var $useSiteId = true;

	public function editPostIdByCommon($common, $postId)
	{
		$common = $this->db->escape($common);
		$postId = intval($postId);
		$siteId = intval($this->siteId);
		$this->db->query("UPDATE ".$this->table." SET post_id = '".$postId."' WHERE common_filename = '".$common."' AND post_id = 0 AND site_id = '".$siteId."'");
	}

	public function reportTable()
	{
		$siteId = intval($this->siteId);
		return $this->db->table("SELECT * FROM ".$this->table." ph LEFT JOIN cody_post po USING(post_id) WHERE ph.site_id = '".$siteId."'");
	}
}