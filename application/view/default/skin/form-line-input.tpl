{strip}
	{if $label}<label for="{$field}">{$label}{if $required} *{/if}</label>{/if}
	<input type="{$type|default:"text"}" {if $style}style="{$style}"{/if} name="{$field}"{if $size} size="{$size}"{/if}{if $maxlength} maxlength="{$maxlength}"{/if}{if $id} id="{$id}"{/if} value="{$fill.$field|default:$value|htmlall}" {if $checked eq $value}checked="checked"{/if} />
{/strip}
{*
        <dl class="form-line-{$field} {if $required}required{/if}{if $error_subject eq $field} error{/if}">
            <dt>
                <label for="{$field}">{$label}:</label>
            </dt>
            <dd class="input">
                <input type="{$type|default:"text"}" name="{$field}" {if $id} id="{$id}"{/if}{if $size} size="{$size}"{/if} {if $maxlength}maxlength="{$maxlength}"{/if} value="{$fill.$field|default:$value}" />
            </dd>
        </dl>
*}