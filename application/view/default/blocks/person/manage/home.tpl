<h1><span class="section-icon icon-question"></span> {lng lng="team"} </h1>


<div class="right-narrow-column faq-search-form">
	<fieldset class="operations">
		<h2>{lng lng="actions"}</h2>
		<ul>
			<li><a href="{link action="person.manage.add"}" class="add">{lng lng="add"}</a></li>
		</ul>
	</fieldset>
</div>

<div class="left-wide-column">
	{module action="person.manage.list" wrapper="person-search"}
</div>

{literal}	
<script language="JavaScript">
	
	$(".person-search").manageTable({
		action_list:"person.manage.list",
		api_delete:"person.manage.delete",
		api_edit:"person.manage.edit-row",
		api_reorder:"person.manage.reorder",
			  
		action_view:"person.manage.row",
		action_edit:"person.manage.row-edit",

		object: "person"
	});
</script>
{/literal}


{literal}
<script language="JavaScript">

	$(document).ready(function() {
		$(".person-enabled a").live("click", function() {
			var splitter = $(this).parent().parent();
			var url = "api.php?action=person.manage.change-status&person_enabled="+$(this).attr("data-value")+"&person_id="+splitter.attr("sid");
			$.get(url);
		});
	});

</script>
{/literal}

{literal}
<script type="text/javascript">
	$(".person-search .button-add").click(function(){
		document.location = 'page.php?action=person.manage.add';
	});
</script>
{/literal}