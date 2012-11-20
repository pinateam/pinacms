<div class="button_add"  id="target"><a href="{link action="work-group.manage.add"}"></a></div>
<h1><span class="section-icon icon-question"></span> {lng lng="portfolio"} </h1>
{module action="work-group.manage.list" wrapper="work_group_search"}

{literal}	
<script language="JavaScript">
	
	$(".work_group_search").manageTable({
		action_list:"work-group.manage.list",
		api_delete:"work-group.manage.delete",
		api_edit:"work-group.manage.edit-row",
			  
		action_view:"work-group.manage.row",
		action_edit:"work-group.manage.row-edit",
	
				
		object: "work_group"
	});
</script>
{/literal}


{literal}
<script language="JavaScript">
$(document).ready(function(){
	$('table.work-dnd').tableDnD({
		onDrop: function(table, row) {
			$('.work_group_search').fadeTo(0, 0.5);
			
			$.ajax({
				url: 'api.php?action=work-group.manage.reorder&' + $(table).tableDnDSerialize(),
				dataType: 'text',
				success: function(result) {
					$('.work_group_search').fadeTo(0, 1);
				},
				error: function() {
					alert('Не удается отправить запрос.');
					$('.work_group_search').fadeTo(0, 1);
				}
			});
		},
		dragHandle: "draggable"
	});
});

</script>
{/literal}

{literal}
<script language="JavaScript">
	$(document).ready(function() {
		$(".work-group-enabled a").live("click", function() {
			var splitter = $(this).parent().parent();
			var url = "api.php?action=work-group.manage.change-status&work_group_enabled="+$(this).attr("data-value")+"&work_group_id="+splitter.attr("sid");
			$.get(url);
		});
	});

</script>
{/literal}