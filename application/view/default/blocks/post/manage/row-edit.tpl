<td>
    <ul class="operation-toolbar">
         <li><a href="javascript:void(0);" class="icon-accept"  sid="{$post.post_id}" title="{lng lng="apply"}"></a></li>
        <li><a href="javascript:void(0);" class="icon-decline" sid="{$post.post_id}" title="{lng lng="cancel"}"></a></li>
    </ul>
</td>
<td>
    <input name="post_title" type="text" value="{$post.post_title|htmlall}" />
</td>
<td>
	{$post.post_created|format_date}
</td>
<td>
    {module action="post.manage.status" enabled=$post.post_enabled sid=$post.post_id}
</td>