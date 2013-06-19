<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
	{module action="meta.head"}

	<meta http-equiv="Content-Type" content="text/html; charset={$smarty.const.SITE_CHARSET}" />
	{include file="skin/resources.tpl"}
</head>

<body>
	{module action="config.demo-pane"}
	<div id="pg_wrap">
		{include file="skin/page-header.tpl"}

		{block view="user.login-popup"}

		<div id="floatswrap" class="bigftfl clearfix">
			<div class="container clearfix">
				{include file="skin/message.tpl"}
				{block view=$main wrapper=$main|wrapper_class}
			</div><!-- container -->
		</div><!-- floatswrap-->
	</div>

	{include file="skin/page-footer.tpl"}
</body>
</html>