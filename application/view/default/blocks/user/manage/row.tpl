<td>
	<strong>{$user.user_id}</strong>
</td>
<td>
	<ul class="operation-toolbar">
		<li><a href="{link action="order.manage.home" user_id=$user.user_id}" class="icon-shopping-cart" title="{lng lng="orders"}"></a></li>
		<li><a href="#" class="icon-edit" sid="{$user.user_id}" title="{lng lng="edit"}"></a></li>
		<li><a href="#" class="icon-delete" sid="{$user.user_id}" data-message="{lng lng="are_you_sure_to_delete_user_"} '{$user.user_title|default:$user.user_login}'?" title="{lng lng="delete"}"></a></li>
	</ul>
</td>
<td>

	<a href="{link action="user.manage.edit" user_id=$user.user_id}">{$user.user_login|mark_substring:$search_rules.substring}</a>
</td>
<td>
	<a href="{link action="user.manage.edit" user_id=$user.user_id}">{$user.user_title|mark_substring:$search_rules.substring}</a>
</td>
<td>
	<a href="mailto:{$user.user_email}">{$user.user_email|mark_substring:$search_rules.substring}</a>
</td>

<td>
	{$user.user_created|date_format:"%d.%m.%Y"}
</td>
<td>
	{$user.access_group}
</td>
<td>
	{include file="skin/admin/splitter.tpl" name="status" class="splitter-user-status" sid=$user.user_id value=$user.user_status items=$user_statuses}
</td>