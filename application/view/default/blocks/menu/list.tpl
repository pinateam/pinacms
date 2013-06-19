{strip}
<ul>
	{foreach from=$menu_items item=menu_item}
	{if $menu_item.menu_item_enabled eq "Y"}
	<li>
		{block view="menu.link" menu_item=$menu_item}
	</li>
	{/if}
	{/foreach}
</ul>
{/strip}