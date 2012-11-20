
	<div class="field w50">
			<label for="faq_group_id"><strong>{lng lng="faq_groups"}</strong>:</label>
			{if $group_statuses}
			<span>
				{include file="skin/admin/splitter-input.tpl" value=$group_value name="faq_group_id" items=$group_statuses}
			</span>
			{else}
				{lng lng="there_are_no_available"} - <a href="{link action="faq-group.manage.add"}">{lng lng="add"}</a>
			{/if}
	</div>
