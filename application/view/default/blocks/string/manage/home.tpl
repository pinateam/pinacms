
<script language="JavaScript">
{literal}
	function editNewTranslation()
	{
		var $row = $('.add-new-row');
		slideRowDown($row, 300);
	}
{/literal}
</script>

<h1><span class="section-icon icon-pen"></span> {lng lng="strings"}</h1>

<section class="filters css3">
	{module action="string.manage.search-form"}
</section>

{module action="string.manage.search" rules=$search_rules wrapper="string-manage-search-wrapper"}

{literal}
<script language="JavaScript">

	$("#string-list").manageTable({
		action_view:"string.manage.row",
		action_edit:"string.manage.row-edit",
		api_edit:"string.manage.edit-row",
		api_add:"string.manage.add",
		oncall: string_search,
		object: "string"
	});

	// логика удаления языковой переменной отличается от обычного удаления из строчки
	$("#string-list").find(".icon-delete").live("click", function()
	{
		if (!$(this).confirmDeleteMessage()) return false;

		var id = $(this).attr("sid");
		if (!id) alert("Please specify SID");
		var params = {};
		params["action"] = "string.manage.delete";
		params["string_key"] = id;
		params["language_code"] = $(".string-search-form #language_code").val();
		$(this).requestDelete(params, string_search);
		return false;
	});

	$("button.edit-few").live("click", function() {
		var params = $("#string-list").find("td.edit-few").getData();
		params["action"] = "string.manage.edit-few";
		params["language_code"] = $(".string-search-form #language_code").val();
		$.ajax({
			type: 'post',
			url: 'api.php',
			data: params,
			success: function(html) {
				string_search($(this).getPage());
			},
			error: function() {
				alert('{/literal}{lng lng="request_sending_failed"}{literal}');
			},
			dataType: 'html'
		});
		return false;
	});

</script>
{/literal}