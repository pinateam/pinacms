
{literal}
<script type="text/javascript">

	$(".button-upload").unbind("click").bind("click", function(){

		var postfix = $(this).attr("data-postfix");
		var few = $(this).attr("data-few");

		var data = {action: 'image.navigator.home'};
		if (postfix) data["postfix"] = postfix;
		if (few) data["few"] = few;

		$.ajax({
			url: 'block.php',
			type: 'post',
			dataType: 'html',
			data: data,
			success: function(html) {
				/*html += '<article class="popup"><br /><button class="css3 additional" onClick="PinaSkin.hideModalMessage(); return false;">Закрыть</button></article>';*/

				/*html = '<div align="center">' + html + '</div>';*/

				$.blockUI({
					theme: true,
					title: '{/literal}{lng lng="image_navigator"}<a href="#" style="display:block;float:right;" class="close">{lng lng="close"}</a>{literal}',
					message: html,
					overlayCSS: {
						backgroundColor: '#fff'
					},
					themedCSS: {
						top: '10%',
						width: '60%',
						left: '20%',
						//height: '70%',
						'min-width': '390px'
					},
					onBlock: function() {

						$(document).off("click", ".image-selector");
						$(document).on("click", ".image-selector", function() {
							var n = $(this).parents(".image-navigator");
							var postfix = $(n).attr("data-postfix");
							var few = $(n).attr("data-few");

							var data = {
								action: 'image.manage.row',
								image_id: $(this).attr("id"),
								postfix: postfix
							};
							if (few) data["few"] = true;

							$.ajax({
								url: 'block.php',
								type: 'post',
								dataType: 'html',
								data: data,
								success: function(result) {
									var base = '.image-main';
									if (postfix) base = '.image-' + postfix;

									$(base + " .image-id").val(data.image_id);
									$(base + " .image-not-exists").hide();
									if (!few)
									{
										$(base + " table.image .image-row").remove();
									}
									$(base + " table.image .button-bar").before(result);
								}
							});

							PinaSkin.hideModalMessage();
						});

						$(".blockUI .close, .ui-widget-overlay").bind("click", function() {
							PinaSkin.hideModalMessage();
							return false;
						});

					}
				});
			}
		});

		return false;
	});


</script>
{/literal}