<h1><span class="section-icon icon-book"></span>{lng lng="add_faq_item"}</h1>
<form action="api.php" method="post" id="add_faq">
	<input type="hidden" name="action" value="faq.manage.add" />

	{include file="skin/admin/page-operations-create-cancel.tpl"}

	{block view="faq.manage.form"}

</form>


{literal}
<script type="text/javascript">

$(document).ready(function(){
	$('#add_faq').managePage({
		object: "faq"
	});
});

</script>
{/literal}