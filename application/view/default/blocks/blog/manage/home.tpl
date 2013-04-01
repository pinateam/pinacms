<h1><span class="section-icon icon-book"></span>{lng lng="blog_management"}</h1>

<div class="right-narrow-column">
	<fieldset class="operations">
		<h2>{lng lng="actions"}</h2>
		<ul>
			<li><a href="{link action="blog.manage.add"}" class="add">{lng lng="add_blog"}</a></li>
		</ul>
	</fieldset>
</div>

<div class="left-wide-column">
	{module action="blog.manage.list" wrapper="blog-list"}
</div>

{literal}
<script type="text/javascript">

    $(".blog-list").manageTable({
	action_list: "blog.manage.list",
        action_view: "blog.manage.row",
        action_edit: "blog.manage.row-edit",
        api_delete: "blog.manage.delete",
        api_edit: "blog.manage.edit-row",
        object: "blog"
    });

</script>
{/literal}
