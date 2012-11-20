<h3>{$work.work_title}</h3>

{if $work.work_image_filename}
	<img
		src="{img img=$work.work_image_filename type="work_image"}"
		alt="{$work.work_title}"
		class="alignleft"
	/>
{/if}

{$work.work_description|format_description}