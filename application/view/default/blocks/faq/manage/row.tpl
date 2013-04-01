<li class="w10">
	<ul class="operation-toolbar">
		<li><a href="#" class="icon-edit" sid="{$question.faq_id}" title="{lng lng="edit"}"></a></li>
		<li><a href="#" class="icon-delete" sid="{$question.faq_id}" title="{lng lng="delete"}"></a></li>
	</ul>
</li>
<li class="w70 editable">
	<a href="{link action="faq.manage.edit" faq_id=$question.faq_id}">{$question.faq_question|truncate:80}</a>
</li>
<li class="w20">
        {include file="skin/admin/splitter.tpl" name="status_question" class="question-status" sid=$question.faq_id value=$question.faq_enabled items=$question_statuses}
</li>