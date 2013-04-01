{if $single}
<div class="field w50">
	<label for="blog_id">{lng lng="blog"}</label>
	<input type="hidden" name="blog_id" value="{$value}" />
	<span class="value">{$caption}</span>
</div>
{elseif $items}
<div class="field w50">
	<label for="blog_id">{lng lng="blog"}</label>
	{include file="skin/admin/splitter-input.tpl" name="blog_id" id="filter" items=$items value=$value}
</div>
{else}
<div class="field w50">
	<label for="blog_id">{lng lng="blog"}</label>
	{lng lng="not_found"}<br /><a href="{link action="blog.manage.add"}" target="_blank">{lng lng="add_blog"}</a>
</div>
{/if}