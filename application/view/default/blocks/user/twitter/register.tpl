<p>{lng lng="do_complete_the_registration_please_enter_email"}</p>
{include file="skin/form-head.tpl" class="login-form"}
    <fieldset>
	<input type="hidden" name="action" value="user.twitter.login" />

		{include file="skin/form-line-input.tpl" required=1 name="user_email" title="E-mail"}

		{include file="skin/button.tpl" title="register"|lng}

    </fieldset>
{include file="skin/form-bottom.tpl"}