<h1><span class="section-icon icon-question"></span> {lng lng="portfolio"} </h1>

<div class="right-narrow-column work-search-form">
	{module action="work-group.manage.filter"}

	<fieldset class="operations">
		<h2>{lng lng="actions"}</h2>
		<ul>
			<li><a href="{link action="work.manage.add"}" class="add">{lng lng="add"}</a></li>
		</ul>
	</fieldset>
</div>

<div class="left-wide-column">
	{*block view="work.manage.search-form" wrapper="work-search-form"*}
	{module action="work.manage.list" wrapper="work_search"}
</div>

{literal}	
<script language="JavaScript">
	
$(".work_search").manageTable({
	action_list:"work.manage.list",
	api_delete:"work.manage.delete",
	api_edit:"work.manage.edit-row",
	api_reorder:"work.manage.reorder",

	action_view:"work.manage.row",
	action_edit:"work.manage.row-edit",
	wrapper_form: ".work-search-form",

	object: "work"
});

</script>
{/literal}

{literal}
<script language="JavaScript">
	$(document).ready(function() {
		$(".work-enabled a").live("click", function() {
			var splitter = $(this).parent().parent();
			var url = "api.php?action=work.manage.change-status&work_enabled="+$(this).attr("data-value")+"&work_id="+splitter.attr("sid");
			$.get(url);
		});
	});

</script>
{/literal}