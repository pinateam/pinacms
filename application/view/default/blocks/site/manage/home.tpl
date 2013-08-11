<h1><span class="section-icon icon-asterix"></span> {lng lng="sites_management"}</h1>

<section class="filters css3">
    {module action="site.manage.search-form" wrapper="site-search-form"}
</section>

{module action="site.manage.list" wrapper="site-list"}

{literal}
<script type="text/javascript">

$(".site-list").manageTable({
	action_list: "site.manage.list",
        action_view: "site.manage.row",
        action_edit: "site.manage.row-edit",
        api_edit: "site.manage.edit",
        api_delete: "site.manage.delete",
        api_add: "site.manage.add",
	wrapper_form: ".site-search-form",
        object: "site_manage"
});


</script>
{/literal}