<tr class="access-add" id="add">
        <td>
            <ul class="operation-toolbar">
                <li><a href="javascript:void(0);" class="icon-add"  sid="add" title="{lng lng="apply"}"></a></li>
            </ul>
        </td>
<td>
    <input name="module_key" type="text" value="" />
</td>
<td>
	<select name="access_group_id">
	{foreach from=$access_group_filter item=ag}
	{if $ag.value ne "*"}
		<option value="{$ag.value}">{$ag.caption}</option>
	{/if}
	{/foreach}
	</select>
</td>
<td>
    <input name="access_title" type="text" value="" />
</td>
<td>
	{include file="skin/admin/splitter-input.tpl" name="access_enabled" class="splitter-access-status" value="" items=$access_statuses}
</td>
    </tr>