<fieldset class="operations">
	<h2>{lng lng="faq_groups"}</h2>
	{if $group_statuses}
		{include file="skin/admin/filter-input.tpl" name="faq_group_id" id="faq_group_id" items=$group_statuses value=$group_value}
	{else}
		<ul><li>
		<a href="{link action="faq-group.manage.add"}">{lng lng="there_are_no_available"} - {lng lng="add"}</a>
		</li></ul>
	{/if}
</fieldset>