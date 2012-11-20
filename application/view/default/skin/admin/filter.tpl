{strip}
<ul class="filter {$class}" data-name="{$name|format_class}"{if $sid} sid="{$sid}"{/if}>
	{foreach from=$items item=item name="filter"}
	<li class="{if $smarty.foreach.filter.first}first{elseif $smarty.foreach.filter.last}last{/if} {$item.color}">
		<a href="#" {if $value eq $item.value}class="selected"{/if} data-value="{$item.value|default:$item.caption}">
                    {if $item.img}<img src="{$smarty.const.SITE}style/images/{$item.img}" /> {/if}
                    {$item.caption}
                </a>
	</li>
	{/foreach}
</ul>
{/strip}