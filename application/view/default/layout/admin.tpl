<!doctype html>
<html lang="en" class="no-js">
<meta http-equiv="Content-Type" content="text/html; charset={$smarty.const.SITE_CHARSET}" />
<head>
	{include file="skin/admin/meta.tpl"}
	{include file="skin/admin/resources.tpl"}
</head>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->

<!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
<!--[if IE 7 ]>    <body class="ie ie7"> <![endif]-->
<!--[if IE 8 ]>    <body class="ie ie8"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <body class="non-ie"> <!--<![endif]-->

<div id="wrapper" class="{php}if (Session::get("save_menu_toggle_state") == "hide") echo "no-menu";{/php}">
	{include file="skin/admin/page-header.tpl"}
	<section id="middle">
		<div class="menu-toggle"></div>
		<article>
			<section id="main">
				{include file="skin/admin/bread-crumbs.tpl"}
				{include file="skin/message.tpl"}
				{block view=$main}
			</section>

		</article>

		{include file="skin/admin/left-panel.tpl"}
	</section>
	{include file="skin/admin/page-bottom.tpl"}
</div>

{include file="skin/admin/js.tpl}
{include file="skin/admin/js-lng.tpl}

</body>

</html>