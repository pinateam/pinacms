<td>
    <ul class="operation-toolbar">
        <li><a href="javascript:void(0);" class="icon-edit" sid="{$post.post_id}" title="{lng lng="edit"}"></a></li>
        <li><a href="javascript:void(0);" class="icon-delete"  sid="{$post.post_id}" title="{lng lng="delete"}"></a></li>
    </ul>
</td>
<td>
    <a href="{if $post.blog_id == 0}
                {link action="page.manage.edit" page_id=$post.post_id}
            {else}
                {link action="post.manage.edit" post_id=$post.post_id}
            {/if}"
    >
	{if $post.post_title}
		{$post.post_title}
	{else}
		<i>{lng lng="edit"}</i>
	{/if}
    </a>
</td>
<td>
	{$post.post_created|format_date}
</td>
<td>
    {module action="post.manage.status" enabled=$post.post_enabled sid=$post.post_id input=false}
</td>