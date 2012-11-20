<h1><span class="section-icon icon-asterix"></span> Галлерея</h1>

{module action="gallery.manage.list" wrapper="photo-list"}

{literal}
<script type="text/javascript">

$(".photo-list").manageTable({
	action_list: "gallery.manage.list",
        action_view: "gallery.manage.row",
        action_edit: "gallery.manage.row-edit",
        api_edit: "gallery.manage.photo-edit-row",
        api_delete: "gallery.manage.photo-delete",
	wrapper_list: ".photo-list",
        object: "photo"
});

$(".photo-enabled a").live("click", function() {
	var splitter = $(this).parent().parent();
	var url = "api.php?action=gallery.manage.photo-change-status&status="+$(this).attr("data-value")+"&photo_id="+splitter.attr("sid");
	$.get(url);
});

</script>
{/literal}