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




if ($request->param("subject"))
{
	$subject = $request->param("subject");
	$subject_key = $subject."_id";
	$subject_id = $request->param($subject_key);

	$as = false;
	if (strpos("subject", ".") === false && file_exists(PATH_TABLES.$subject."_attachment.php"))
	{
		require_once PATH_TABLES.$subject."_attachment.php";
		$gatewayClass = getGatewayClassName($subject, "AttachmentGateway");
		$gateway = new $gatewayClass;

		require_once PATH_TABLES."attachment.php";
		$attachmentGateway = new AttachmentGateway();
		$as = $attachmentGateway->findByRelationId($gateway, $subject_key, $request->param($subject_key));
		
		require_once PATH_DOMAIN."attachment.php";
		foreach ($as as $k => $a)
		{
		    $as[$k]["attachment_url"] = AttachmentDomain::getFileUrl($a["attachment_filename"]);
		}
	}

	$request->result("attachments", $as);
}

$uploadMaxFilesize = trim(ini_get('upload_max_filesize'));
$last = strtolower($uploadMaxFilesize[strlen($uploadMaxFilesize) - 1]);

switch ($last) {
case 'g':
	$uploadMaxFilesize *= 1024;
case 'm':
	$uploadMaxFilesize *= 1024;
case 'k':
	$uploadMaxFilesize *= 1024;
}

$request->result('swfuploadMaxFilesize', $uploadMaxFilesize.' B');
$request->ok();