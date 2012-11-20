<td>
	<ul class="operation-toolbar">
		<li><a href="javascript:void(0);" class="icon-accept" sid="{$group.faq_group_id}" title="{lng lng="save"}"></a></li>
		<li><a href="javascript:void(0);" class="icon-decline" sid="{$group.faq_group_id}" title="{lng lng="cancel"}"></a></li>
	</ul>
</td>
<td>
	<input type="text" name="faq_group_title" value="{$group.faq_group_title|htmlall}" />
</td>

<td>
	 {include file="skin/admin/splitter.tpl" name="status_question" class="group-status" sid=$group.faq_group_id value=$group.faq_group_enabled items=$group_statuses}
</td>
