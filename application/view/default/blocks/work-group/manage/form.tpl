<div class="left-wide-column">
	<fieldset>
		<h2>{lng lng="common_settings"}</h2>

		<div class="field w50">
			<label for="work_group_enabled">{lng lng="status"}</label>
			{include file="skin/admin/splitter-input.tpl" name="work_group_enabled" value=$work_group.work_group_enabled|default:'Y' items=$work_group_statuses}
		</div>

		{include file="skin/admin/form-line-input.tpl" name="work_group_title" value=$work_group.work_group_title  title="title_portfolio"|lng class="w100"}
	</fieldset>
	{module action="menu.manage.form-menu" url_action="work-group.view" url_params="work_group_id="|cat:$work_group.work_group_id}
	{module action="meta.manage.form-meta" url_action="work-group.view" url_params="work_group_id="|cat:$work_group.work_group_id}
</div>