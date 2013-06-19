
{module action="image.manage.field" width="w50" image_id=$photo.image_id}

<div class="field w50">
	<label for="photo_enabled">{lng lng="status"}</label>
	{include file="skin/admin/splitter-input.tpl" name="photo_enabled" class="glow photo-enabled w100"  value='Y' items=$photo_statuses}

	{include file="skin/admin/form-line-input.tpl" name="vk_url" value=$photo.vk_url title='VK' class="w100"}
</div>
