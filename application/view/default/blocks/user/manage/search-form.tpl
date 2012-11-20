<form action="api.php" method="POST">
	<input type="hidden" name="action" value="user.manage.search" />
		<ul>
			<li class="w100 wide-label">
				<label for="search-text">{lng lng="search_words"}:</label>
				<span class="full-row search-text">
					<input type="text" name="substring" id="search-text" value="{$search_rules.substring}" />
					<button class="transparent search-button" type="button">
						<img src="{site img="admin/magnifier.png"}" class="small-icon" />
					</button>
				</span>
			</li>
		</ul>
	</form>