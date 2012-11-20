<td>
	#{$site.site_id}
</td>
<td>
    <ul class="operation-toolbar">
        <li><a href="javascript:void(0);" class="icon-accept"  sid="{$site.site_id}" title="{lng lng="apply"}"></a></li>
        <li><a href="javascript:void(0);" class="icon-decline" sid="{$site.site_id}" title="{lng lng="cancel"}"></a></li>
    </ul>
</td>
<td>
    #<input name="account_id" type="text" value="{$site.account_id}" style="width:20px;" />
</td>
<td>
    <input name="site_domain" type="text" value="{$site.site_domain}" />
</td>
<td>
    <input name="site_path" type="text" value="{$site.site_path}" />
</td>
<td>
	<input name="site_template" type="text" value="{$site.site_template}" />
</td>
<td>
	<a href="{link site_id=$site.site_id action="home"}">{lng lng="frontend"}</a> |
	<a href="{link site_id=$site.site_id action="dashboard"}">{lng lng="dashbrd"}</a> |
	<a href="{link api="site.manage.install-all" site_manage_id=$site.site_id}">{lng lng="install_all_modules"}</a>
</td>
<td>
    {module action="site.manage.frontend-status" sid=$site.site_id}
</td>