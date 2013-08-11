<h1><span class="section-icon icon-blocks"></span> {lng lng="date_time_format"}</h1>

<form action="api.php" id="config_edit_form" method="POST">
<input type="hidden" name="action" value="config.manage.update" />
<input type="hidden" name="module_key" value="appearance" />

{include file="skin/admin/page-operations-save-cancel.tpl"}

<div class="left-wide-column">
	<fieldset>
	<h2>{lng lng="common_settings"}</h2>

	<div class="field">
		<label for="date_format">{lng lng="date_format"}</label>
		{include file="skin/admin/splitter-input.tpl" name="date_format" items=$date_format_selector value=$config.appearance.date_format}
	</div>
	
	<div class="field">
		<label for="time_format">{lng lng="time_format"}</label>
		{include file="skin/admin/splitter-input.tpl" name="time_format" items=$time_format_selector value=$config.appearance.time_format}
	</div>

	{*include file="skin/admin/form-line-splitter.tpl" name="date_format" value=$config.appearance.date_format title="date_format"|lng class="w100" width="long-text" values=$date_format_selector*}
	{*include file="skin/admin/form-line-select.tpl" name="date_format" value=$config.appearance.date_format title="date_format"|lng class="w100" width="long-text" it=$date_format_selector*}
	</fieldset>
</div>



</form>