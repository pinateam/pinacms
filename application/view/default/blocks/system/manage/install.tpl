<h1><span class="section-icon icon-asterix"></span> Modules installation</h1>

<form action="api.php" id="path_form" method="POST">
<input type="hidden" name="action" value="system.manage.install" />


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
	<fieldset>

<div class="field">
<label>{lng lng="modules"}</label>
<div>
{foreach from=$modules item=module}
{$module.module_key}
{/foreach}
</div>

<textarea name="modules" cols="120" rows="30" class="no-html-editor"></textarea>

</div>
</div>

</form>

{literal}
<script type="text/javascript">

$(".button-cancel").bind("click", function(){
	history.back();
	return false;
});

</script>
{/literal}
