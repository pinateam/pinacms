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



require_once PATH_TABLES."photo.php";

function smarty_modifier_format_photos($descr, $postId)
{
	preg_match_all("/<img[^>]+\/common\/([^'\"]*)[^>]*>/i", $descr, $images);
	if (empty($images[1])) return $descr;

	$photoGateway = new PhotoGateway();
	$photos = $photoGateway->findBy("post_id", $postId);

	if (empty($photos)) return $descr;

	$rels = array();
	foreach ($photos as $k => $v)
	{
		$rels[$v["common_filename"]] = $v["photo_filename"];
	}

	foreach ($images[1] as $k => $image)
	{
		if (isset($rels[$image]))
		{
			$descr = str_replace($images[0][$k], '<a href="'.SITE_IMAGES.Site::id()."/photo/".$images[1][$k].'" target="_blank">'.$images[0][$k]."</a>", $descr);
			unset($rels[$image]);
		}
	}
	return $descr;

}