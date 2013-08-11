<h1><span class="section-icon icon-book"></span>{lng lng="post_addition"}</h1>
<form action="api.php" method="POST" name="post_add_form" id="post_add_form">
	<input type="hidden" name="action" value="post.manage.add" />
	
	<div class="right-narrow-column">
		<fieldset class="operations">
			<h2>{lng lng="actions"}</h2>
			<div class="button-bar">
				<button class="css3 button-edit">{lng lng="create"}</button>
				<button class="css3 additional button-cancel">{lng lng="cancel"}</button>
			</div>
		</fieldset>

		{module action="attachment.manage.form" subject="post" post_id=$post.post_id}
	</div>

	<div class="left-wide-column">
		{block view="post.manage.form-common"}
		{module action="menu.manage.form-menu" url_action="post.view" url_params="post_id="}
		{module action="meta.manage.form-meta" url_action="post.view" url_params="post_id="}
	</div>

</form>

{literal}
<script type="text/javascript">

$(document).ready(function(){
	$('#post_add_form').managePage({
		object: "post",
	});
});


</script>
{/literal}