<h1><span class="section-icon icon-blocks"></span> {lng lng="counters_code"}</h1>

<form action="api.php" id="config_edit_form" method="POST">
<input type="hidden" name="action" value="config.manage.update" />
<input type="hidden" name="module_key" value="core" />

{include file="skin/admin/page-operations-save-cancel.tpl"}


<div class="left-wide-column">

	<fieldset>
		<h2>{lng lng="common_data"}</h2>

		{include file="skin/admin/form-line-textarea.tpl" name="counters" value=$config.core.counters title="counters_code"|lng class="w50" width="short-text" editor="no-html-editor" rows="12"}
	</fieldset>
</div>


</form>