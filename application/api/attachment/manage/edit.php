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



$subject = $request->param("subject");
$subject_key = $subject."_id";
$subject_id = $request->param($subject_key);


if (strpos("subject", ".") === false && file_exists(PATH_TABLES.$subject."_attachment.php"))
{
	require_once PATH_TABLES."attachment.php";
	$attachmentGateway = new AttachmentGateway();
    
	require_once PATH_TABLES.$subject."_attachment.php";
	$gatewayClass = getGatewayClassName($subject, "AttachmentGateway");
	$gateway = new $gatewayClass;
	$gateway->removeBy($subject_key, $subject_id);
	
	$attachmentIds = mineArray("attachment_id", $request->params());
	$attachmentTitles = mineArray("attachment_title", $request->params());

	if (!empty($attachmentIds) && is_array($attachmentIds))
	foreach ($attachmentIds as $k => $id)
	{
		$gateway->add(array(
			$subject_key => $subject_id,
			'attachment_id' => $id
		));

		$attachmentGateway->edit($id, array("attachment_title" => $attachmentTitles[$k]));
	}
	
}