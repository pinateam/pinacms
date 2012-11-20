<h1><span class="section-icon icon-asterix"></span> {lng lng="dashboard"}</h1>
<fieldset>
	<h2>{lng lng="quick_pane"}</h2>
	<div class="field  help-section w50">
		<h3><a href="{link action="post.manage.add"}">{lng lng="add_post"}</a></h3>
		<a class="section-icon icon-book" href="{link action="post.manage.add"}"></a>
		<div>
			{lng lng="add_post_explanation"}
		</div>
	</div>
	{block view="event.manage.dashboard-quick"}
</fieldset>

{block view="statistic.manage.dashboard"}