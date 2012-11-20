{if $single}
	<input type="hidden" name="blog_id" value="{$value}" />
{else}
<div class="field w50">
	<label for="blog_id">{lng lng="blog"}</label>
	{include file="skin/admin/splitter-input.tpl" name="blog_id" id="filter" items=$items value=$value}
</div>
{/if}