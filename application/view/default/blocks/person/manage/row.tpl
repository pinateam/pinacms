<li class="w10">
	<ul class="operation-toolbar">
		<li><a href="#" class="icon-edit"   sid="{$person.person_id}" title="{lng lng="edit"}"></a></li>
		<li><a href="#" class="icon-delete" sid="{$person.person_id}" title="{lng lng="delete"}"></a></li>
	</ul>
	
</li>
<li class="w40">
	<a href="{link action="person.manage.edit" person_id=$person.person_id}">{$person.person_title|truncate:60}</a>
</li>
<li class="w30">
        <a href="{link action="person.manage.edit" person_id=$person.person_id}">{$person.person_position|truncate:60}</a>
</li>
<li class="w20">
	{include file="skin/admin/splitter.tpl" name="person_enabled" class="person-enabled" sid=$person.person_id value=$person.person_enabled items=$person_statuses}
</li>
