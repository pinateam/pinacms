<h1><span class="section-icon icon-book"></span>{lng lng="add"}</h1>
<form action="api.php" method="post" id="add_gallery">
	<input type="hidden" name="action" value="gallery.manage.add" />

	<fieldset class="operations">
		<div class="right-narrow-column">
			<h2>{lng lng="actions"}</h2>
			<div class="button-bar">
				<button class="css3 button-add">{lng lng="add"}</button>
				<button class="css3 additional button-cancel">{lng lng="cancel"}</button>
			</div>
		</div>

		<div class="left-wide-column">
			{block view="gallery.manage.form"}
		</div>
	</fieldset>
</form>

