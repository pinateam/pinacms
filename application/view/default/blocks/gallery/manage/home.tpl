<div class="right-narrow-column gallery-search-form">
	<fieldset class="operations">
		<h2>{lng lng="actions"}</h2>
		<ul>
			<li><a href="{link action="gallery.manage.add"}" class="add">{lng lng="add"}</a></li
		</ul>
	</fieldset>
</div>

<div class="left-wide-column">
	{module action="gallery.manage.list" wrapper="photo-list"}
</div>

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