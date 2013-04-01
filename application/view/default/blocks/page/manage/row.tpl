<td>
    <ul class="operation-toolbar">
        <li><a href="javascript:void(0);" class="icon-edit" sid="{$page.post_id}" title="{lng lng="edit"}"></a></li>
        <li><a href="javascript:void(0);" class="icon-delete" sid="{$page.post_id}" title="{lng lng="delete"}"></a></li>
    </ul>
</td>
<td class="editable">
    <a href="page.php?action=page.manage.edit&page_id={$page.post_id}">{$page.post_title}</a>
</td>
<td>
    {module action="page.manage.status" enabled=$page.post_enabled sid=$page.post_id}
</td>