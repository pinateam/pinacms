<ul>
	<li><a href="{link action="home"}">{lng lng="homepage"}</a></li>
	{foreach from=$pages item=post}
		<li><a href="{link action="page.view" page_id=$post.post_id}" title="{$post.post_title|htmlall}">{$post.post_title}</a></li>
	{/foreach}
</ul>