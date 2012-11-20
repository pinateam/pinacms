{if $works}
{foreach from=$works item=work name=work}
<div>
	{if $work.work_image_filename}
		<img
			src="{img img=$work.work_image_filename type="work_image"}"
			alt="{$work.work_title}"
			class="alignleft"
		/>
	{/if}

	<h3>{$work.work_title}</h3>

	{$work.work_description|format_description}
	<hr />
</div>
{/foreach}
{else}
	{lng lng="not_found"}
{/if}