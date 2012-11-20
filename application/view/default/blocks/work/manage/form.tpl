
<div class="left-wide-column">
	<fieldset>
		<h2>{lng lng="common_settings"}</h2>
		{module action="work-group.manage.selector" value=$work.work_group_id}

		<div class="field w50">
			<label for="contractor_enabled">{lng lng="status"}</label>
			{include file="skin/admin/splitter-input.tpl" name="work_enabled"  value=$work.work_enabled|default:'Y' items=$work_statuses}
		</div>

		{include file="skin/admin/form-line-input.tpl" name="work_title"   value=$work.work_title  title="title_works"|lng class="w100"}
		<div class="field">
			<label for="description">{lng lng="description"} </label>
			<textarea   name="work_description" class="html-text" rows="10" cols="50">{$work.work_description}</textarea>	
		</div>
	</fieldset>
</div>