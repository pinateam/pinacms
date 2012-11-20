<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset={$smarty.const.SITE_CHARSET}" />
	{include file="skin/resources.tpl"}
</head>
<body>
	<div id="pg_wrap">
		<div id="header" class="clearfix noprint">
			<div class="container clearfix">
				<h2 id="branding"><a href="{link action="home"}" title="Shopping cart software">Pinacart - shopping cart software</a></h2>
			</div>
		</div>
		
		<div id="floatswrap" class="bigftfl clearfix">
			<div class="container clearfix">
				{block view=$main printable=1}
			</div>
		</div>
	</div>

	<script type="text/javascript">
	<!--
		setTimeout('window.print()', 500);
	//-->
	</script>
</body>
</html>