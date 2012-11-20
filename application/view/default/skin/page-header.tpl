<div id="header" class="clearfix noprint">
	<div class="container clearfix">
		{block view="product.search_quick" nowrapper=1}
		{module action="user.login-status" nowrapper=1}

		{include file="skin/page-header-logo.tpl"}		
		{include file="skin/page-header-menu.tpl"}

		{*
		<ul class="secondary_navi alignright">
			<li class="blog">{module action="post.main-blog-link"}</li>
		</ul>
		*}
	</div><!-- container -->
</div><!-- header-->