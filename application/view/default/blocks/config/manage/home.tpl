<div id="settings">

	<fieldset>
		<h2>{lng lng="general_settings"}</h2>

		<div class="field  help-section w50">
			<h3><a href="{link action="config.manage.modules"}">{lng lng="modules_management"}</a></h3>
			<a class="section-icon icon-blocks" href="{link action="config.manage.modules"}"></a>
			<div>
				{lng lng="modules_management_explanation"}
			</div>
		</div>

		{block view="string.manage.config-home"}

		{block view="config.manage.seo-config-home"}
	</fieldset>


	<fieldset>
		<h2>{lng lng="catalog"}</h2>

		{block view="product-type.manage.config-home"}
		{block view="category.manage.config-home"}

	</fieldset>

	<fieldset>
		<h2>{lng lng="shipping"}</h2>

		{block view="shipping.manage.config-home"}

		{block view="shipping-zone-cost.manage.config-home" nowrapper=1}

		{block view="zone.manage.config-home" nowrapper=1}
	</fieldset>

	{module action="payment.manage.config-home"}

	<fieldset>
		<h2>{lng lng="appearance"}</h2>

		{block view="config.manage.logo-config-home"}
		{block view="config.manage.image-config-home"}
	</fieldset>

	<fieldset>
		<h2>{lng lng="modules_settings"}</h2>

		{foreach from=$modules item=m}
			{block view=$m.module_config_block config_action=$m.module_config_action nowrapper=1}
		{/foreach}
	</fieldset>


	{block view="system.manage.config-home"}

</div>

{literal}
<script language="JavaScript">

	$("#settings").find("fieldset").each(function(){
		if (!$(this).find("div").html())
		{
			$(this).hide();
		}
	});

</script>
{/literal}