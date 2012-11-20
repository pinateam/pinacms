<form name="search" action="api.php" method="POST" id="search-form">
    <input type="hidden" name="action" value="post.manage.search" />

	<ul class="" >
		<li class="w100 wide-label">
			<label for="search-text">{lng lng="search_words"}:</label>
			<span class="full-row search-text">
				<input type="text" name="substring" id="search-text" value="{$search_rules.substring}" />
				<button class="transparent search-button" type="button">
					<img src="{site img="admin/magnifier.png"}" class="small-icon" />
				</button>
			</span>
		</li>
	</ul>

	{*module action="post.manage.select-blog" blog_id=$search_rules.blog_id filter_all=true*}
</form>