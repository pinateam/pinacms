{include file="skin/content-header.tpl" title='post_search'|lng}

<div id="main_col" class="featured_wrap alignleft">
	<p>{lng lng="search-result" substring=$search_rules.substring count=$paging.items nowrapper=1}</p>

	<div class="theProds clearfix alignleft eqcol">
		{block view="post.list" posts=$posts}
	</div>

	<p><a href="{link action="post.search"}">{lng lng="search_other_posts_on_query_"} "{$search_rules.substring}"</a></p>
</div>