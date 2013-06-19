<h1>{lng lng="change_password"}</h1>
{include file="skin/form-head.tpl"}
    <input type="hidden" name="action" value="user.change-password" />

    {include file="skin/form-line-input.tpl" required=1 name="user_password" title="old_password"|lng type="password"}

    {include file="skin/form-line-input.tpl" required=1 name="new_password" title="password"|lng type="password"}

    {include file="skin/form-line-input.tpl" required=1 name="new_password2" title="repeat_password"|lng type="password"}

    {include file="skin/button.tpl" title="change"|lng}

</form>