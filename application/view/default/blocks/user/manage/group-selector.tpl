<label for="membership-type">{lng lng="membership"}</label>
<select name="access_group_id" id="access_group_id">
	{foreach from=$access_group_selector item=ag}
		<option value="{$ag.value}" {if $value eq $ag.value}selected="selected"{/if}>{$ag.caption}</option>
	{/foreach}
	{module action="access.manage.group-admin-selector-items" value=$value}
</select>