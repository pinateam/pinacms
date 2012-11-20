<h1><span class="section-icon icon-asterix"></span>{lng lng="blog_editing"}</h1>
<form action="api.php" method="POST" name="blog_edit_form" id="blog_edit_form">
	<input type="hidden" name="action" value="blog.manage.edit" />
	<input type="hidden" name="blog_id" value="{$blog.blog_id}" />

	{include file="skin/admin/page-operations-save-cancel-delete.tpl" sid=$blog.blog_id}

	<div class="left-wide-column">
		{block view="blog.manage.form-common"}
		{module action="menu.manage.form-menu" url_action="blog.view" url_params="blog_id="|cat:$blog.blog_id}
		{module action="meta.manage.form-meta" url_action="blog.view" url_params="blog_id="|cat:$blog.blog_id}
	</div>
</form>

{literal}
<script type="text/javascript">

$(document).ready(function(){
	$('#blog_edit_form').managePage({
                api_delete: "blog.manage.delete",
		object: "blog",
	});
});

</script>
{/literal}
