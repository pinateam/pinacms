{*<link rel="stylesheet" media="all" type="text/css" href="{site css="reset.css"}" />
<link rel="stylesheet" media="all" type="text/css" href="{site css="basic.css"}" />
<link rel="stylesheet" media="all" type="text/css" href="{site css="style.css"}" />*}

{combine_resourses file="reset.css" type="css"}
{combine_resourses file="basic.css" type="css"}
{combine_resourses file="style.css" type="css"}


<!--[if IE]>
<link rel="stylesheet" media="all" type="text/css" href="{site css="main_ie.css" browser="IE"}" />
<![endif]-->
<!--[if lte IE 6]>
<link rel="stylesheet" media="all" type="text/css" href="{site css="main_lte_ie6.css" browser="IE6"}" />
<![endif]-->

{*<link rel="stylesheet" media="print" type="text/css" href="{site css="print.css"}" />*}

{*<link rel="stylesheet" media="all" type="text/css" href="{site css="blockui.css"}" />*}
{combine_resourses file="blockui.css" type="css"}
<link rel="shortcut icon" href="{site img="favicon.ico"}" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>

{combine_resourses file="cufon-yui.js" type="js"}
{combine_resourses file="century_gothic_400.font.js" type="js"}
{combine_resourses file="jquery.tools.min.js" type="js"}
{combine_resourses file="jquery.innerfade.js" type="js"}
{combine_resourses file="innerfade_call.js" type="js"}
{combine_resourses file="myjquery.js" type="js"}
{combine_resourses file="mz-packed.js" type="js"}
{combine_resourses file="jcarousellite_1.0.1.min.js" type="js"}
{combine_resourses file="jquery.form.js" type="js"}
{combine_resourses file="admin/jquery.blockUI.js" type="js"}

{combine_resourses file="common.js" type="js"}

{combine_resourses file="pina.skin.js" type="js"}
{combine_resourses file="pina.request.js" type="js"}

{combine_resourses file="page-edit.js" type="js"}
{combine_resourses file="jquery.rating.js" type="js"}
{combine_resourses file="jquery-ui-1.8.18.custom.min.js" type="js"}

{block view="gallery.resources"}
{block view="slide.resources"}

{load_resourses type="css"}
{load_resourses type="js"}

{block view="slide.js"}

{include file="skin/admin/js-lng.tpl"}

<!--[if lt IE 7]>
<script src="http://ie7-js.googlecode.com/svn/version/2.0(beta3)/IE7.js" type="text/javascript"></script>
<![endif]-->

{module action="config.logo"}
{block view="product.css"}

{include file="skin/resources-custom.tpl"}