<p>{lng lng="do_not_have_account_yet"} <a href="{if $redirect_action}{link action="user.register" redirect_action=$redirect_action}{else}{link action="user.register"}{/if}">{lng lng="register"} &#8594;</a></p>
{include file="skin/form-head.tpl" class="login-form"}
    <fieldset>
	<input type="hidden" name="action" value="user.login" />
        <input type="hidden" name="redirect_action" value="{$redirect_action}" />

	{include file="skin/form-line-input.tpl" required=1 name="user_login" title="login"|lng size="35" maxlength="40" id="quicksignInUsername"}
	{include file="skin/form-line-input.tpl" required=1 type="password" name="user_password" title="password"|lng size="35" id="quicksignInPassword"}

        <span class="passhelp">
            <a href="{link action="user.restore-password"}">{lng lng="i_lost_my_password"} &#8594;</a>
        </span>

	{include file="skin/button.tpl" title="sign_in"|lng}

    </fieldset>
{include file="skin/form-bottom.tpl"}

{if $facebook}
<a href="javascript:void(0);" onclick="javascript: window.location.href = '{link api="user.facebook.login"}';" style="display:block;"><img src="style/images/sign-in-with-facebook.png"></a>
{/if}

{if $twitter}
<a href="javascript:void(0);" onclick="javascript: window.location.href = '{link api="user.twitter.login"}';" style="margin-top: 25px; display:block;"><img src="style/images/sign-in-with-twitter.png"></a>
{/if}

{literal}
<script type="text/javascript">

$(".login-form").ajaxPageEdit(function(){
	location.reload();
});

</script>
{/literal}