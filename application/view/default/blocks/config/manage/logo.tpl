<h1><span class="section-icon icon-blocks"></span> {lng lng="site_logo"}</h1>


<form action="api.php" id="config_edit_form" method="POST">
<input type="hidden" name="action" value="config.manage.logo-edit" />
<input type="hidden" name="module_key" value="company" />


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
	<h2>{lng lng="site_logo"}</h2>
	<div class="field w50">
		<table class="no-header w100" cellspacing="0">
			<col width="20" class="logo-exists">
			<tbody>

				<tr class="first">
					<td>
						<div class="image-selector logo-exists {if not $logo} hidden{/if}" style="width:100%">
							<div class="image">
								<img src="{img img=$logo.logo_filename type="logo"}" alt="" id="logo-image" />
							</div>
						</div>
						<div align="center" class="logo-not-exists{if $logo} hidden{/if}">{lng lng="no_image_available"}</div>
					</td>
				</tr>

				<tr class="button-bar">
					<td>
						<table cellspacing="0" cellpadding="0" width="100%" class="no-border">
						<tr>
							<td colspan="2">
								<label class="sub" for="logo-alt">ALT:</label>
								<input type="text" class="medium-text" id="logo-alt" name="logo_alt" value="{$logo.logo_alt|htmlall}" maxlength="100" onkeyup="" onchange="" />
							</td>
						</tr>
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
			existsTarget: '.logo-exists',
			notExistsTarget: '.logo-not-exists',
			imageTarget: '#logo-image'
		},
		post_params: {
			action: 'config.manage.logo-upload',
			sssid: '{/literal}{$smarty.cookies.PHPSESSID}{literal}'
		},
		button_placeholder_id: "spanUploadImgMainBtn",
		upload_success_handler: swfuUploadHandlerDef
	};

	var swfuMain = new SWFUpload($.extend(swfuSettings, swfuSettingsDef));

});

</script>
{/literal}
