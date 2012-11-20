{foreach from=$blogs item=blog}
	<li><a class="{iflocation action='post.manage.home' blog_id=$blog.blog_id}active{/iflocation}" href="{link action='post.manage.home' blog_id=$blog.blog_id}">{$blog.blog_title}</a></li>
{/foreach}