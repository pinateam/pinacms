<h1><span class="section-icon icon-blocks"></span> {lng lng="modules"}</h1>

<table id="modules-list" class="w100" cellspacing="0">

	<col width="30">
	<col width="30">
	<col>
	<col width="65">
	<col width="170">

	<thead>
		<tr>
			<th>
				#
			</th>
			<th>
			</th>
			<th>
				<a href="#">{lng lng="module"}</a>

			</th>
			<th>
				<a href="#">{lng lng="version"}</a>
			</th>
			<th>
				<a href="#">{lng lng="status"}</a>
			</th>
		</tr>

	</thead>
	<tbody>
		{foreach from=$modules item=m name="modules"}
		<tr id="module-1">
			<td><strong>{$smarty.foreach.modules.index+1}</strong></td>
			<td>
				<ul class="operation-toolbar">
					{if $m.module_config_action}
					<li><a href="{link action=$m.module_config_action}" class="icon-setup" title="{lng lng="settings"}"></a></li>
					{/if}
				</ul>

			</td>
			<td>
				<div>
					<strong>
						{*if $m.module_config_action}<a href="{link action=$m.module_config_action}">{/if*}
						{$m.module_title}
						{*if $m.module_config_action}</a>{/if*}
					</strong>
				</div>
				<div>
					{$m.module_description}
					{* <a class="icon-info" href="#">{lng lng="details"} &raquo;</a>*}
				</div>
			</td>
			<td>
				{$m.module_version}
			</td>
			<td>
				{include file="skin/admin/splitter.tpl" name="status" class="splitter-module-status" sid=$m.module_key value=$m.module_enabled items=$module_statuses}
			</td>
		</tr>
		{foreachelse}
		<tr><td colspan="5"><center>{lng lng="no_module_installed"}</center></td></tr>
		{/foreach}
	</tbody>
</table>


{literal}
<script language="JavaScript">
$(document).ready(function() {
	$(".splitter-module-status a").live("click", function() {
		var splitter = $(this).parent().parent();
		var url = "api.php?action=config.manage.change-module-status&status="+$(this).attr("data-value")+"&module_key="+splitter.attr("sid");
		$.get(url);
	});
});
</script>
{/literal}