<h1><span class="section-icon icon-new-string"></span> {lng lng="menu_management"}</h1>

<div class="right-narrow-column menu-search-form">
        {module action="menu.manage.filter" value=$menu_id}
</div>

<div class="left-wide-column">
        {module action="menu.manage.list" wrapper="menu-list" menu_id=$menu_id}
</div>


{literal}
<script type="text/javascript">

$(".menu-list").manageTable({
	action_list: "menu.manage.list",
        action_view: "menu.manage.row",
        action_edit: "menu.manage.row-edit",
        api_edit: "menu.manage.edit-row",
        api_delete: "menu.manage.delete",
        api_add: "menu.manage.add",
	api_reorder: "menu.manage.reorder",
	wrapper_form: ".menu-search-form",
        object: "menu_item"
});

</script>
{/literal}