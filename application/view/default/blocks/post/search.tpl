{include file="skin/content-header.tpl" title='post_search'|lng}

<div id="main_col" class="featured_wrap alignleft">
	<p>{lng lng="search-result" substring=$search_rules.substring count=$paging.items nowrapper=1}</p>

	{if $paging.items}
		<div class="products-sorting-paging">
			{sorting action="product.search" submitted=true sort_field=$sorting.field sort_dir=$sorting.direction page=$paging.current}
			{paging action="product.search" submitted=true sort_field=$sorting.field sort_dir=$sorting.direction page=$paging.current}
			<div class="clear"></div>
		</div>
	{/if}

	<div class="theProds clearfix alignleft eqcol">
		{block view="post.list" posts=$posts}
	</div>

</div>