{if $menus}
<fieldset>
	<h2>{lng lng="menu_settings"}</h2>

	{foreach from=$menus item=menu}
        <div class="field w33">
		<label for="menu_show_"|cat:$menu.menu_id>{$menu.menu_title}</label>
		{include file="skin/admin/splitter-input.tpl" name="menu_show_"|cat:$menu.menu_id
			items=$show_statuses value=$menu.show}
        </div>
	{/foreach}
</fieldset>
{/if}