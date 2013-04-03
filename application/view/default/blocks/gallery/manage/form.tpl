	

<div class="field w50">
	{include file="skin/admin/splitter-input.tpl" name="photo_enabled" class="glow photo-enabled w100"  value='Y' items=$photo_statuses}				
</div>



<div class="field w100">
	<table class="no-header w100" cellspacing="0">
		<col width="20" class="gallery-exists">
		<tbody>
			<tr class="first">
				<td>
					<div class="image-selector gallery-exists {if not $photo} hidden{/if}" style="width:100%">
						<div class="image">
							<a href="{img img=$photo.slide_filename type="slide"}" target="_blank">
							<img src="{img img=$photo.slide_filename type="slide" width="300"}" alt="" id="gallery-image" width="300" />
							</a>
						</div>
					</div>
					<div align="center" class="gallery-not-exists{if $photo} hidden{/if}">{lng lng="no_image_available"}</div>
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

{include file="skin/admin/form-line-input.tpl" name="vk_url" value=$photo.vk_url title='VK' class="w100"}





			
			
{literal}
<script type="text/javascript">

$(document).ready(function(){

	{/literal}{include file="skin/admin/swf-upload-js-def.tpl"}{literal}

	var swfuSettings = {
		custom_settings : {
			progressTarget: "#spanUploadImgMainProgress",
			existsTarget: '.gallery-exists',
			notExistsTarget: '.gallery-not-exists',
			imageTarget: '#gallery-image'
		},
		post_params: {
			action: 'gallery.manage.upload',
			sssid: '{/literal}{$smarty.cookies.PHPSESSID}{literal}'
		},
		button_placeholder_id: "spanUploadImgMainBtn",
		upload_success_handler: swfuUploadHandlerDef
	};

	var swfuMain = new SWFUpload($.extend(swfuSettings, swfuSettingsDef));

});

</script>
{/literal}
