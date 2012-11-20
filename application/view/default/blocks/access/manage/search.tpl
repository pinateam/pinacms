<table class="w100" cellspacing="0">

	<col width="30">
	<col>
	<col>
	<col>

	<thead>
		<tr>
			<th>
				{lng lng="act_"}
			</th>
			<th>
				<a href="#">{lng lng="module"}</a>

			</th>
			<th>
				<a href="#">{lng lng="membersh"}</a>

			</th>
			<th>
				<a href="#">{lng lng="title"}</a>
			</th>
			<th>
				<a href="#">{lng lng="status"}</a>
			</th>
		</tr>

	</thead>
	<tbody>
		{foreach from=$accesses item=a}
		<tr id="access-{$a.access_id}">
			{block view="access.manage.row access=$a}
		</tr>
		{/foreach}
		{block view="access.manage.row-add" nowrapper=1}

	</tbody>
</table>