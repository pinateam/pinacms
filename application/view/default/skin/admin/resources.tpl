	<!-- Place favicon.ico and apple-touch-icon.png in the root of your domain and delete these references -->
	<link rel="shortcut icon" href="{site img="favicon.ico"}">

	<link rel="apple-touch-icon" href="{site img="apple-touch-icon.png"}">

	<!-- CSS: implied media="all" -->
	<link rel="stylesheet" href="{site css="admin.css"}">
	<link rel="stylesheet" href="{site css="admin-jquery-ui-1.8.7.custom.css"}">
	
	<!-- Grab Google CDN's jQuery. fall back to local if necessary -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script>!window.jQuery && document.write('<script src="{site js="admin/jquery.min.js"}"><\/script>')</script>

	<!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
	<script src="{site js="admin/modernizr-1.5.min.js"}"></script>

	<script src="{site js="admin/pina.skin.js"}"></script>
	<script src="{site js="pina.request.js"}"></script>

	<script src="{site js="admin/jquery.row-edit.js"}"></script>
	<script src="{site js="admin/jquery.page-edit.js"}"></script>
	<script src="{site js="admin/jquery.category-tree.js"}"></script>

	{block view="editor.tiny-mce-js"}

	<link rel="stylesheet" href="{site css="jslider/jslider.css"}">
	<link rel="stylesheet" href="{site css="jslider/jslider.blue.css"}">
	<link rel="stylesheet" href="{site css="jslider/jslider.plastic.css"}">
	<link rel="stylesheet" href="{site css="jslider/jslider.round.css"}">
	<link rel="stylesheet" href="{site css="jslider/jslider.round.plastic.css"}">

	<script src="{site js="jslider/jshashtable-2.1_src.js"}"></script>
	<script src="{site js="jslider/jquery.numberformatter-1.2.3.js"}"></script>
	<script src="{site js="jslider/tmpl.js"}"></script>
	<script src="{site js="jslider/jquery.dependClass-0.1.js"}"></script>
	<script src="{site js="jslider/draggable-0.1.js"}"></script>
	<script src="{site js="jslider/jquery.slider.js"}"></script>

{literal}
<script type="text/javascript">
  var uvOptions = {};
  (function() {
    var uv = document.createElement('script'); uv.type = 'text/javascript'; uv.async = true;
    uv.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'widget.uservoice.com/hDiFFlaahyJ4ImrjI29oFQ.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(uv, s);
  })();
</script>
{/literal}