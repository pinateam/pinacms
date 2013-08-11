<h1><span class="section-icon icon-shopping-cart"></span> Google Analytics</h1>

<form action="api.php" id="config_edit_form" method="POST">
<input type="hidden" name="action" value="config.manage.update" />
<input type="hidden" name="module_key" value="google_analytics" />

{include file="skin/admin/page-operations-save-cancel.tpl"}

<div class="left-wide-column">

	<fieldset>
		<h2>{lng lng="common_data"}</h2>

		{include file="skin/admin/form-line-input.tpl" name="account_number" value=$config.google_analytics.account_number title="Account number" class="w100" width="long-text"}
		
		<div class="field w100">
			<label for="use_ecommerce">Use E-Commerce analysis</label>
			{include file="skin/admin/splitter-input.tpl" name="use_ecommerce" value=$config.google_analytics.use_ecommerce|default:"N" items=$use_ecommerce_values}
		</div>

	</fieldset>
</div>

</form>