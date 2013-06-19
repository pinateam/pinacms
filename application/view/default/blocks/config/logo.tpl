{if $logo.image_id}
{literal}
<style type="text/css" media="all">
<!--
#branding {
	background: url("{/literal}{img image_id=$logo.image_id}{literal}") no-repeat scroll left top transparent;
}
-->
</style>
{/literal}
{/if}