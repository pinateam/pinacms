<h1><span class="section-icon icon-calendar"></span>{lng lng="edit_work"}</h1>
<form action="api.php" method="post" id="edit_work">
	<input type="hidden" name="action" value="work.manage.edit" />
	<input type="hidden" name="work_id" value="{$work.work_id}" />

	<div class="right-narrow-column">

		<fieldset class="operations">
			<h2>{lng lng="actions"}</h2>
			<div class="button-bar">
				<button class="css3 button-add">{lng lng="save"}</button>
				<button class="css3 additional button-cancel">{lng lng="cancel"}</button>
			</div>
		</fieldset>
	{module action="work.manage.form-images" work_id=$work.work_id}
	</div>
	{block view="work.manage.form"}

</form>

{literal}
<script type="text/javascript">

$(document).ready(function(){
	$('#edit_work').managePage({
		object: "work"
	});
});

</script>
{/literal}	
