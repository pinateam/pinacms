<fieldset>
	<h2>{lng lng="common_settings"}</h2>

        <div class="field">
            <label for="coding">{lng lng="status"}</label>
            {module action="blog.manage.status" enabled=$blog.blog_enabled}
        </div>

	{include file="skin/admin/form-line-input.tpl" name="blog_title" title="title"|lng help="" width="" value=$blog.blog_title}

	{include file="skin/admin/form-line-textarea.tpl"
		 name="blog_description" value=$blog.blog_description title="description"|lng
		 width="html-text" rows="20" help="description_explanation"|lng}
</fieldset>