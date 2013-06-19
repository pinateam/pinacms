<div class="field {$width|default:"w100"} {if $postfix}image-{$postfix}{else}image-main{/if}">
	{if $title}
		<label>
			{$title}
			{if $help}
				<span class="icon-info" onclick="alert('{$help}')"></span>
			{/if}
		</label>
	{/if}

	{if !$few}
		<input type="hidden" class="image-id" name="image_id{if $postfix}_{$postfix}{/if}" value="{$image.image_id}" />
	{/if}
	<table class="no-header w100 image" cellspacing="0">
		<col width="20">
		<tbody>
			<tr>
				<td colspan="2" class="image-not-exists{if $images || $image.image_filename} hidden{/if}">
					<div><center>{lng lng="no_image_available"}</center></div>
				</td>
			</tr>
			{if $images}
				{foreach from=$images item=image}
					{block view="image.manage.row" image=$image few=$few}
				{/foreach}
			{else}
				{if $image.image_id}
					{block view="image.manage.row" image=$image few=$few}
				{/if}
			{/if}
			<tr class="button-bar">
				<td colspan="2">
					<table cellspacing="0" cellpadding="0" width="100%" class="no-border">
					<tr>
						<td align="left"><span id="spanUploadProgress{if $postfix}_{$postfix}{/if}"></span></td>
						<td align="right"><span id="spanUploadBtn{if $postfix}_{$postfix}{/if}"></span></td>
					</tr>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</div>


{literal}
<script type="text/javascript">

$("{/literal}.{if $postfix}image-{$postfix}{else}image-main{/if}{literal} .image-exists a.icon-delete").live("click", function() {
	if (!confirm(PinaLng.lng("are_you_sure_to_delete"))) {
		return;
	}

	var id = $(this).attr("sid");
	if (!id)
	{
		alert("Please specify SID");
		return;
	}

	$(".image-" + id).remove();

	var base = '{/literal}.{if $postfix}image-{$postfix}{else}image-main{/if}{literal}';

	if (!$(base + " .image-row").is(".image-row"))
	{

		$(base + " .image-not-exists").removeClass("hidden");
		$(base + " .image-id").val(0);
	}
});

$(document).ready(function(){

	{/literal}{include file="skin/admin/swf-upload-js-def.tpl"}{literal}

	var swfuMain = new SWFUpload($.extend(swfuSettingsDef, {
		customSettings : {
			{/literal}
				{if $postfix}postfix: "{$postfix}",{/if}
				few: {if $few}true{else}false{/if},
			{literal}
			progressTarget: "#spanUploadProgress{/literal}{if $postfix}_{$postfix}{/if}{literal}"
		},
		button_placeholder_id: "spanUploadBtn{/literal}{if $postfix}_{$postfix}{/if}{literal}",
		upload_success_handler: swfuUploadHandlerDef
	}));
});
</script>
{/literal}