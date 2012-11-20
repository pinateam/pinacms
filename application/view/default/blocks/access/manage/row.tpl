<td>
	<ul class="operation-toolbar">
		<li><a href="javascript:void(0);" class="icon-delete"  sid="{$access.access_id}" title="{lng lng="delete"}"></a></li>
	</ul>

</td>
<td>
	{$access.module_key}
</td>
<td>
	{assign var="ag_id" value=$access.access_group_id}
	{$groups.$ag_id}
</td>
<td>
	{$access.access_title}
</td>
<td>
	{include file="skin/admin/splitter.tpl" name="access_enabled" class="splitter-access-status" sid=$access.access_id value=$access.access_enabled items=$access_statuses}
</td>