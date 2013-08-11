{include file="skin/content-header.tpl" title="wizard_install"|lng}

{if $need_registration}
	{module action="user.register"}
{else}

{include file="skin/form-head.tpl" class="wizard"}
	<fieldset>
	<input type="hidden" name="action" value="wizard.install" />

	{include file="skin/form-line-input.tpl" title="domain"|lng name="domain" type="input" id="domain" value=$wizard_data.domain}

	{module action="wizard.build" checked=$wizard_data.build}
	{include file="skin/form-line-select.tpl" title="load_test_data"|lng list=$yes_no_select name="load_data" value=$wizard_data.load_data}

	{module action="wizard.template" checked=$wizard_data.template}

	{include file="skin/button.tpl" title="create"|lng}
	</fieldset>
{include file="skin/form-bottom.tpl"}

{/if}