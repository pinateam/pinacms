<fieldset>
	<h2>{lng lng="common_settings"}</h2>

	<div class="field w50">
		<label for="user_status">{lng lng="status"}</label>
		{include file="skin/admin/splitter-input.tpl" name="faq_group_enabled" value=$group.faq_group_enabled|default:"Y" items=$group_statuses}
	</div>

	{include file="skin/admin/form-line-input.tpl" name="faq_group_title" value=$group.faq_group_title|htmlall title="title"|lng}

</fieldset>