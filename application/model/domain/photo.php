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



class PhotoDomain
{
	static public function updatePhotosPostId($text, $postId)
	{
		preg_match_all('/(<img[^<>]+src[ ]*=[ ]*["\'])([^"\']*images\/)([^&^"^\']*)(["\'])/iUS', $text, $matches);

		if (empty($matches) || empty($matches[3])) return;

		require_once PATH_TABLES.'photo.php';

		$photoGateway = new PhotoGateway();

		if (is_array($matches[3]))
		foreach ($matches[3] as $img)
		{
			if (strpos($img, '/common/') === false) continue;

			$pathinfo = pathinfo($img);
			$photoGateway->editPostIdByCommon($pathinfo['basename'], $postId);
		}
	}
}