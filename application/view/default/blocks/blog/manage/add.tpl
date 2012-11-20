<h1><span class="section-icon icon-asterix"></span>{lng lng="blog_addition"}</h1>
<form action="api.php" method="POST" name="blog_add_form" id="blog_add_form">
	<input type="hidden" name="action" value="blog.manage.add" />

	{include file="skin/admin/page-operations-create-cancel.tpl"}

	<div class="left-wide-column">
		{block view="blog.manage.form-common"}
		{module action="menu.manage.form-menu" url_action="blog.view" url_params="blog_id="}
		{module action="meta.manage.form-meta" url_action="blog.view" url_params="blog_id="}
	</div>
</form>

{literal}
<script type="text/javascript">

$(document).ready(function(){
	$('#blog_add_form').managePage({
		object: "page",
	});
});

</script>
{/literal}