<h1>{lng lng="gallery"}</h1>

{foreach from=$photos item=p}
<div style="float:left;margin:0 2px;">
	
<a class="zoom" rel="group" href="{img img=$p.photo_filename type="photo"}">
	<img src="{img img=$p.photo_filename type="photo" height="220"}" alt="" />
</a>

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
