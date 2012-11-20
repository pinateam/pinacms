<nav class="breadcrumbs css3">
	<ul>
		<li><a href="{link action="dashboard"}">{lng lng="dashboard"}</a></li>

	{foreach from=$breadcrumbs item=b name="breadcrumbs"}
	{if $b.caption}
		<li>&raquo;</li>
		<li>{if $b.url && !$smarty.foreach.breadcrumbs.last}<a href="{$b.url}">{/if}{$b.caption}{if $b.url && !$smarty.foreach.breadcrumbs.last}</a>{/if}</li>
	{/if}
	{/foreach}
	</ul>
</nav>