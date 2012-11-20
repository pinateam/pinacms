<div class="left-wide-column">

		<fieldset>
			<h2>{lng lng="common_settings"} <span onclick="alert('This is help')" class="icon-info"></span></h2>
			{module action="faq-group.manage.selector" value=$question.faq_group_id}
		
			<div class="field w50 user-status">
				<label for="user_status">{lng lng="status"} <span class="icon-info" onclick="alert('This is help')"></span></label>
				{include file="skin/admin/splitter-input.tpl" name="faq_enabled" value=$question.faq_enabled|default:'Y' items=$question_statuses}
			</div>

			{include file="skin/admin/form-line-input.tpl" name="faq_question" value=$question.faq_question title="question_text"|lng}

			<div class="field">
				<label for="answer">{lng lng="answer_text"} <span class="icon-info" onclick="alert('{lng lng="description_explanation"}')"></span></label>
				<textarea name="faq_answer" class="html-text" rows="10" cols="50">{$question.faq_answer}</textarea>
			</div>
		</fieldset>
</div>	