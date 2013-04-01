{if $label}
<label for="{$name}">{$label}{if $required} *{/if}</label>
{/if}
<select name="{$name}" id="{$id}">
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