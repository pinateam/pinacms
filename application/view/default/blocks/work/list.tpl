{if $works}
{foreach from=$works item=work name=work}
<div>
	{module action="image.image" image_id=$work.image_id class="alignleft"}

	<h3>{$work.work_title}</h3>

	{$work.work_description|format_description}
	<hr />
</div>
{/foreach}
{else}
	{lng lng="not_found"}
{/if}