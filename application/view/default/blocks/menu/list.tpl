<ul>
	{foreach from=$menu_items item=menu_item}
	{if $menu_item.menu_item_enabled eq "Y"}
	<li>
		{if $menu_item.menu_item_link}
			<a href="{$menu_item.menu_item_link}">
		{else}
			<a href="{link action=$menu_item.url_action base=$menu_item.url_params}">
		{/if}
			{$menu_item.menu_item_title}
		</a>
	</li>
	{/if}
	{/foreach}
</ul>