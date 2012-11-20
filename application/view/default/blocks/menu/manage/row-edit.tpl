<li class="w10">
    <ul class="operation-toolbar">
        <li><a href="javascript:void(0);" class="icon-accept" sid="{$menu_item.menu_item_id}" title="{lng lng="apply"}"></a></li>
        <li><a href="javascript:void(0);" class="icon-decline" sid="{$menu_item.menu_item_id}" title="{lng lng="cancel"}"></a></li>
    </ul>
</li>
<li class="w40">
	<input name="menu_item_title" type="text" value="{$menu_item.menu_item_title}" />
</li>
<li class="w50">
	{if $menu_item.url_action}
	{else}
		<input name="menu_item_link" type="text" value="{$menu_item.menu_item_link}" />
	{/if}
</li>
<li></li>