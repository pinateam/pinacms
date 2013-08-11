
<fieldset>
	<h2>{lng lng="attached_files"}</h2>
	<div class="field">
		<table class="no-header w100" cellspacing="0">
			<col width="20">
			<tbody>

				{foreach from=$attachments item=attachment name=attachments}
					{block view="attachment.manage.uploaded" attachmentId=$attachment.attachment_id isFirst=$smarty.foreach.attachments.first attachmentTitle=$attachment.attachment_title attachmentFilename=$attachment.attachment_filename attachmentFilesize=$attachment.attachment_filesize}
				{/foreach}

				<tr class="product-attachment-not-exists{if $attachments} hidden{/if}">
					<td colspan="2">
						<div align="center">{lng lng="list_is_empty"}</div>
					</td>
				</tr>
				<tr class="button-bar">
					<td colspan="2">
						<table cellspacing="0" cellpadding="0" width="100%" class="no-border">
						<tr>
							<td align="left"><span id="spanUploadAttachmentProgress"></span></td>
							<td align="right"><span id="spanUploadAttachmentBtn"></span></td>
						</tr>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</fieldset>

{literal}
<script type="text/javascript">

var attachmentTitleOld = [];
var attachmentTimeoutId = -1;

{/literal}
{foreach from=$attachments item=attachment}
	attachmentTitleOld[{$attachment.attachment_id}] = '{$attachment.attachment_title|replace:"'":"\'"}';
{/foreach}
{literal}

function productAttachmentDelete(attachment_id) {
	if (!confirm('{/literal}{lng lng="are_you_sure_to_delete"}{literal}')) {
		return;
	}

	$(".product-attachment-" + attachment_id).remove();
}

$(document).ready(function(){
	{/literal}{include file="skin/admin/swf-upload-js-def.tpl"}{literal}

	var swfuAttachment = new SWFUpload($.extend(swfuSettingsDef,{
		custom_settings : {
			progressTarget: "#spanUploadAttachmentProgress",
			existsTarget: '.product-attachment-exists',
			notExistsTarget: '.product-attachment-not-exists'
		},
		button_placeholder_id: "spanUploadAttachmentBtn",
		upload_success_handler: swfuUploadHandlerDef,
		post_params: {
			action: 'attachment.manage.upload',
			force_ajax: true,
			sssid: '{/literal}{$smarty.cookies.PHPSESSID}{literal}'
		},

		file_types: "*",

		upload_complete_handler: function(file){
			var stats = this.getStats();

			if (stats.files_queued == 0) {
				this.setButtonDisabled(false);
				alert('{/literal}{lng lng="files_uploading_has_been_completed"}{literal}');
			}
		},

		upload_success_handler: function(file, serverData){
			result = $.parseJSON(serverData);
			    
			if (result.e) {
				$(this.customSettings.progressTarget).text('');
				var errors = []
				for (i = 0; i < result.e.length; i++)
				{
					errors.push(result.e[i].m);
				}

				if (errors.length > 0) {
					alert(errors.join('\n'));
				}
			} else {
				var attachment_id = result.d.attachment_id;
				
				$.ajax({
					url: 'block.php',
					type: 'post',
					dataType: 'html',
					data: {
						action: 'attachment.manage.uploaded',
						attachment_id: attachment_id
					},
					success: function(result) {
						$('.product-attachment-not-exists').before(result);
						$('.product-attachment-not-exists').addClass('hidden');
						$('#spanUploadAttachmentProgress').text('');
					}
				});
			}
			    
			var stats = this.getStats();
			stats.successful_uploads = 0;
			this.setStats(stats);
		}
	}));
});

</script>
{/literal}