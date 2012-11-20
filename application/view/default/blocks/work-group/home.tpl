<h1>{lng lng="portfolio"}</h1>
{foreach from=$work_groups item=work_group name=work_group}
<div>
	{if $work_group.work_group_image_filename}
		<img 
			src="{img img=$work_group.work_group_image_filename type="work_group_image"}"
			alt="{$work_group.work_group_title}"
			class="alignleft"
		/>
	{/if}
	<a href="{link action="work-group.view" work_group_id=$work_group.work_group_id}">{$work_group.work_group_title}</a>
	<hr />
</div>
{/foreach}