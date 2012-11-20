<div class="table dnd">
	<ul class="thead">
		<li class="w10"></li>
		<li class="w40">{lng lng="title"}</li>
		<li class="w50">{lng lng="link"}</li>
		<li></li>
	</ul>
	<div class="tbody">
	{if $menu_items}
		{foreach from=$menu_items item=menu_item}
		<ul class="tr menu_item-{$menu_item.menu_item_id}" id="{$menu_item.menu_item_id}">
			{block view="menu.manage.row"}
		</ul>
		{/foreach}
	{else}
		<ul class="tr no-dnd">
			<li class="w100"><center>{lng lng="not_found"}</center></li>
		</ul>
	{/if}
	</div>

	<ul class="tr no-dnd menu_item-add" id="add">
		<li class="w10">
			<ul class="operation-toolbar">
				<li><a href="javascript:void(0);" class="icon-add"  sid="add" title="{lng lng="apply"}"></a></li>
			</ul>
		</li>
		<li class="w40">
			<input type="hidden" name="menu_id" value="{$menu_id}" />
			<input type="text" name="menu_item_title" value="" />
		</li>
		<li class="w50">
			<input type="text" name="menu_item_link" value="" />
		</li>
		<li></li>
	</ul>
</div>