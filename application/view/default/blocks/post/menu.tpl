{if $posts}
	<ul>
	{if $title}
	<li><h4>{$title}</h4></li>
	{/if}
	{foreach from=$posts item=p}
		{if $p.post_title}
		<li><a href="{link action="post.view" post_id=$p.post_id}">{$p.post_title}</a></li>
		{/if}
	{/foreach}
	</ul>
{/if}