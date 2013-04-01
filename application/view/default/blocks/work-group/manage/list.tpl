<div class="table dnd">
	<ul class="thead">
		{block view="work-group.manage.list-head"}
	</ul>
	<div class="tbody">
		{foreach from=$workGroups item=workGroup}
			<ul class="tr work_group-{$workGroup.work_group_id}" id="{$workGroup.work_group_id}">
				{block view="work-group.manage.row"}
			</ul>
		{foreachelse}
			<ul class="tr no-dnd">
				<li class="w100"><center>{lng lng="list_is_empty"}</center></li>
			</ul>
		{/foreach}
	</div>
</div>

		



