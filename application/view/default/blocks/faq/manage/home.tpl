<h1><span class="section-icon icon-question"></span> {lng lng="faq_list"}</h1>

<div class="right-narrow-column faq-search-form">
	{module action="faq-group.manage.filter"}

	<fieldset class="operations">
		<h2>{lng lng="actions"}</h2>
		<ul>
			<li><a href="{link action="faq.manage.add"}" class="add">{lng lng="add"}</a></li>
		</ul>
	</fieldset>
</div>

<div class="left-wide-column">

	{*block view="faq.manage.search-form" wrapper="faq-search-form"*}

	{module action="faq.manage.list" wrapper="faq-search"}

</div>

{literal}	
<script language="JavaScript">
	
	$(".faq-search").manageTable({
		action_list:"faq.manage.list",
		api_delete:"faq.manage.delete",	
		action_edit:"faq.manage.row-edit",
		api_edit:"faq.manage.edit-row",
		api_reorder:"faq.manage.reorder",
		wrapper_form: ".faq-search-form",
		action_view:"faq.manage.row",
		object: "faq"
	});

</script>
{/literal}

{literal}
<script language="JavaScript">
$(document).ready(function() {
	$(".question-status a").live("click", function() {
		var splitter = $(this).parent().parent();
		var url = "api.php?action=faq.manage.change-status&status="+$(this).attr("data-value")+"&faq_id="+splitter.attr("sid");
		$.get(url);
	});
});
</script>
{/literal}

{literal}
<script type="text/javascript">
	
	$(".faq-search .button-add").live("click", function(){
		document.location = 'page.php?action=faq.manage.add';		
	});

</script>
{/literal}
