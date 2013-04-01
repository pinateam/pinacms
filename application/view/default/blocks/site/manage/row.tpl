<td>
	#{$site.site_id}
</td>
<td>
    <ul class="operation-toolbar">
        <li><a href="javascript:void(0);" class="icon-edit" sid="{$site.site_id}" title="{lng lng="edit"}"></a></li>
        <li><a href="javascript:void(0);" class="icon-delete"  sid="{$site.site_id}" title="{lng lng="delete"}"></a></li>
    </ul>
</td>
<td class="editable">
	#{$site.account_id}
</td>
<td class="editable">
	{$site.site_domain|default:"-"}
</td>
<td class="editable">
	{$site.site_path}
</td>
<td class="editable">
	{$site.site_template|default:"-"}
</td>
<td style="white-space:nowrap;">
	<a href="{link site_id=$site.site_id action="home"}">{lng lng="frontend"}</a> |
	<a href="{link site_id=$site.site_id action="dashboard"}">{lng lng="dashbrd"}</a> |
	<a href="{link api="site.manage.install-all" site_manage_id=$site.site_id}">{lng lng="install_all_modules"}</a>
</td>
<td>
	 {module action="site.manage.frontend-status" sid=$site.site_id}
</td>