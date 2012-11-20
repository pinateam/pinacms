<h1><span class="section-icon icon-book"></span>{lng lng="edit_faq_group"}</h1>
<form action="api.php" method="post" id="edit_faq-group">
	<input type="hidden" name="action" value="faq-group.manage.edit" />
	<input type="hidden" name="faq_group_id" value="{$group.faq_group_id}" />

	{include file="skin/admin/page-operations-save-cancel-delete.tpl" sid=$group.faq_group_id}

	<div class="left-wide-column">
		{block view="faq-group.manage.form"}
		{module action="menu.manage.form-menu" url_action="faq-group.view" url_params="faq_group_id="|cat:$group.faq_group_id}
		{module action="meta.manage.form-meta" url_action="faq-group.view" url_params="faq_group_id="|cat:$group.faq_group_id}
	</div>
</form>
		

{literal}
<script type="text/javascript">

$(document).ready(function(){
	$('#edit_faq-group').managePage({
		api_delete: "faq-group.manage.delete",
		object: "faq_group"
	});
});

</script>
{/literal}		