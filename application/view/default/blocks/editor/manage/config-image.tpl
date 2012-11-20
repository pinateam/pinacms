<fieldset>
	<h2>{lng lng="html_editor_settings"}</h2>

	{include file="skin/admin/form-line-input.tpl" name="editor_max_width" value=$config.image.editor_max_width title="uploaded_image_max_width"|lng class="w50" width="short-text"}
	{include file="skin/admin/form-line-input.tpl" name="editor_max_height" value=$config.image.editor_max_height title="uploaded_image_max_height"|lng class="w50" width="short-text"}

</fieldset>