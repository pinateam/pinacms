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


/*
	require_once PATH_TABLES.'attachment.php';
	$productId = $request->param('product_id');
	
	$attachmentGateway = new AttachmentGateway();
	
	$attachments = $attachmentGateway->getAttachments(
		'cody_product',
		$productId
	);
	
	if (is_array($attachments))
	{
		foreach ($attachments as $k => $attachment)
		{
			if (is_file(PATH_ATTACHMENTS.$attachment['attachment_filename']))
			{
				$attachments[$k]['attachment_filesize'] =
					round($attachment['attachment_filesize'] / 1024, 2);
			}
			else
			{
				unset($attachments[$k]);
			}
		}
	}
	
	$request->result('attachments', $attachments);
	$request->ok();
 */