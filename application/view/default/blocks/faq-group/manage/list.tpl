{include file="skin/admin/paging.tpl"}

<table id="faq_sort_ids" class="w100 faq-dnd" cellspacing="0">
	<col width="20">
	<col >	
	<col width="40">



	<thead>
		{block view="faq-group.manage.list-head"}
	</thead>
	<tbody>
		{foreach from=$groups item=group}
			<tr class="faq_group-{$group.faq_group_id}" id="{$group.faq_group_id}">
				{block view="faq-group.manage.row"  faq=$group}
			</tr>
		{foreachelse}
			<tr>
				<td colspan="3"><center>{lng lng="list_is_empty"}</center></td>
			</tr>
		{/foreach}


		<tr class="button-bar">
			<td colspan="3" >
				<button class="css3 button-add">Добавить группу</button>
			</td>
		</tr>
	</tbody>
</table>