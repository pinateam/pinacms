<h1><span class="section-icon icon-colors"></span> {lng lng="contact_us_form"}</h1>

<form action="api.php" id="config_edit_form" method="POST">
<input type="hidden" name="action" value="config.manage.update" />
<input type="hidden" name="module_key" value="feedback" />


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
		<h2>{lng lng="common_data"}</h2>
		{include file="skin/admin/form-line-input.tpl" name="email" value=$config.feedback.email title="feedback_notification_email"|lng class="w100" width="long-text"}
	</fieldset>
</div>

</form>


{literal}
<script type="text/javascript">

$(".button-cancel").bind("click", function(){
	history.back();
	return false;
});

</script>
{/literal}