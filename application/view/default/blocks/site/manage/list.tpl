{include file="skin/admin/paging.tpl"}

<table class="w100" cellspacing="0">
<col width="20">
<col width="20">
<col>
<col width="150">
<col width="150">
<col>
<col>
<col>
<thead>
    <tr>
	<th>{include file="skin/admin/table-header-sort.tpl" value="id" title="ID"}</th>
        <th>{lng lng="act_"}</th>
        <th>{lng lng="account"}</th>
	<th>{include file="skin/admin/table-header-sort.tpl" value="domain" title="domain"|lng}</th>
	<th>{include file="skin/admin/table-header-sort.tpl" value="path" title="path"|lng}</th>
        <th>{include file="skin/admin/table-header-sort.tpl" value="template" title="template"|lng}</th>
	<th></th>
        <th></th>
    </tr>
</thead>
<tbody>
	{if $sites}
	{foreach from=$sites item=s}
		<tr class="site_manage-{$s.site_id}" id="{$s.site_id}">
		{block view="site.manage.row" site=$s nowrapper=1}
		</tr>
	{/foreach}
	{else}
		<tr><td colspan="8"><center>{lng lng="not_found"}</center></td></tr>
	{/if}
	<tr class="site_manage-add" id="add">
	<td>&nbsp;</td>
	<td>
		<ul class="operation-toolbar">
			<li><a href="javascript:void(0);" class="icon-add"  sid="add" title="{lng lng="add"}"></a></li>
		</ul>
	</td>
	<td></td>
	<td>
		<input name="site_domain" type="text" value="" />
	</td>
	<td>
		<input name="site_path" type="text" value="" />
	</td>
	<td>
		<input name="site_template" type="text" value="" />
	</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	</tr>
</tbody>
</table>

{include file="skin/admin/paging.tpl"}

{literal}
<script language="JavaScript">

$(document).ready(function() {
	$(".list-frontend-status a").bind("click", function() {
		var splitter = $(this).parent().parent();
		var url = "api.php?action=config.manage.set&module_key=core&key=frontend_status&value="+$(this).attr("data-value")+"&site_id="+$(splitter).attr("sid");
		$.get(url);
	});
});
</script>
{/literal}