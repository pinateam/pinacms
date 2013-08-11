{include file="skin/content-header.tpl" title="sign_in"|lng}
<table style="width:99%;border-top:none;">
<tr>
<td style="width:50%;">
<p>{lng lng="do_not_have_account_yet"} <a href="{link action="user.register" redirect_action="wizard.install"}">{lng lng="register"} &#8594;</a></p>
<form action="api.php" method="POST" class="login-form">
    <fieldset>
	<input type="hidden" name="action" value="user.login" />

	{include file="skin/form-line-input.tpl" required=1 name="user_login" title="login"|lng size="35" maxlength="40" id="quicksignInUsername"}
	{include file="skin/form-line-input.tpl" required=1 type="password" name="user_password" title="password"|lng size="35" id="quicksignInPassword"}

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
</td>
<td style="vertical-align:middle;">
<p style="text-align:left;padding: 30px;">
    {*<a href="{link action="user.register" redirect_action="wizard.install"}">{lng lng="register"} &#8594;</a>*}
</p>
</td>
</tr>
</table>