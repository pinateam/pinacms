<h1><span class="section-icon icon-colors"></span> {lng lng="site_logo"}</h1>


<form action="api.php" id="config_edit_form" method="POST">
<input type="hidden" name="action" value="config.manage.logo-edit" />
<input type="hidden" name="module_key" value="company" />


<div class="right-narrow-column">
	<fieldset class="operations">
		<h2>{lng lng="actions"}</h2>
		<div class="button-bar">
			<button class="css3 button-edit">{lng lng="save"}</button>
			<button class="css3 additional button-cancel">{lng lng="cancel"}</button>
		</div>
	</fieldset>
</div>

<div class="left-wide-column">

{module action="image.manage.fieldset" title="site_logo"|lng image_id=$logo.image_id}

</div>

{literal}
<script type="text/javascript">

$(".button-cancel").bind("click", function(){
	history.back();
	return false;
});

</script>
{/literal}
