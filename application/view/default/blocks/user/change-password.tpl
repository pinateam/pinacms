<h1>{lng lng="change_password"}</h1>
<form action="api.php" method="POST">
    <input type="hidden" name="action" value="user.change-password" />

    {include file="skin/form-line-input.tpl" required=1 field="user_password" label="old_password"|lng type="password"}

    {include file="skin/form-line-input.tpl" required=1 field="new_password" label="password"|lng type="password"}

    {include file="skin/form-line-input.tpl" required=1 field="new_password2" label="repeat_password"|lng type="password"}

    {include file="skin/button.tpl" title="change"|lng}

</form>