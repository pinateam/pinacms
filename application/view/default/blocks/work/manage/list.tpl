


<div class="table dnd">

	{block view="work.manage.list-head"}

	<div class="tbody">
		{foreach from=$works item=work}
			<ul class="tr work-{$work.work_id}" id="{$work.work_id}">
				{block view="work.manage.row"}
			</ul>
		{foreachelse}
			<ul class="tr no-dnd">
				<li class="w100"><center>{lng lng="list_is_empty"}</center></li>
			</ul>
		{/foreach}
	</div>
</div>

		



