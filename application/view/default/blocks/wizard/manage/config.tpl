<h1><span class="section-icon icon-magic-wand"></span> {lng lng="site_creation_wizard_configuration"}</h1>

<form action="api.php" id="config_edit_form" method="POST">
<input type="hidden" name="action" value="config.manage.update" />
<input type="hidden" name="module_key" value="wizard" />

{include file="skin/admin/page-operations-save-cancel.tpl"}

<div class="left-wide-column">

	<fieldset>
		<h2>{lng lng="common_data"}</h2>

		{include file="skin/admin/form-line-input.tpl" name="root_test_domain" value=$config.wizard.root_test_domain title="root_test_domain"|lng class="w100" width="long-text"}
	</fieldset>
</div>

</form>