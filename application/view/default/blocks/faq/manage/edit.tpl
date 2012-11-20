<h1><span class="section-icon icon-book"></span>{lng lng="edit_faq_item"}</h1>
<form action="api.php" method="post" id="edit_faq">
	<input type="hidden" name="action" value="faq.manage.edit" />
	<input type="hidden" name="faq_id" value="{$faq_id}" />

	{include file="skin/admin/page-operations-save-cancel.tpl"}

	{block view="faq.manage.form"}
</form>
		
		

{literal}
<script type="text/javascript">

$(document).ready(function(){
	$('#edit_faq').managePage({
		object: "faq"
	});
});


</script>
{/literal}		