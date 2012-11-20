<td>
    <ul class="operation-toolbar">
	<li><a href="javascript:void(0);" class="icon-accept"  sid="{$blog.blog_id}" title="{lng lng="apply"}"></a></li>
	<li><a href="javascript:void(0);" class="icon-decline" sid="{$blog.blog_id}" title="{lng lng="cancel"}"></a></li>
    </ul>
</td>
<td>
    <input name="blog_title" type="text" value="{$blog.blog_title}" />
</td>
<td>
    <a href="{link action="post.manage.home" blog_id=$blog.blog_id}">{lng lng="posts"}</a>
</td>
<td>
    {module action="blog.manage.status" enabled=$blog.blog_enabled sid=$blog.blog_id}
</td>