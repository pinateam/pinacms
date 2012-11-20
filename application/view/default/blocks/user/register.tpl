<h1 class="shop-cat-title whereAmI">{lng lng="register"}</h1>
<div id="main_col" class="featured_wrap alignleft">
<form action="api.php" method="POST" class="register-form">
    <fieldset>
        <input type="hidden" name="action" value="user.register" />

        <input type="hidden" name="redirect_action" value="{$redirect_action}" />

        {include file="skin/form-line-input.tpl" required=1 field="user_login" label="login"|lng}

        {include file="skin/form-line-input.tpl" required=1 field="user_email" label="E-mail"}

        {include file="skin/form-line-input.tpl" required=1 field="new_password" label="password"|lng type="password"}

        {include file="skin/form-line-input.tpl" required=1 field="new_password2" label="repeat_password"|lng type="password"}

        {include file="skin/captcha.tpl"}

        {include file="skin/button.tpl" title="register"|lng}

    </fieldset>
</form>

{literal}
<script type="text/javascript">

$(".register-form").ajaxPageEdit(function(){
        location.reload();
});

</script>
{/literal}

<p>
    <a href="{link action="user.enter"}">{lng lng="still_sign_in_on_site"} &#8594;</a>
</p>
</div>