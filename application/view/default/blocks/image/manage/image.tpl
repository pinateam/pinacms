{if $image.image_filename}
	<img src="{img img=$image.image_filename width=$width height=$height}" />
{else}
	{lng lng="not_found"}
{/if}
