	{include file="skin/admin/paging.tpl"}
	<table id="users-list" class="w100" cellspacing="0">
		<!--
		<col width="20">
		<col width="20">
		<col width="48">
		<col width="180">
		-->

		<col width="40">
		<col width="60">
		<col>
		<col>
		<col>
		<col width="80">
		<col width="120">
		<col width="160">
		<thead>
			<tr>
				<th>
					{include file="skin/admin/table-header-sort.tpl" value="id" title="ID"}
				</th>
				<th>
					{lng lng="act_"}
				</th>

				<th>
					{include file="skin/admin/table-header-sort.tpl" value="login" title="login"|lng}
				</th>
				<th>
					{include file="skin/admin/table-header-sort.tpl" value="title" title="fio"|lng}
				</th>
				<th>
					{include file="skin/admin/table-header-sort.tpl" value="email" title="E-mail"}
				</th>
				<th>
					{include file="skin/admin/table-header-sort.tpl" value="created" title="reg_date"|lng}
				</th>
				<th>
					{include file="skin/admin/table-header-sort.tpl" value="type" title="membersh"|lng}
				</th>
				<th>
					{include file="skin/admin/table-header-sort.tpl" value="status" title="status"|lng}
				</th>
			</tr>
		</thead>
		<tbody>
	{if $users}
			{foreach from=$users item=user}
			<tr class="user-{$user.user_id}" sid="{$user.user_id}">
				{block view="user.manage.row" user=$user}
			</tr>
			{/foreach}
        {else}
            <tr>
                <td colspan="8">
                    <center>{lng lng="not_found"}</center>
                </td>
            </tr>
        {/if}
			<tr class="button-bar">
				<td colspan="8">
					<button class="css3" type="reset" onclick="document.location='{link action="user.manage.add"}'">{lng lng="add_user"}</button>
				</td>
			</tr>
		</tbody>
	</table>

	{include file="skin/admin/paging.tpl"}
