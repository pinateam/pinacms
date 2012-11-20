<p>{lng lng="do_not_have_account_yet"} <a href="{if $redirect_action}{link action="user.register" redirect_action=$redirect_action}{else}{link action="user.register"}{/if}">{lng lng="register"} &#8594;</a></p>
<form action="api.php" method="POST" class="login-form">
    <fieldset>
	<input type="hidden" name="action" value="user.login" />
        <input type="hidden" name="redirect_action" value="{$redirect_action}" />

	{include file="skin/form-line-input.tpl" required=1 field="user_login" label="login"|lng size="35" maxlength="40" id="quicksignInUsername"}
	{include file="skin/form-line-input.tpl" required=1 type="password" field="user_password" label="password"|lng size="35" id="quicksignInPassword"}

        <span class="passhelp">
            <a href="{link action="user.restore-password"}">{lng lng="i_lost_my_password"} &#8594;</a>
        </span>

	{include file="skin/button.tpl" title="sign_in"|lng}

    </fieldset>
</form>

{literal}
<script type="text/javascript">

$(".login-form").ajaxPageEdit(function(){
	location.reload();
});

</script>
{/literal}