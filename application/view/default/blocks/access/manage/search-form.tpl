<form action="api.php" method="POST">
	<input type="hidden" name="action" value="access.manage.search" />
	<ul class="clearfix" >
		<li class="wide-label">
			<label for="access_group_id">{lng lng="membership"}:</label>
			<span>
				{include file="skin/admin/splitter-input.tpl" name="access_group_id" value=$search_rules.access_group_id items=$access_group_filter}
			</span>
		</li>
	</ul>
</form>