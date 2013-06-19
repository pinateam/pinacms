{if $image.image_filename}
	{if $link}
		<a class="{$link}" {if $rel}rel="{$rel}"{/if} {if $title}title="{$title}"{/if} href="{img img=$image.image_filename}">
	{/if}
	<img src="{img img=$image.image_filename width=$width height=$height}"{if $class} class="{$class}"{/if}{if $style} style="{$style}"{/if} />
	{if $link}
		</a>
	{/if}
{/if}