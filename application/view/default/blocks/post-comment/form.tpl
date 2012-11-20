{include file="skin/form-line-input.tpl" required=0 field="visitor_email" label="enter_email"|lng  value=$fill.visitor_email}
{include file="skin/form-line-input.tpl" required=0 field="visitor_site" label="website"|lng" value=$fill.visitor_site}
{include file="skin/form-line-input.tpl" required=0 field="visitor_name" label="your_name"|lng  value=$fill.visitor_name  }
{include file="skin/form-line-textarea.tpl" required=0 field="comment_message" label="text"|lng  value=$fill.comment_message id="comment_message"}
{include file="skin/form-line-input.tpl" required=0 type="hidden" field="answer_comment_id"  value=0 id="answer_comment_id"  }
	
