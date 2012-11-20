
<td>
	<ul class="operation-toolbar">
		<li><a href="#" class="icon-edit" sid="{$group.faq_group_id}" title="{lng lng="edit"}"></a></li>
		<li><a href="#" class="icon-delete" sid="{$group.faq_group_id}" title="{lng lng="delete"}"></a></li>
	</ul>
</td>
	
<td>		
	<a href="{link action="faq-group.manage.edit" faq_group_id=$group.faq_group_id}">{$group.faq_group_title|htmlall}</a>
</td>
<td>
        {include file="skin/admin/splitter.tpl" name="status_question" class="group-status" sid=$group.faq_group_id value=$group.faq_group_enabled items=$group_statuses}
</td>
