{foreach from=$blogs item=b}
	<li><a href="{link action="blog.view" blog_id=$b.blog_id}" title="{$b.blog_title|htmlall}">{$b.blog_title}</a></li>
{/foreach}