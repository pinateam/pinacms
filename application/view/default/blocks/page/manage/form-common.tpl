<fieldset>
	<h2>{lng lng="common_settings"} <span onclick="alert('This is help')" class="icon-info"></span></h2>

        <div class="field">
            <label for="coding">{lng lng="status"}</label>
            {module action="page.manage.status" enabled=$page_data.post_enabled}
        </div>

	{include file="skin/admin/form-line-input.tpl"
		 name="page_title" value=$page_data.post_title title="title"|lng
		 width="long-text"}

	{include file="skin/admin/form-line-textarea.tpl"
		 name="page_text" value=$page_data.post_text title="description"|lng
		 width="html-text" rows="20" help="description_explanation"|lng}
</fieldset>