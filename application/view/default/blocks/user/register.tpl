<h1 class="shop-cat-title whereAmI">{lng lng="register"}</h1>
<div id="main_col" class="featured_wrap alignleft">
{include file="skin/form-head.tpl" class="register-form"}
    <fieldset>
        <input type="hidden" name="action" value="user.register" />

        <input type="hidden" name="redirect_action" value="{$redirect_action}" />

        {include file="skin/form-line-input.tpl" required=1 name="user_login" title="login"|lng}

        {include file="skin/form-line-input.tpl" required=1 name="user_email" title="E-mail"}

        {include file="skin/form-line-input.tpl" required=1 name="new_password" title="password"|lng type="password"}

        {include file="skin/form-line-input.tpl" required=1 name="new_password2" title="repeat_password"|lng type="password"}
        
        {module action="custom-field.list"}

        {include file="skin/captcha.tpl"}

        {include file="skin/button.tpl" title="register"|lng}

    </fieldset>
{include file="skin/form-bottom.tpl"}

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