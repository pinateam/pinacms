<li class="w10">
	<ul class="operation-toolbar">
		<li><a href="#" class="icon-accept" sid="{$question.faq_id}" title="{lng lng="save"}"></a></li>
		<li><a href="#" class="icon-decline" sid="{$question.faq_id}" title="{lng lng="cancel"}"></a></li>
	</ul>
</li>
<li class="w70">
	<input type="text" name="faq_question" value="{$question.faq_question}" />
</li>
<li class="w20">
        {include file="skin/admin/splitter.tpl" name="status_question" class="question-status" sid=$question.faq_id value=$question.faq_enabled items=$question_statuses}
</li>
