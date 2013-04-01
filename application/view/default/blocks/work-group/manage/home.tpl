<h1><span class="section-icon icon-question"></span> {lng lng="portfolio"} </h1>

<div class="right-narrow-column">
	<fieldset class="operations">
		<h2>{lng lng="actions"}</h2>
		<ul>
			<li><a href="{link action="work-group.manage.add"}" class="add">{lng lng="add"}</a></li>
		</ul>
	</fieldset>
</div>

<div class="left-wide-column">
	{module action="work-group.manage.list" wrapper="work-group-list"}
</div>

{literal}	
<script language="JavaScript">
	
	$(".work-group-list").manageTable({
		action_list:"work-group.manage.list",
		api_delete:"work-group.manage.delete",
		api_edit:"work-group.manage.edit-row",
		api_reorder:"work-group.manage.reorder",
			  
		action_view:"work-group.manage.row",
		action_edit:"work-group.manage.row-edit",
				
		object: "work_group"
	});

	$(document).ready(function() {
		$(".work-group-enabled a").live("click", function() {
			var splitter = $(this).parent().parent();
			var url = "api.php?action=work-group.manage.change-status&work_group_enabled="+$(this).attr("data-value")+"&work_group_id="+splitter.attr("sid");
			$.get(url);
		});
	});

</script>
{/literal}