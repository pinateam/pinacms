{if $from gt 0 && $to gt 0}
	<div class="navigator-filter">
		<div class="layout-slider" style="width: 100%; text-align: left;">
			<span style="width:90px;">{lng lng=$name}</span>
			<span style="display: block; float:right; width: 90px; padding: 0 5px;">
				<input id="filter_{$name}" type="slider" name="filter_{$name}" value="{$from};{$to}" />
			</span>
		</div>
	</div>

	{literal}
	<script type="text/javascript">

		$("#filter_{/literal}{$name}{literal}").slider({ 
			from: {/literal}{$from}{literal}, 
			to: {/literal}{$to}{literal}, 
			step: 1, 
			smooth: true,
			format: { format: "##"},
			round: 0,
			dimension: "",
			skin: "plastic",
			callback: function (value) {
				reloadImageNavigatorList();
			}
		});

		function reloadImageNavigatorList() {
			//$("#image-navigator-search-form").submit();

			var filter_width_range = $("#filter_width").val();
			if(filter_width_range == default_filter_width) {
				filter_width = "";
			}
			else
			{
				filter_width = $("#filter_width").val();
			}

			var filter_height_range = $("#filter_height").val();
			if(filter_height_range == default_filter_height) {
				filter_height = "";
			}
			else
			{
				filter_height = $("#filter_height").val();
			}

			var rules = {
				substring: $("#search-text").val(),
				filter_width: filter_width,
				filter_height: filter_height,
				type: $("#type").val()
			}

			$.ajax({
					async: false,
					type: 'post',
					url: 'block.php',
					data: {
							action: 'image.navigator.list',
							rules: rules	
					},
					success: function(html) {
							$(".image-list-wrapper").html(html);
							$(".image-list-wrapper").fadeTo(0, 1);
					},
					dataType: 'html'
			});
		}
	</script>
	{/literal}
{/if}