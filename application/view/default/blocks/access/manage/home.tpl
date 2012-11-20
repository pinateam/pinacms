<h1><span class="section-icon icon-blocks"></span> {lng lng="accesses_management"}</h1>
<section class="filters css3"> <!-- fixed-width -->
	{block view="access.manage.search-form" wrapper="access-manage-search-form-wrapper"}
</section>

{module action="access.manage.search" rules=$search_rules wrapper="access-list"}

{literal}
<script language="JavaScript">

	$(".access-list").manageTable({
		action_list: "access.manage.search",
		api_delete: "access.manage.delete",
		api_add: "access.manage.add",
		wrapper_form: ".access-manage-search-form-wrapper",
		object: "access"
	});

</script>
{/literal}

{literal}
<script language="JavaScript">
$(document).ready(function() {
	$(".splitter-access-status a").live("click", function() {
		var splitter = $(this).parent().parent();
		var url = "api.php?action=access.manage.change-status&status="+$(this).attr("data-value")+"&access_id="+splitter.attr("sid");
		$.get(url);
	});
});
</script>
{/literal}