{if $menu_item.menu_item_link}
	<a href="{$menu_item.menu_item_link}">
{else}
	<a href="{link action=$menu_item.url_action base=$menu_item.url_params}">
{/if}
	{$menu_item.menu_item_title}
</a>