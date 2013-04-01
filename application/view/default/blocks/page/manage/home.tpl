<h1><span class="section-icon icon-book"></span>{lng lng="pages_management"}</h1>

<div class="right-narrow-column">

	<fieldset class="operations">
		<h2>{lng lng="actions"}</h2>
		<ul>
			<li><a href="{link action="page.manage.add"}" class="add">{lng lng="add"}</a></li>
		</ul>
	</fieldset>
</div>

<div class="left-wide-column">
	{module action="page.manage.list" wrapper="page-list"}
</div>

{literal}
<script type="text/javascript">

    $(".page-list").manageTable({
	action_list: "page.manage.list",
        action_view: "page.manage.row",
        action_edit: "page.manage.row-edit",
        api_delete: "page.manage.delete",
        api_edit: "page.manage.edit-row",
        object: "page"
    });
</script>
{/literal}
