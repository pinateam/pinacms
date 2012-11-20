<header class="css3">

	<div class="left-block">
			{module action="config.manage.frontend-status" nowrapper=1}
	</div>

	<div class="left-block" style="width:400px;margin-left:8px;">
		{module action="search.manage.quick"}
	</div>

	<div class="left-block" style="width:130px;">
		<menu>
			<ul class="speed-bar clearfix">
				<li class="speed-bar-item"><a href="javascript:UserVoice.showPopupWidget();"" class="css3">{lng lng="forum"}</a></li>
				<li class="speed-bar-item"><a href="http://www.pinacms.com/" class="css3">{lng lng="about_cms"}</a></li>
			</ul>
		</menu>
	</div>

	<div class="right-block">
		{module action="user.manage.page-header" wrapper="auth-data"}
		{*block view="account.manage.page-header" wrapper="account-data"*}
	</div>

</header>