<script type="text/javascript" src="{site lib="tiny_mce/tiny_mce.js"}"></script>
{literal}
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		editor_deselector : "no-html-editor",
		theme : "advanced",
		plugins : "jbimages,paste,table,fullscreen,searchreplace,advimage,advlink,contextmenu,nonbreaking,emotions,xhtmlxtras,inlinepopups",

		// Theme options
		theme_advanced_buttons1 : "formatselect,bold,italic,underline,strikethrough,bullist,numlist,table,nonbreaking,|,link,unlink,|,emotions,|,search,replace,paste,|,fullscreen,code,|,image,jbimages",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		//theme_advanced_statusbar_location : "bottom",
		//theme_advanced_resizing : true,

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
{/literal}