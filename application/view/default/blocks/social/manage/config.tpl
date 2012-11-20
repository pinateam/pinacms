<h1><span class="section-icon icon-colors"></span> {lng lng="social_links"}</h1>

<form action="api.php" id="config_edit_form" method="POST">
<input type="hidden" name="action" value="config.manage.update" />
<input type="hidden" name="module_key" value="social" />


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

		{include file="skin/admin/form-line-input.tpl" name="facebook" value=$config.social.facebook title="facebook_profile"|lng class="w50" width="long-text"}

		<h2>Twitter</h2>

		{include file="skin/admin/form-line-input.tpl" name="twitter" value=$config.social.twitter title="twitter_profile"|lng width="long-text"}
		{include file="skin/admin/form-line-input.tpl" name="twitter_consumer_key" value=$config.social.twitter_consumer_key title="CONSUMER KEY" class="w50" width="long-text"}
		{include file="skin/admin/form-line-input.tpl" name="twitter_consumer_secret" value=$config.social.twitter_consumer_secret title="CONSUMER SECRET" class="w50" width="long-text"}
		{include file="skin/admin/form-line-input.tpl" name="twitter_oauth_token" value=$config.social.twitter_oauth_token title="OAUTH TOKEN" class="w50" width="long-text"}
		{include file="skin/admin/form-line-input.tpl" name="twitter_oauth_secret" value=$config.social.twitter_oauth_secret title="OAUTH SECRET" class="w50" width="long-text"}

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