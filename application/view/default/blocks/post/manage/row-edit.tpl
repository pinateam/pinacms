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
    <input name="post_published" value="{$post.post_published|replace:"0000-00-00 00:00:00":""|default:$post.post_created|format_datetime|htmlall}" />
</td>
<td>
    {module action="post.manage.status" enabled=$post.post_enabled sid=$post.post_id}
</td>