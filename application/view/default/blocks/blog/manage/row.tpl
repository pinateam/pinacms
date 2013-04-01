<td>
    <ul class="operation-toolbar">
        <li><a href="javascript:void(0);" class="icon-edit" sid="{$blog.blog_id}" title="{lng lng="edit"}"></a></li>
        <li><a href="javascript:void(0);" class="icon-delete"  sid="{$blog.blog_id}" title="{lng lng="delete"}"></a></li>
    </ul>
</td>
<td class="editable">
    <a href="{link action="blog.manage.edit" blog_id=$blog.blog_id}">{$blog.blog_title}</a>
</td>
<td>
    <a href="{link action="post.manage.home" blog_id=$blog.blog_id}">{lng lng="posts"}</a>
</td>
<td>
    {module action="blog.manage.status" enabled=$blog.blog_enabled sid=$blog.blog_id}
</td>