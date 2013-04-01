<h1><span class="section-icon icon-question"></span> {lng lng="faq_groups"}</h1>

<div class="right-narrow-column">

	<fieldset class="operations">
		<h2>{lng lng="actions"}</h2>
		<ul>
			<li><a href="{link action="faq-group.manage.add"}" class="add">{lng lng="add"}</a></li>
		</ul>
	</fieldset>
</div>

<div class="left-wide-column">
	{module action="faq-group.manage.list" wrapper="faq-group-list"}
</div>

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