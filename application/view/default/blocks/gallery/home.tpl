<h1>{lng lng="gallery"}</h1>

{foreach from=$photos item=p}
	<div style="float:left;margin:0 2px;">
		{module action="image.image" image_id=$p.image_id height="220" link="zoom" rel="group"}
		{if $p.vk_url}
			<a href="{$p.vk_url}">vkontakte</a>
		{/if}
	</div>
{/foreach}

{literal}
<script type="text/javascript">
	$(document).ready(function() {
		$("a.zoom").fancybox();
	});  
</script>
{/literal}
