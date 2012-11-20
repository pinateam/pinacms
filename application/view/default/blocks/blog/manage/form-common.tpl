<fieldset>
	<h2>{lng lng="common_settings"}</h2>

        <div class="field">
            <label for="coding">{lng lng="status"}</label>
            {module action="blog.manage.status" enabled=$blog.blog_enabled}
        </div>

	{include file="skin/admin/form-line-input.tpl" name="blog_title" title="title"|lng help="" width="" value=$blog.blog_title}
</fieldset>