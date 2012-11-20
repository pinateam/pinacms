{include file="skin/admin/paging.tpl"}

<div class="table dnd">
	{block view="faq.manage.search-head"}
	<div class="tbody">
		{foreach from=$questions item=question}
			<ul class="tr faq-{$question.faq_id}" id="{$question.faq_id}">
				{block view="faq.manage.row"  faq=$question}
			</ul>
		{foreachelse}
			<ul class="tr">
				<li class="w100"><center>{lng lng="list_is_empty"}</center></li>
			</ul>
		{/foreach}
	</div>

	<ul class="button-bar">
			<li><button class="css3 button-add">{lng lng="add_faq_item"}</button></li>
	</ul>
</div>