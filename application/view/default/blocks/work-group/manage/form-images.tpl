<fieldset>
	<h2>{lng lng="image"}</h2>
	<div class="field">
		<table class="no-header w100" cellspacing="0">
			<col width="20" class="image-exists">
			<tbody>

				<tr class="first">
					<td>
						<div class="image-selector image-exists {if not $image} hidden{/if}" style="width:100%">
							<div class="image">
								<a href="{img img=$image.work_group_image_filename type="work_group_image"}" target="_blank">
								<img src="{img img=$image.work_group_image_filename type="work_group_image"}" alt="" id="image" width="155" />
								</a>
							</div>
						</div>
						<div align="center" class="image-not-exists{if $image} hidden{/if}">{lng lng="no_image_available"}</div>
					</td>
				</tr>

				<tr class="button-bar">
					<td>
						<table cellspacing="0" cellpadding="0" width="100%" class="no-border">

							<tr>
								<td align="left"><span id="spanUploadImgMainProgress"></span></td>
								<td align="right"><span id="spanUploadImgMainBtn"></span></td>
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

$(document).ready(function(){

	{/literal}{include file="skin/admin/swf-upload-js-def.tpl"}{literal}

	var swfuSettings = {
		custom_settings : {
			progressTarget: "#spanUploadImgMainProgress",
			existsTarget: '.image-exists',
			notExistsTarget: '.image-not-exists',
			imageTarget: '#image'
		},
		post_params: {
			action: 'work-group.manage.image-upload',
			sssid: '{/literal}{$smarty.cookies.PHPSESSID}{literal}'
		},
		button_placeholder_id: "spanUploadImgMainBtn",
		upload_success_handler: swfuUploadHandlerDef
	};

	var swfuMain = new SWFUpload($.extend(swfuSettings, swfuSettingsDef));

});

</script>
{/literal}
