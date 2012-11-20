<h1><span class="section-icon icon-book"></span>{lng lng="static_page_editing"}</h1>
<div id="page_edit">
    <form action="api.php" method="POST" name="page_edit_form" id="page_edit_form">
        <input type="hidden" name="action" value="page.manage.edit" />
        <input type="hidden" name="page_id" value="{$page_data.post_id}" />
	<div class="right-narrow-column">
		{include file="skin/admin/page-operations-save-cancel-delete.tpl" sid=$page_data.post_id}
	</div>

	<div class="left-wide-column">

		{block view="page.manage.form-common"}
		{module action="menu.manage.form-menu" url_action="page.view" url_params="page_id="|cat:$page_data.post_id}
		{module action="meta.manage.form-meta" url_action="page.view" url_params="page_id="|cat:$page_data.post_id}

	</div>

    </form>
</div>

{literal}
<script type="text/javascript">

$(document).ready(function(){
	$('#page_edit_form').managePage({
                api_delete: "page.manage.delete",
		object: "page",
	});
});


</script>
{/literal}