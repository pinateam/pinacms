<div class="slide-home-wrapper">
	<div class="slide-home-container">
		{foreach from=$slides item=slide name=slides}
			{block view="slide.item" slide=$slide}
			{assign var="cnt" value=$smarty.foreach.slides.total}
		{/foreach}
	</div>
	<div class="slide-home-pager"></div>
</div>