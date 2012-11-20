<h1><span class="section-icon icon-book"></span>{lng lng="add_faq_group"}</h1>
<form action="api.php" method="post" id="add_faq-group">
	<input type="hidden" name="action" value="faq-group.manage.add" />

	<div class="right-narrow-column">

		<fieldset class="operations">
			<h2>{lng lng="actions"}</h2>
			<div class="button-bar">
				<button class="css3 button-add">{lng lng="add"}</button>
				<button class="css3 additional button-cancel">{lng lng="cancel"}</button>
			</div>
		</fieldset>

	</div>


	<div class="left-wide-column">
		{block view="faq-group.manage.form"}
		{module action="menu.manage.form-menu" url_action="faq-group.view" url_params="faq_group_id="}
		{module action="meta.manage.form-meta" url_action="faq-group.view" url_params="faq_group_id="}
	</div>


</form>

{literal}
<script type="text/javascript">

	$(document).ready(function(){
		$('#add_faq-group').managePage({
			object: "faq_group"
		});
	});

</script>
{/literal}