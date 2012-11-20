<li class="w10">
    <ul class="operation-toolbar">
        <li><a href="javascript:void(0);" class="icon-edit" sid="{$menu_item.menu_item_id}" title="{lng lng="edit"}"></a></li>
        <li><a href="javascript:void(0);" class="icon-delete"  sid="{$menu_item.menu_item_id}" title="{lng lng="delete"}"></a></li>
    </ul>
</li>
<li class="w40">
    {$menu_item.menu_item_title}
</li>
<li class="w40">
	{if $menu_item.menu_item_link}
		<a href="{$menu_item.menu_item_link}" target="_blank">
			{$menu_item.menu_item_link}
		</a>
	{else}
		<a href="{link action=$menu_item.url_action base=$menu_item.url_params}" target="_blank">
			{capture name="link"}
				{link action=$menu_item.url_action base=$menu_item.url_params}
			{/capture}
			{$smarty.capture.link|truncate:40:"...":true}
		</a>
	{/if}
</li>
<li class="w10">
	{if $menu_item.menu_item_enabled eq "Y"}
		{lng lng="enabled"}
	{else}
		<span style="color:red">{lng lng="disabled"}</span>
	{/if}
</li>