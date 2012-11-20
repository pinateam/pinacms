{*
<ul class="faq">
	{foreach from=$questions item=question}
		{if $question.faq_enabled eq "Y"}
			<li><a  href="#answer-{$question.faq_id}">{$question.faq_question}</a></li>
		{/if}
	{/foreach}
</ul>

<br />
*}

{foreach from=$questions item=question}
	{if $question.faq_enabled eq "Y"}
		<p><strong><a name="answer-{$question.faq_id}" href="#answer-{$question.faq_id}">{$question.faq_question}</a></strong></p>
		{$question.faq_answer|format_description}
	{/if}
{/foreach}