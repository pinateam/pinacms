{if $config.background_image.image_id || $config.background_image.selected}
{literal}
<style type="text/css" media="all">
<!--
html {
	background: url("{/literal}{strip}

		{if $config.background_image.image_id}
			{img image_id=$config.background_image.image_id}
		{else}
			{site img="background/"|cat:$config.background_image.selected}
		{/if}

	{/strip}{literal}") repeat scroll 0 0 transparent;
}
body {
	background:none;
}
#pg_wrap {
	box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);
}
-->
</style>
{/literal}
{/if}