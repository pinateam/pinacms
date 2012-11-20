<table  id="work_group_sort_ids" class="w100 work-dnd"  cellspacing="0">
	<col width="20">
	<col width="20">
	<col >
	<col width="40">
	<thead>
		{block view="work-group.manage.list-head"}
	</thead>
	<tbody>
		{foreach from=$workGroups item=workGroup}
			<tr class="work_group-{$workGroup.work_group_id}" id="{$workGroup.work_group_id}">
				{block view="work-group.manage.row"}
			</tr>
		{foreachelse}
			<tr>
				<td colspan="4"><center>{lng lng="list_is_empty"}</center></td>
			</tr>
		{/foreach}

		
	</tbody>
</table>

		



