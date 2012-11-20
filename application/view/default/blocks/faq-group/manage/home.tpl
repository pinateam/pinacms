<h1><span class="section-icon icon-question"></span> {lng lng="faq_groups"}</h1>


{module action="faq-group.manage.list" wrapper="faq-group-list"}

{literal}	
<script language="JavaScript">
	
	$(".faq-group-list").manageTable({
		action_list:"faq-group.manage.list",
		action_edit:"faq-group.manage.row-edit",
		action_view:"faq-group.manage.row",
		api_delete:"faq-group.manage.delete",
		api_edit:"faq-group.manage.edit-row",
		object: "faq_group"
	});
</script>
{/literal}

{literal}
<script language="JavaScript">
$(document).ready(function() {
	$(".group-status a").live("click", function() {
		var splitter = $(this).parent().parent();
		var url = "api.php?action=faq-group.manage.change-status&status="+$(this).attr("data-value")+"&faq_group_id="+splitter.attr("sid");
		$.get(url);
	});
});
</script>
{/literal}
{literal}
<script type="text/javascript">
	
	$(".faq-group-list .button-add").live("click", function(){
		document.location = 'page.php?action=faq-group.manage.add';		
	});

</script>
{/literal}


