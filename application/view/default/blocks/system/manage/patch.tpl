<h1><span class="section-icon icon-asterix"></span> SQL-patch</h1>

<form action="api.php" id="path_form" method="POST">
<input type="hidden" name="action" value="system.manage.patch" />


<div class="right-narrow-column">
	<fieldset class="operations">
		<h2>{lng lng="actions"}</h2>
		<div class="button-bar">
			<button class="css3 button-edit">{lng lng="save"}</button>
			<button class="css3 additional button-cancel">{lng lng="cancel"}</button>
		</div>
	</fieldset>
</div>

<fieldset>
<textarea name="path" cols="120" rows="30" class="no-html-editor"></textarea>
</fieldset>

</form>

{literal}
<script type="text/javascript">

$(".button-cancel").bind("click", function(){
	history.back();
	return false;
});

</script>
{/literal}
