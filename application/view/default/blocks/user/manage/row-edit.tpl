<td>
	<strong>{$user.user_id}</strong>
</td>
<td>
	<ul class="operation-toolbar">
		<li><a href="#" class="icon-accept" sid="{$user.user_id}" title="{lng lng="save"}"></a></li>
		<li><a href="#" class="icon-decline" sid="{$user.user_id}" title="{lng lng="cancel"}"></a></li>
	</ul>
</td>
<td>
	<input type="text" name="user_login" value="{$user.user_login}" />
</td>
<td>
	<input type="text" name="user_title" value="{$user.user_title}" />
</td>
<td>
	<input type="text" name="user_email" value="{$user.user_email}" />
</td>

<td>
	{$user.user_created|format_datetime}
</td>
<td>
	{$user.access_group}
</td>
<td>
	{include file="skin/admin/splitter.tpl" name="status" class="splitter-user-status" sid=$user.user_id value=$user.user_status items=$user_statuses}
</td>