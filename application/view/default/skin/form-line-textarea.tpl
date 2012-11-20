	<label for="{$field}">{$label}{if $required} *{/if}</label>
	<textarea name="{$field}" {if $id}id="{$id}"{/if} {if $rows} rows="{$rows}"{/if} {if $cols} cols="{$cols}"{/if}>{$fill.$field|default:$value|htmlall}</textarea>
