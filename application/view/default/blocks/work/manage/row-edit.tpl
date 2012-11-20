<li class="w10">
	<ul class="operation-toolbar">
		<li><a href="#" class="icon-accept" sid="{$work.work_id}" title="{lng lng="save"}"></a></li>
		<li><a href="#" class="icon-decline" sid="{$work.work_id}" title="{lng lng="cancel"}"></a></li>
	</ul>
</li>
<li class="w70">
	<input type="text" name="work_title" value="{$work.work_title|htmlall}" />
</li>

<li class="w20">
	{include file="skin/admin/splitter.tpl" name="work_enabled" class="work-enabled" sid=$work.work_id value=$work.work_enabled items=$work_statuses}
</li>
