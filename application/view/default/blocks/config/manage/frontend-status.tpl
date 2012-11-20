<div class="storefront-state">
	{*{lng lng="frontend"}:*}
	{include file="skin/admin/splitter.tpl" name="status" class="glow frontend-status" value=$config.core.frontend_status items=$frontend_status}

{literal}
<script language="JavaScript">
$(document).ready(function() {
	$(".frontend-status a").bind("click", function() {
		var splitter = $(this).parent().parent();
		var url = "api.php?action=config.manage.set&module_key=core&key=frontend_status&value="+$(this).attr("data-value");
		$.get(url);
	});
});
</script>
{/literal}

	[<a href="{link action="home"}">{lng lng="visit"}</a>]
</div>
