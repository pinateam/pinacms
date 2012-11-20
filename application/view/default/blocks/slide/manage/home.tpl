<h1><span class="section-icon icon-drawing"></span> {lng lng="slides"}</h1>

{module action="slide.manage.list" wrapper="slide-list"}


{literal}
<script type="text/javascript">

$(document).ready(function(){
	// Перетаскивание строк таблицы
	$('table.slide-dnd').tableDnD({
		onDrop: function(table, row) {
			$('.slide-list').fadeTo(0, 0.5);

			$.ajax({
				url: 'api.php?action=slide.manage.reorder&' + $(table).tableDnDSerialize(),
				dataType: 'text',
				success: function(result) {
					$('.slide-list').fadeTo(0, 1);
				},
				error: function() {
					alert('{/literal}{lng lng="request_sending_failed"}{literal}');
					$('.slide-list').fadeTo(0, 1);
				}
			});
		},
		dragHandle: "draggable"
	});
});


$(".slide-list").manageTable({
	action_list: "slide.manage.list",
        action_view: "slide.manage.row",
        action_edit: "slide.manage.row-edit",
        api_edit: "slide.manage.edit-row",
        api_delete: "slide.manage.delete",
        api_add: "slide.manage.add",
	wrapper_list: "#slide-list",
        object: "slide"
});


</script>
{/literal}