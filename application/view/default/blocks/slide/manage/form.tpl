

<div class="right-narrow-column">
	<fieldset class="operations">
		<h2>{lng lng="actions"}</h2>
		<div class="button-bar">
			<button class="css3 button-edit">{lng lng="save"}</button>
			<button class="css3 additional button-cancel">{lng lng="cancel"}</button>
		</div>
	</fieldset>
</div>

<div class="left-wide-column">

<fieldset>
	<h2>{lng lng="image"}</h2>
	<div class="field w50">
		<table class="no-header w100" cellspacing="0">
			<col width="20" class="slide-exists">
			<tbody>

				<tr class="first">
					<td>
						<div class="image-selector slide-exists {if not $slide} hidden{/if}" style="width:100%">
							<div class="image">
								<a href="{img img=$slide.slide_filename type="slide"}" target="_blank">
								<img src="{img img=$slide.slide_filename type="slide" width="300"}" alt="" id="slide-image" width="300" />
								</a>
							</div>
						</div>
						<div align="center" class="slide-not-exists{if $slide} hidden{/if}">{lng lng="no_image_available"}</div>
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

	<div class="field w50">
		<label for="slide_enabled">{lng lng="status"} <span class="icon-info" onclick="alert('This is help')"></span></label>
		{include file="skin/admin/splitter-input.tpl" name="slide_enabled" value=$slide.slide_enabled|default:'Y' items=$slide_statuses}
	</div>

	{include file="skin/admin/form-line-input.tpl" name="slide_alt" value=$slide.slide_alt title="ALT" width="long-text" class=w50"}

	{include file="skin/admin/form-line-input.tpl" name="slide_href" value=$slide.slide_href title="link"|lng width="long-text" class=w50"}

</fieldset>

</div>

{literal}
<script type="text/javascript">

$(".button-cancel").bind("click", function(){
	history.back();
	return false;
});

$(document).ready(function(){

	{/literal}{include file="skin/admin/swf-upload-js-def.tpl"}{literal}

	var swfuSettings = {
		custom_settings : {
			progressTarget: "#spanUploadImgMainProgress",
			existsTarget: '.slide-exists',
			notExistsTarget: '.slide-not-exists',
			imageTarget: '#slide-image'
		},
		post_params: {
			action: 'slide.manage.upload',
			sssid: '{/literal}{$smarty.cookies.PHPSESSID}{literal}'
		},
		button_placeholder_id: "spanUploadImgMainBtn",
		upload_success_handler: swfuUploadHandlerDef
	};

	var swfuMain = new SWFUpload($.extend(swfuSettings, swfuSettingsDef));

});

</script>
{/literal}
