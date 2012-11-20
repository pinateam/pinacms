<div class="field {$class}">
	<label for="{$id|default:$name}">{$title}{if $help} <span class="icon-info" onclick="alert('{$help}')"></span>{/if}</label>
	<input id="{$id|default:$name}" name="{$name}" type="text" class="{$width|default:"long-text"}" {if $maxlength}maxlength="{$maxlength}" {/if}value="{$value|htmlall}" />
</div>