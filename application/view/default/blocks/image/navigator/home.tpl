<div class="image-navigator"
	{if $postfix}data-postfix="{$postfix}"{/if}
	{if $few}data-few="{$few}"{/if}
>
	<div class="right-narrow-column">
		{module action="image.navigator.search-form" wrapper="image-search-form"}
	</div>
	<div class="left-wide-column">	
		{module action="image.navigator.list" rules=$search_rules wrapper="image-list-wrapper"}
	</div>
</div>

{literal}
<script type="text/javascript">
	$(".image-list-wrapper").manageTable({
		action_list: "image.navigator.list",
		wrapper_form: ".image-search-form",
		object: "image"
	});
</script>
{/literal}

{literal}
<script type="text/javascript">
	if (!$(".image-list-wrapper .image").is(".image"))
	{
		$(".image-navigator .right-narrow-column").hide();
		$(".image-navigator .left-wide-column").removeClass("left-wide-column");	
	}
</script>
{/literal}