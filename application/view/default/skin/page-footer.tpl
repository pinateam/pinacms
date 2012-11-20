
	<div id="footer" class="bigft clearfix noprint">
		<div class="container clearfix">
			<div class="footer_box">
				<div class="footer_inner_box clearfix">
					{module action="menu.widget" menu_key="help"}
				</div><!-- footer_inner_box -->
			</div><!-- footer_box -->

			<div class="footer_box middle">
				<div class="footer_inner_box clearfix">
					{module action="menu.widget" menu_key="about_us"}
				</div><!-- footer_inner_box -->
			</div><!-- footer_box -->

			<div class="footer_box">
				<div class="footer_inner_box clearfix">
					{block view="social.links"}
				</div><!-- footer_inner_box -->
			</div><!-- footer_box -->

			<p class="footer_notes">
				<span class="copyright">&copy; 2011. <a href="http://dobrosite.ru/">Dobrosite ltd</a>
				{block view="feedback.link"}</span>
				<span>Powered by <a href="http://www.pinacms.com">PinaCMS - software for creating a SaaS platform</a></span>
			</p>

			<p>&nbsp;</p>

			{include file="skin/counters.tpl"}

		</div><!-- container -->
	</div><!-- end footer -->