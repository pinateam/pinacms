<li class="w10">
	<ul class="operation-toolbar">
		<li><a href="#" class="icon-edit"   sid="{$work.work_id}" title="{lng lng="edit"}"></a></li>
		<li><a href="#" class="icon-delete" sid="{$work.work_id}" title="{lng lng="delete"}"></a></li>
	</ul>
</li>
<li class="w70 editable">
	<a href="{link action="work.manage.edit" work_id=$work.work_id}">{$work.work_title}</a>
</li>

<li class="w20">
	{include file="skin/admin/splitter.tpl" name="work_enabled" class="work-enabled" sid=$work.work_id value=$work.work_enabled items=$work_statuses}
</li>
