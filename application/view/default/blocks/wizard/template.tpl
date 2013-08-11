<label for="template">{lng lng="template"}</label>
<div class="templates">
<input type="hidden" name="template" value="" />
{foreach from=$templates item=template}
<div style="float:left;border: 3px solid white;" class="template">
	<a href="#" data-value="{$template.template}"><img src="{img img=$template.screen}" /></a>
	{*<span>{$template.description}</span>*}
</div>
{/foreach}
</div>

<div style="clear: both;"></div>

{literal}
<script>
	$(".template a").bind("click", function() {
		var template = $(this).attr("data-value");
		$("input[name=template]").val(template);
		$(this).parents(".templates").find(".template").css("border", "3px solid white");
		$(this).parent().css("border", "3px solid red");
		return false;
	});

	$(".templates .template:first a").click();
</script>
{/literal}