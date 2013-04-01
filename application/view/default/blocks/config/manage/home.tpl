<div id="settings">

	<fieldset>
		<h2>{lng lng="general_settings"}</h2>

		<div class="field  help-section w50">
			<h3><a href="{link action="module.manage.home"}">{lng lng="modules_management"}</a></h3>
			<a class="section-icon icon-blocks" href="{link action="module.manage.home"}"></a>
			<div>
				{lng lng="modules_management_explanation"}
			</div>
		</div>

		{block view="string.manage.config-home"}

		{block view="config.manage.seo-config-home"}

		{foreach from=$modules item=m}
			{if $m.module_group eq "common"}
				{block view=$m.module_config_block config_action=$m.module_config_action nowrapper=1}
			{/if}
		{/foreach}
	</fieldset>

	<fieldset>
		<h2>{lng lng="content"}</h2>

		{foreach from=$modules item=m}
			{if $m.module_group eq "content"}
				{block view=$m.module_config_block config_action=$m.module_config_action nowrapper=1}
			{/if}
		{/foreach}
	</fieldset>

	<fieldset>
		<h2>{lng lng="orders"}</h2>

		{foreach from=$modules item=m}
			{if $m.module_group eq "order"}
				{block view=$m.module_config_block config_action=$m.module_config_action nowrapper=1}
			{/if}
		{/foreach}
	</fieldset>


	<fieldset>
		<h2>{lng lng="catalog"}</h2>

		{foreach from=$modules item=m}
			{if $m.module_group eq "catalog"}
				{block view=$m.module_config_block config_action=$m.module_config_action nowrapper=1}
			{/if}
		{/foreach}
	</fieldset>

	<fieldset>
		<h2>{lng lng="shipping"}</h2>

		{foreach from=$modules item=m}
			{if $m.module_group eq "shipping"}
				{block view=$m.module_config_block config_action=$m.module_config_action nowrapper=1}
			{/if}
		{/foreach}
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
			{if $m.module_group eq ""}
				{block view=$m.module_config_block config_action=$m.module_config_action nowrapper=1}
			{/if}
		{/foreach}
	</fieldset>


	{block view="directory.manage.config-home"}
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