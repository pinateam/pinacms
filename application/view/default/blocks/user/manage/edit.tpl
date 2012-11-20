<h1><span class="section-icon icon-person"></span> {lng lng="user"} "{$user.user_login}" (Acc #{$user.account_id})</h1>

<form action="api.php" id="user_edit_form" method="POST">
	<input type="hidden" name="action" value="user.manage.edit" />
	<input type="hidden" name="user_id" value="{$user.user_id}" />

	{block view="user.manage.form"}
</form>