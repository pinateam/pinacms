{if $paging.total gt 1}
	<div class="paginator">
	{section name=pages loop=$paging.total+1 start=1}
		{if $smarty.section.pages.first}
			{if $paging.current gt 1}
				<a href="javascript:void(0);" data-value="{$paging.current-1}">&laquo;</a>
			{else}
				&laquo;
			{/if}
		{/if}

		{if abs($paging.current - $smarty.section.pages.index) lte ($smarty.const.CATALOG_PAGING_PAGES - 1) / 2 or $smarty.section.pages.index lt $paging.current and $paging.total - $smarty.const.CATALOG_PAGING_PAGES lte $smarty.section.pages.index or $smarty.section.pages.index gt $paging.current and $smarty.const.CATALOG_PAGING_PAGES + 1 gte $smarty.section.pages.index or $smarty.section.pages.index eq 1 or $smarty.section.pages.index eq $paging.total}
			{if $paging.current eq $smarty.section.pages.index}
				<span class="current">{$smarty.section.pages.index}</span>
			{else}
				<a href="javascript:void(0);" data-value="{$smarty.section.pages.index}">{$smarty.section.pages.index}</a>
			{/if}
		{elseif $smarty.section.pages.index lt $paging.current}
			{if $smarty.section.pages.index eq 2}
				<span>...</span>
			{/if}
		{elseif $smarty.section.pages.index gt $paging.current}
			{if $smarty.section.pages.index eq $paging.total - 1}
				<span>...</span>
			{/if}
		{/if}

		{if $smarty.section.pages.last}
			{if $paging.current lt $paging.total}
				<a href="javascript:void(0);" data-value="{$paging.current+1}">&raquo;</a>
			{else}
				&raquo;
			{/if}
		{/if}
	{/section}
	</div>
{/if}