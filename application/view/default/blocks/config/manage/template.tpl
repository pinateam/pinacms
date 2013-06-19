<h1><span class="section-icon icon-colors"></span> {lng lng="site_skin"}</h1>

<form action="api.php" id="config_edit_form" method="POST">
<input type="hidden" name="action" value="config.manage.set-template" />

{include file="skin/admin/page-operations-save-cancel.tpl"}

<fieldset>
	<h2>{lng lng="select_skin"}</h2>

	<div class="multi-image-selector">
		<input type="hidden" name="template" value="{$template}"/>

		{foreach from=$templates item=template}
		<div class="image-selector" data-value="{$template}">
			<div class="image">
				<img src="{site img="../templates/"|cat:$template|cat:"/screenshot.png"}" width="155" />
				<center><strong>{$template|ucfirst}</strong></center>
			</div>
		</div>
		{/foreach}

		<div class="image-selector" data-value="default">
			<div class="image">
				<img src="{site img="../screenshot.png"}" width="155" />
				<center><strong>Default</strong></center>
			</div>
		</div>

	</div>
</fieldset>
</form>

{literal}
<script type="text/javascript">
	$(".multi-image-selector .image-selector").bind("click", function(){
		$(this).parents(".multi-image-selector").find(".image-selector").removeClass("selected");
		$(this).addClass("selected");

		var template = $(this).attr("data-value");
		$(this).parents(".multi-image-selector").find("input").val(template);
	});

	$(".multi-image-selector .image-selector").each(function(){
		var template = $(this).attr("data-value");
		var val = $(this).parents(".multi-image-selector").find("input").val();

		if (template == val) $(this).addClass("selected");
	});
</script>
{/literal}