<h1><span class="section-icon icon-address"></span> SEO</h1>

<form action="api.php" id="config_edit_form" method="POST">
<input type="hidden" name="action" value="config.manage.update" />
<input type="hidden" name="module_key" value="seo" />

{include file="skin/admin/page-operations-save-cancel.tpl"}

<div class="left-wide-column">

	<fieldset>
		<h2>{lng lng="default_settings"}</h2>

		{include file="skin/admin/form-line-input.tpl" name="meta_title" value=$config.seo.meta_title title="meta_title"|lng class="w100" width="long-text"}
		{include file="skin/admin/form-line-input.tpl" name="meta_keys" value=$config.seo.meta_keys title="meta_keys"|lng class="w100" width="long-text"}
		{include file="skin/admin/form-line-input.tpl" name="meta_description" value=$config.seo.meta_description title="meta_description"|lng class="w100" width="long-text"}

	</fieldset>

        <fieldset>
		<h2>{lng lng="hproduct_settings"}</h2>

		{include file="skin/admin/form-line-input.tpl" name="hproduct_brand" value=$config.seo.hproduct_brand title="brand"|lng class="w100" width="long-text"}

	</fieldset>
</div>

</form>
