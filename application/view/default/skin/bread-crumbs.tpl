{if $breadcrumbs}
<ul class="bread-crumbs round-box css3">
	<li><a href="{link action="home"}">{lng lng="homepage"}</a></li>
	<li>::</li>

	{foreach from=$breadcrumbs item=b name="breadcrumbs"}
	{if $b.action}
		{module base=$b}
		{if not $smarty.foreach.breadcrumbs.last}
			<li>::</li>
		{/if}
	{elseif $b.caption}
		<li>{if $b.url && !$smarty.foreach.breadcrumbs.last}<a href="{$b.url}">{/if}{$b.caption}{if $b.url && !$smarty.foreach.breadcrumbs.last}</a>{/if}</li>
		{if not $smarty.foreach.breadcrumbs.last}
			<li>::</li>
		{/if}
	{/if}
	{/foreach}
</ul>
{/if}