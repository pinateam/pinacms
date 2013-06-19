<!-- Пейджинг -->
{if $paging.total gt 1}
<div class="products-paging" id="catalog-products-paging">
	{lng lng="pages"}:
	{section name=pages loop=$paging.total+1 start=1}
		{*if $smarty.section.pages.first}
			{if $paging.current gt 1}
				<a href="{link base=$base page=$paging.current-1}">{lng lng="_page_previous"}</a>
			{else}
				{lng lng="_page_previous"}
			{/if}
		{/if*}

		{if abs($paging.current - $smarty.section.pages.index) lte ($smarty.const.CATALOG_PAGING_PAGES - 1) / 2 or $smarty.section.pages.index lt $paging.current and $paging.total - $smarty.const.CATALOG_PAGING_PAGES lte $smarty.section.pages.index or $smarty.section.pages.index gt $paging.current and $smarty.const.CATALOG_PAGING_PAGES + 1 gte $smarty.section.pages.index or $smarty.section.pages.index eq 1 or $smarty.section.pages.index eq $paging.total}
			{if $paging.current eq $smarty.section.pages.index}
				&nbsp;{$smarty.section.pages.index}&nbsp;
			{else}
				<a href="{link base=$base page=$smarty.section.pages.index}">&nbsp;{$smarty.section.pages.index}&nbsp;</a>
			{/if}
		{elseif $smarty.section.pages.index lt $paging.current}
			{if $smarty.section.pages.index eq 2}
				...
			{/if}
		{elseif $smarty.section.pages.index gt $paging.current}
			{if $smarty.section.pages.index eq $paging.total - 1}
				...
			{/if}
		{/if}

		{*if $smarty.section.pages.last}
			{if $paging.current lt $paging.total}
				<a href="{link base=$base page=$paging.current+1}">{lng lng="_page_next"}</a>
			{else}
				{lng lng="_page_next"}
			{/if}
		{/if*}
	{/section}
</div>
{/if}