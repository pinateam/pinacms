	<label for="{$name}">{$title}{if $required} *{/if}</label>
	<textarea name="{$name}" {if $id}id="{$id}"{/if} {if $rows} rows="{$rows}"{/if} {if $cols} cols="{$cols}"{/if}>{$fill.$name|default:$value|htmlall}</textarea>
