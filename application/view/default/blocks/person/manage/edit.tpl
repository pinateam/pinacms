<h1><span class="section-icon icon-book"></span>{lng lng="edit_person"}</h1>
<form action="api.php" method="post" id="edit_person">
	<input type="hidden" name="action" value="person.manage.edit" />
	<input type="hidden" name="person_id" value="{$person_id}"  />

	<div class="right-narrow-column">

		<fieldset class="operations">
			<h2>{lng lng="actions"}</h2>
			<div class="button-bar">
				<button class="css3 button-add">{lng lng="save"}</button>
				<button class="css3 additional button-cancel">{lng lng="cancel"}</button>
			</div>
		</fieldset>

		{module action="person.manage.form-images" person_id=$person.person_id}

	</div>

	<div class="left-wide-column">
		<fieldset>
			{block view="person.manage.form"}
		</fieldset>
	</div>
</form>

{literal}
<script type="text/javascript">

	$(document).ready(function(){
		$('#edit_person').managePage({
			object: "person"
		});
	});

</script>
{/literal}	