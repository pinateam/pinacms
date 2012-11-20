{foreach from=$access_group_selector item=ag}
	<option value="{$ag.value}" {if $value eq $ag.value}selected="selected"{/if}>{$ag.caption}</option>
{/foreach}