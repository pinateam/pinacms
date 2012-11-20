<h1><span class="section-icon icon-calendar"></span>{lng lng="edit_portfolio"}</h1>
<form action="api.php" method="post" id="edit_work_group">
	<input type="hidden" name="action" value="work-group.manage.edit" />
	<input type="hidden" name="work_group_id" value="{$work_group.work_group_id}" />

	<div class="right-narrow-column">
		<fieldset class="operations">
			<h2>{lng lng="actions"}</h2>
			<div class="button-bar">
				<button class="css3 button-add">{lng lng="save"}</button>
				<button class="css3 additional button-cancel">{lng lng="cancel"}</button>
			</div>
		</fieldset>
		{module action="work-group.manage.form-images" work_group_id=$work_group.work_group_id}
	</div>
	{block view="work-group.manage.form"}

</form>

{literal}
<script type="text/javascript">

$(document).ready(function(){
	$('#edit_work_group').managePage({
		object: "work-group"
	});
});

</script>
{/literal}	
