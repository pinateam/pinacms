<td class="draggable">
	<ul class="operation-toolbar">
		<li><a href="#" class="icon-move" title="{lng lng="move"}"></a></li>
	</ul>
</td>
<td>
	<ul class="operation-toolbar">
		<li><a href="#" class="icon-edit"   sid="{$workGroup.work_group_id}" title="{lng lng="edit"}"></a></li>
		<li><a href="#" class="icon-delete" sid="{$workGroup.work_group_id}" title="{lng lng="delete"}"></a></li>
	</ul>
	
</td>
<td>
	<a href="{link action="work-group.manage.edit" work_group_id=$workGroup.work_group_id}">{$workGroup.work_group_title}</a>
</td>

<td>     
	{include file="skin/admin/splitter.tpl" name="work_group_enabled" class="work-group-enabled" sid=$workGroup.work_group_id value=$workGroup.work_group_enabled items=$work_group_statuses}
</td>
