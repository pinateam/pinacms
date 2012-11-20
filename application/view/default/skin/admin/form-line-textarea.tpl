<div class="field {$class}">
	<label for="{$id|default:$name}">{$title}{if $help} <span class="icon-info" onclick="alert('{$help}')"></span>{/if}</label>
	<textarea id="{$id|default:$name}" name="{$name}" class="{$width|default:"long-text"}{if $editor} {$editor}{/if}" {if $rows} rows="{$rows}"{/if} {if $cols} cols="{$cols}"{/if}>{$value}</textarea>
</div>