{if $posts}

	{paging action="blog.view" blog_id=$blog_id page=$paging.current}

	{foreach from=$posts item=post}

		{include file="skin/content-subheader.tpl" title=$post.post_title}

		<p>{$post.post_text|format_description|format_photos:$post.post_id}</p>

		<p>{$post.post_created|date_format:"%d.%m.%Y"}</p>

	{/foreach}

	{paging action="blog.view" blog_id=$blog_id page=$paging.current}

{/if}