<h1><span class="section-icon icon-address"></span> Mailchimp</h1>

<form action="api.php" id="config_edit_form" method="POST">
<input type="hidden" name="action" value="config.manage.update" />
<input type="hidden" name="module_key" value="mailchimp" />

{include file="skin/admin/page-operations-save-cancel.tpl"}

<div class="left-wide-column">

	<fieldset>
		<h2>{lng lng="default_settings"}</h2>

		{include file="skin/admin/form-line-input.tpl" name="apikey" value=$config.mailchimp.apikey title="API KEY" class="w100" width="long-text"}
		{include file="skin/admin/form-line-input.tpl" name="listid" value=$config.mailchimp.listid title="List ID" class="w100" width="long-text"}

	</fieldset>

</div>

</form>
