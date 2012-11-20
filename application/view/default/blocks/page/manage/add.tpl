<h1><span class="section-icon icon-book"></span>{lng lng="static_page_addition"}</h1>
<div id="page_add">
    <form action="api.php" method="POST" name="page_add_form" id="page_add_form">
        <input type="hidden" name="action" value="page.manage.add" />
	<div class="right-narrow-column">

		<fieldset class="operations">
			<h2>{lng lng="actions"}</h2>
			<div class="button-bar">
				<button class="css3 button-add">{lng lng="add"}</button>
				<button class="css3 additional button-cancel">{lng lng="cancel"}</button>
			</div>
		</fieldset>
		<fieldset class="operations bottom">
			<h2>{lng lng="actions"}</h2>
			<div class="button-bar">
				<button class="css3 button-add">{lng lng="add"}</button>
				<button class="css3 additional button-cancel">{lng lng="cancel"}</button>
			</div>
		</fieldset>

	</div>

	<div class="left-wide-column">

		{block view="page.manage.form-common"}
		{module action="menu.manage.form-menu" url_action="page.view" url_params="page_id="}
                {module action="meta.manage.form-meta" url_action="page.view" url_params="page_id="}

	</div>

    </form>
</div>

{literal}
<script type="text/javascript">

$(document).ready(function(){
	$('#page_add_form').managePage({
		object: "page",
	});
});


</script>
{/literal}