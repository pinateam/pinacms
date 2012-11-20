<h1><span class="section-icon icon-book"></span>{lng lng="blog_management"}</h1>

{module action="blog.manage.list" wrapper="blog-list"}

{literal}
<script type="text/javascript">

    $(".blog-list").manageTable({
	action_list: "blog.manage.list",
        action_view: "blog.manage.row",
        action_edit: "blog.manage.row-edit",
        api_delete: "blog.manage.delete",
        api_edit: "blog.manage.edit-row",
        object: "blog"
    });

</script>
{/literal}
