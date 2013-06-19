{if $menu && $menu_items}
<div class="menu-slider-wrapper">
	<div id="favorite-products" class="css3 fixMinMaxWidth">
		<a class="prev-image pngfix"></a>
		<a class="next-image pngfix"></a>

		<center><div class="items">
		{foreach from=$menu_items item=menu_item}
		{if $menu_item.menu_item_enabled eq "Y"}
			{capture name="link"}
				{if $menu_item.menu_item_link}
					<a href="{$menu_item.menu_item_link}">
				{else}
					<a href="{link action=$menu_item.url_action base=$menu_item.url_params}">
				{/if}
			{/capture}
			<div class="slide-item">
				<h4>{$smarty.capture.link}{$menu_item.menu_item_title}</a></h4>
				{$smarty.capture.link}
					<img height="120" alt="" src="{img image_id=$menu_item.image_id height="120" height="120"}" />
				</a>
			</div>
		{/if}
		{/foreach}
		</div></center>
	</div>
</div>

{literal}
<script type="text/javascript">
	$(function(){
		$('.menu-slider-wrapper .items').carouFredSel({
			width: '80%',
			padding: [0, 50, 0, 50],
			auto: {
				items: 1
			},
			prev: '.menu-slider-wrapper .prev-image',
			next: '.menu-slider-wrapper .next-image'
		});
	});
</script>
{/literal}


{/if}