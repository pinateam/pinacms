<li class="w10">
	<ul class="operation-toolbar">
		<li><a href="#" class="icon-accept" sid="{$person.person_id}" title="{lng lng="save"}"></a></li>
		<li><a href="#" class="icon-decline" sid="{$person.person_id}" title="{lng lng="cancel"}"></a></li>
	</ul>
</td>
<li class="w40">
	<input type="text" name="person_title" value="{$person.person_title|htmlall}" />
</li>
<li class="w30">
	<input type="text" name="person_position" value="{$person.person_position|htmlall}" />
</li>
<li class="w20">
	{include file="skin/admin/splitter.tpl" name="person_enabled" class="person-enabled" sid=$person.person_id value=$person.person_enabled items=$person_statuses}
</li>