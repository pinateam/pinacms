<h1><span class="section-icon icon-book"></span>{lng lng="post_editing"}</h1>
<form action="api.php" method="POST" name="post_edit_form" id="post_edit_form">
	<input type="hidden" name="action" value="post.manage.edit" />
	<input type="hidden" name="post_id" value="{$post.post_id}" />

	{include file="skin/admin/page-operations-save-cancel-delete.tpl" sid=$post.post_id}

	<div class="left-wide-column">
		{block view="post.manage.form-common"}
		{module action="menu.manage.form-menu" url_action="post.view" url_params="post_id="|cat:$post.post_id}
	</div>
</form>

{literal}
<script type="text/javascript">

$(document).ready(function(){
	$('#post_edit_form').managePage({
                api_delete: "post.manage.delete",
		object: "post",
	});
});

</script>
{/literal}