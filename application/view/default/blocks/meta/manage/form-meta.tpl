<fieldset>
	<h2>{lng lng="meta_data"} <span class="icon-info" onclick="alert('{lng lng="meta_data_explanation"}.')"></span></h2>

	{include file="skin/admin/form-line-input.tpl"
		 name="meta_title" value=$meta.meta_title title="meta_title"|lng
		 help="meta_title_explanation"|lng
		 maxlength="200" width="long-text"}

	{include file="skin/admin/form-line-input.tpl"
		 name="meta_description" value=$meta.meta_description title="meta_description"|lng
		 help="meta_description_explanation"|lng
		 maxlength="200" width="long-text"}

	{include file="skin/admin/form-line-input.tpl"
		 name="meta_keys" value=$meta.meta_keys title="meta_keys"|lng
		 help="meta_keys_explanation"|lng
		 maxlength="200" width="long-text"}

	{include file="skin/admin/form-line-input.tpl"
		 name="meta_h1" value=$meta.meta_h1 title="meta_h1"|lng
		 help="meta_h1_explanation"|lng
		 maxlength="200" width="long-text"}

	{include file="skin/admin/form-line-input.tpl"
		 name="url_key" value=$meta.url_key title="url_key"|lng
		 help="url_key_explanation"|lng
		 maxlength="128" width="long-text"}
</fieldset>