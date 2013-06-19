<div class="field {$class}">
	<label for="{$id|default:$name}">{$title}{if $help} <span class="icon-info" onclick="alert('{$help}')"></span>{/if}</label>
	<select name="{$name}" id="{$id|default:$name}" class="{$width|default:"long-text"}">
	{if $any == 'true'}
	<option {if $value == 0}selected{/if} value="0">{lng lng="filter_all"}</option>
	{/if}
	{foreach from=$list item=item key=key}
	    {if $key == $value || $key == $fill.$name}
		<option selected="selected" value="{$key}">{$item}</option>
	    {else}
		<option value="{$key}">{$item}</option>
	    {/if}
	{/foreach}
	</select>
</div>