<h1><span class="section-icon icon-address"></span> {lng lng="company_address"}</h1>

<form action="api.php" id="config_edit_form" method="POST">
<input type="hidden" name="action" value="config.manage.update" />
<input type="hidden" name="module_key" value="company" />

{include file="skin/admin/page-operations-save-cancel.tpl"}

<div class="left-wide-column">

	<fieldset>
		<h2>{lng lng="common_data"}</h2>

		{include file="skin/admin/form-line-input.tpl" name="address_country" value=$config.company.address_country title="country"|lng class="w100" width="long-text"}
		{include file="skin/admin/form-line-input.tpl" name="address_state" value=$config.company.address_state title="state"|lng class="w100" width="long-text"}
		{include file="skin/admin/form-line-input.tpl" name="address_city" value=$config.company.address_city title="city"|lng class="w100" width="long-text"}
		{include file="skin/admin/form-line-input.tpl" name="address_street" value=$config.company.address_street title="street"|lng class="w100" width="long-text"}
		{include file="skin/admin/form-line-input.tpl" name="address_zip" value=$config.company.address_zip title="zipcode"|lng class="w100" width="short-text"}
		{include file="skin/admin/form-line-input.tpl" name="address_phone" value=$config.company.address_phone title="phone"|lng class="w100" width="long-text"}
		{include file="skin/admin/form-line-input.tpl" name="address_email" value=$config.company.address_email title="E-mail" class="w100" width="long-text"}

	</fieldset>
</div>

</form>
