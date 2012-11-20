<h1><span class="section-icon icon-blocks"></span> {lng lng="images_settings"}</h1>


<form action="api.php" id="config_edit_form" method="POST">
<input type="hidden" name="action" value="config.manage.update" />
<input type="hidden" name="module_key" value="image" />

{include file="skin/admin/page-operations-save-cancel.tpl"}

<div class="left-wide-column">
	{block view="editor.manage.config-image"}
	{block view="product.manage.config-image"}
	{block view="person.manage.config-image"}
</div>



</form>