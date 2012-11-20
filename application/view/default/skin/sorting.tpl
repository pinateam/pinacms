<!-- Сортировка -->
<div class="products-sorting">
	{lng lng="sort_by"}:

	{foreach from=$sort_fields key=name item=title}
	<!-- Сортировка по цене -->
	{if $sorting.field eq $name}
		{if $sorting.direction eq 'asc'}
			{assign var=newSortDir value='desc'}
		{else}
			{assign var=newSortDir value='asc'}
		{/if}
	{else}
		{assign var=newSortDir value='asc'}
	{/if}
	<a href="{link base=$base sort_field=$name sort_dir=$newSortDir}">{if $sorting.field eq $name}{if $newSortDir eq 'asc'}&darr;{elseif $newSortDir eq 'desc'}&uarr;{/if}{/if}{$title}</a>

	|

	{/foreach}

	<!-- Сортировка по умолчанию -->
	{if $sorting.field ne "" && $sorting.field ne "default"}
		<a href="{link base=$base sort_field='' sort_dir='' page=$paging.current}">{lng lng="_by_default"}</a>
	{else}
		{lng lng="_by_default"}
	{/if}
</div>