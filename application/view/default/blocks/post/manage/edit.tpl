<h1><span class="section-icon icon-book"></span>{lng lng="post_editing"}</h1>
<form action="api.php" method="POST" name="post_edit_form" id="post_edit_form">
	<input type="hidden" name="action" value="post.manage.edit" />
	<input type="hidden" name="post_id" value="{$post.post_id}" />

	<div class="right-narrow-column">
		<fieldset class="operations">
			<h2>{lng lng="actions"}</h2>
			<div class="button-bar">
				<button class="css3 button-edit">{lng lng="save"}</button>
				<button class="css3 additional button-cancel">{lng lng="cancel"}</button>
			</div>
			<div class="button-bar-2">
				<button class="css3 delete button-delete" sid="{$post.post_id}">{lng lng="delete"}</button>
			</div>
		</fieldset>

		{module action="attachment.manage.form" subject="post" post_id=$post.post_id}
	</div>

	<div class="left-wide-column">
		{block view="post.manage.form-common"}
		{module action="menu.manage.form-menu" url_action="post.view" url_params="post_id="|cat:$post.post_id}
		{module action="meta.manage.form-meta" url_action="post.view" url_params="post_id="|cat:$post.post_id}
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