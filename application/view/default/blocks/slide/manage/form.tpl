

<div class="right-narrow-column">
	<fieldset class="operations">
		<h2>{lng lng="actions"}</h2>
		<div class="button-bar">
			<button class="css3 button-edit">{lng lng="save"}</button>
			<button class="css3 additional button-cancel">{lng lng="cancel"}</button>
		</div>
	</fieldset>
</div>

<div class="left-wide-column">

<fieldset>
	<h2>{lng lng="image"}</h2>
	{module action="image.manage.field" width="w50" image_id=$slide.image_id}

	<div class="field w50">
		<div class="field w100">
			<label for="slide_enabled">{lng lng="status"} <span class="icon-info" onclick="alert('This is help')"></span></label>
			{include file="skin/admin/splitter-input.tpl" name="slide_enabled" value=$slide.slide_enabled|default:'Y' items=$slide_statuses}
		</div>

		{include file="skin/admin/form-line-input.tpl" name="slide_href" value=$slide.slide_href title="link"|lng width="long-text"}
	</div>


</fieldset>

</div>

{literal}
<script type="text/javascript">

$(".button-cancel").bind("click", function(){
	history.back();
	return false;
});

</script>
{/literal}
