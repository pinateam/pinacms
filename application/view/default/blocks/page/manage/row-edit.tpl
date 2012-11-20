<td>
    <ul class="operation-toolbar">
        <li><a href="javascript:void(0);" class="icon-accept" sid="{$page.post_id}" title="{lng lng="apply"}"></a></li>
        <li><a href="javascript:void(0);" class="icon-decline" sid="{$page.post_id}" title="{lng lng="cancel"}"></a></li>
    </ul>
</td>
<td>
    <input name="post_title" type="text" value="{$page.post_title|htmlall}" />
</td>
<td>
    {module action="page.manage.status" enabled=$page.post_enabled sid=$page.post_id}
</td>