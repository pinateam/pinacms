{strip}
	{if $title}<label for="{$name}">{$title}{if $required} *{/if}</label>{/if}
	<input type="{$type|default:"text"}" {if $style}style="{$style}"{/if} name="{$name}"{if $size} size="{$size}"{/if}{if $maxlength} maxlength="{$maxlength}"{/if}{if $id} id="{$id}"{/if} value="{$fill.$name|default:$value|htmlall}" {if $checked eq $value}checked="checked"{/if} />
{/strip}
{*
        <dl class="form-line-{$name} {if $required}required{/if}{if $error_subject eq $name} error{/if}">
            <dt>
                <label for="{$name}">{$title}:</label>
            </dt>
            <dd class="input">
                <input type="{$type|default:"text"}" name="{$name}" {if $id} id="{$id}"{/if}{if $size} size="{$size}"{/if} {if $maxlength}maxlength="{$maxlength}"{/if} value="{$fill.$name|default:$value}" />
            </dd>
        </dl>
*}