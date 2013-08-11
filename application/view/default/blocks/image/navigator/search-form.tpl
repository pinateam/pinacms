<form name="image-navigator-search-form" action="block.php" method="POST" id="image-navigator-search-form" class="image-navigator-search-form">
	<input type="hidden" name="action" value="image.navigator.list" />
	<span class="right-narrow-column full-row search-text">
		<input type="text" name="substring" id="search-text" value="" style="width: 95%;" />
		<button class="transparent search-button" type="button">
			<img src="{site img="admin/magnifier.png"}" class="small-icon" />
		</button>
		<br /><br />
	</span>
	{block view="image.navigator.filter"}
</form>