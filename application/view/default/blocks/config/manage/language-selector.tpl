{include file="skin/admin/splitter.tpl" name="language" class="lang-selector" value=$config.core.language_code items=$language_selector}

{literal}
<script language="JavaScript">
$(document).ready(function() {
	$(".lang-selector a").bind("click", function() {
		var splitter = $(this).parent().parent();
		var url = "api.php?action=config.manage.set&module_key=core&key=language_code&value="+$(this).attr("data-value");
		$.get(url);
	});
});
</script>
{/literal}
