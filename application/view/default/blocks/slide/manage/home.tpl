<h1><span class="section-icon icon-drawing"></span> {lng lng="slides"}</h1>

<div class="right-narrow-column">
	<fieldset class="operations">
		<h2>{lng lng="actions"}</h2>
		<ul>
			<li><a href="{link action="slide.manage.add"}" class="add">{lng lng="add"}</a></li>
		</ul>
	</fieldset>
</div>

<div class="left-wide-column">
	{module action="slide.manage.list" wrapper="slide-list"}
</div>

{literal}
<script type="text/javascript">

$(".slide-list").manageTable({
	action_list: "slide.manage.list",
        action_view: "slide.manage.row",
        action_edit: "slide.manage.row-edit",
        api_edit: "slide.manage.edit-row",
        api_delete: "slide.manage.delete",
        api_add: "slide.manage.add",
	api_reorder: "slide.manage.reorder",
	wrapper_list: "#slide-list",
        object: "slide"
});

$(".slide-list .slide-enabled a").live("click", function() {
	var splitter = $(this).parent().parent();
	var url = "api.php?action=slide.manage.change-status&status="+$(this).attr("data-value")+"&slide_id="+splitter.attr("sid");
	$.get(url);
});
</script>
{/literal}