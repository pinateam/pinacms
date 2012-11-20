<div class="table dnd">
	{block view="person.manage.list-head"}

	<div class="tbody">
		{foreach from=$persons item=person}
			<ul class="tr person-{$person.person_id}" id="{$person.person_id}">
				{block view="person.manage.row"}
			</ul>
		{foreachelse}
			<ul class="tr no-dnd">
				<li class="w100"><center>{lng lng="list_is_empty"}</center></li>
			</ul>
		{/foreach}
	</div>
</div>


