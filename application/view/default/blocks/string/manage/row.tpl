
<td>
	{if $string.string_value}
	<ul class="operation-toolbar">
		<li><a href="#" class="icon-delete" sid="{$string.string_key}" data-message="{lng lng="are_you_sure_to_delete_language_variable"}" title="{lng lng="delete"}"></a></li>
	</ul>
	{/if}
</td>
<td>
	<strong>{$string.string_key}</strong>
</td>
<td>
	{$string.string_value_base}
</td>

<td class="edit-few">
	<input type="text" name="string_{$string.string_key}" value="{$string.string_value}">
</td>
