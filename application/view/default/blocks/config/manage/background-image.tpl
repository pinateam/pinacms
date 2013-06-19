<h1><span class="section-icon icon-colors"></span> {lng lng="site_background_image"}</h1>

<form action="api.php" id="config_edit_form" method="POST">
<input type="hidden" name="action" value="config.manage.update" />
<input type="hidden" name="module_key" value="background_image" />

<div class="right-narrow-column">
	<fieldset class="operations">
		<h2>{lng lng="actions"}</h2>
		<div class="button-bar">
			<button class="css3 button-add">{lng lng="save"}</button>
			<button class="css3 additional button-cancel">{lng lng="cancel"}</button>
		</div>
		<div class="button-bar-2">
			<button class="css3 delete button-reset" sid="{$sid}">{lng lng="set_default"}</button>
		</div>
	</fieldset>

	<fieldset class="operations bottom">
		<h2>{lng lng="actions"}</h2>
		<div class="button-bar">
			<button class="css3 button-add">{lng lng="save"}</button>
			<button class="css3 additional button-cancel">{lng lng="cancel"}</button>
		</div>
		<div class="button-bar-2">
			<button class="css3 delete button-reset" sid="{$sid}">{lng lng="set_default"}</button>
		</div>
	</fieldset>
</div>


<div class="left-wide-column">
	{block view="config.manage.background-image-select"}

	{module action="image.manage.fieldset" 
		title="or_upload_your_own_background"|lng
		image_id=$config.background_image.image_id
	}
</div>

{literal}
<script type="text/javascript">
	$(".image-alt").remove();


	$(".button-cancel").bind("click", function(){
		history.back();
		return false;
	});

	$(".button-reset").bind("click", function(){
		document.location = 'api.php?action=config.manage.set-background-image-default';
		return false;
	});
</script>
{/literal}
</form>