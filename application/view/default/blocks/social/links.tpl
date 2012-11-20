{if $config.social.facebook || $config.social.twitter}
<div class="widget widget_community">
	<h4 class="widget-title">The Community</h4>
	{if $config.social.facebook}
		<a href="http://facebook.com/{$config.social.facebook}" target="_blank"><img src="{site img="socialIcons/facebook.jpg"}" alt="{lng lng="follow_facebook"}"/></a>
	{/if}
	{if $config.social.twitter}
		<a href="http://twitter.com/{$config.social.twitter}" target="_blank"><img src="{site img="socialIcons/twitter.jpg"}" alt="{lng lng="follow_twitter"}"/></a>
	{/if}
{*<a href="#" target="_blank"><img src="{site img="socialIcons/rss.jpg"}" alt="Subscribe to the RSS feed"/></a>*}
</div>
{/if}