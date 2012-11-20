{*<dl class="required{if $error_subject eq "captcha"} error{/if}">*}
<label>{lng lng="captcha_code"}</label>
<img src="{$smarty.const.SITE}lib/kcaptcha/index.php?{session_name}={session_id}&rnd={rnd}" class="captcha" />
<input type="text" name="captcha" class="captcha" value="" style="" />
{*
<dl class="required">
    <dt><label for="captcha">{lng lng="enter_captcha_code"}</label></dt>
    <dd>
        <input type="text" name="captcha" class="captcha" value="" />
    </dd>
</dl>
*}