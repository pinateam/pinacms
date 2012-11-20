<h1><span class="section-icon icon-book"></span>{lng lng="pages_management"}</h1>

{module action="page.manage.list" wrapper="page-list"}

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
