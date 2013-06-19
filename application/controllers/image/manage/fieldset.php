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



$request->result("width", $request->param("width"));
$request->result("postfix", $request->param("postfix"));

if ($request->param("image_id"))
{
	require_once PATH_TABLES."image.php";
	$imageGateway = new ImageGateway();
	$image = $imageGateway->get($request->param("image_id"));

	$request->result("image", $image);

	$request->result("width", $request->param("width"));
	$request->result("hide_alt", $request->param("hide_alt"));

	$request->result("few", false);
}
elseif ($request->param("subject"))
{
	$subject = $request->param("subject");
	$subject_key = $subject."_id";
	$subject_id = $request->param($subject_key);

	$images = false;
	if (strpos("subject", ".") === false && file_exists(PATH_TABLES.$subject."_image.php"))
	{
		require_once PATH_TABLES.$subject."_image.php";
		$gatewayClass = getGatewayClassName($subject, "ImageGateway");
		$gateway = new $gatewayClass;

		require_once PATH_TABLES."image.php";
		$imageGateway = new ImageGateway();
		$images = $imageGateway->findByRelationId($gateway, $subject_key, $request->param($subject_key));
	}

	$request->result("images", $images);
	$request->result("few", true);
}

$request->result("title", $request->param("title")?$request->param("title"):lng("image"));
$request->ok();