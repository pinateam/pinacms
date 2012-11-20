<h1>{lng lng="password_recovery"}</h1>
<form action="api.php" method="POST">
	<fieldset>
		<input type="hidden" name="action" value="user.request-restore-password" />

		{include file="skin/form-line-input.tpl" required=1 field="user_email" label="E-mail"}

		{include file="skin/captcha.tpl"}

		{include file="skin/button.tpl" title="restore_password"|lng}

		<a href="{link action="user.enter"}">{lng lng="sign_in"} &#8594;</a>
	</fieldset>
</form>