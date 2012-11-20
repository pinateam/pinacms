<h1><span class="section-icon icon-people"></span> {lng lng="users"}</h1>

<div class="right-narrow-column user-search-form">
	<fieldset class="operations">
		<h2>{lng lng="membership"}</h2>
		{include file="skin/admin/filter-input.tpl" name="access_group_id" value=$search_rules.access_group_id items=$access_group_filter}
	</fieldset>

	<fieldset class="operations">
		<h2>{lng lng="status"}</h2>
		{include file="skin/admin/filter-input.tpl" name="user_status" value=$search_rules.user_status items=$user_status_filter}
	</fieldset>

	<fieldset class="operations">
		<h2>{lng lng="actions"}</h2>
		<ul>
			<li><a href="{link action="user.manage.add"}" class="add">{lng lng="add_user"}</a></li>
		</ul>
	</fieldset>
</div>

<div class="left-wide-column">

<section class="filters css3"> <!-- fixed-width -->
	{block view="user.manage.search-form" wrapper="user-search-form"}
</section>

{module action="user.manage.search" rules=$search_rules wrapper="user-list"}

</div>

{literal}
<script language="JavaScript">

	$(".user-list").manageTable({
		action_view:"user.manage.row",
		action_edit:"user.manage.row-edit",
		action_list: "user.manage.search",
		api_edit:"user.manage.edit-row",
		api_delete:"user.manage.delete",
		wrapper_form: ".user-search-form",
		object: "user"
	});

</script>
{/literal}

{literal}
<script language="JavaScript">
$(document).ready(function() {
	$(".splitter-user-status a").live("click", function() {
		var splitter = $(this).parent().parent();
		var url = "api.php?action=user.manage.change-status&status="+$(this).attr("data-value")+"&user_id="+splitter.attr("sid");
		$.get(url);
	});
});
</script>
{/literal}