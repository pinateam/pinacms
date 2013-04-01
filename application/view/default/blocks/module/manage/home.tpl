<h1><span class="section-icon icon-blocks"></span> {lng lng="modules"}</h1>

<div class="right-narrow-column module-search-form">
	<fieldset class="operations">
		<h2>{lng lng="group"}</h2>
		{include file="skin/admin/filter-input.tpl" name="group" value=$search_rules.group items=$group_filter}
	</fieldset>
</div>

<div class="left-wide-column">
	{module action="module.manage.search" wrapper="module-list"}
</div>

{literal}
<script language="JavaScript">

$(".module-list").manageTable({
	action_list:"module.manage.search",
	wrapper_form: ".module-search-form",
	object: "module"
});

$(document).ready(function() {
	$(".splitter-module-status a").live("click", function() {
		var splitter = $(this).parent().parent();
		var url = "api.php?action=module.manage.change-status&status="+$(this).attr("data-value")+"&module_key="+splitter.attr("sid");
		$.get(url);
	});
});

</script>
{/literal}