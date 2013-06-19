{literal}
<script type="text/javascript">
	$(function(){
		$('.slide-home-wrapper .slide-home-container').carouFredSel({
			items: 1,
			scroll: {
				fx: 'crossfade'
			},
			auto: {
				timeoutDuration: 5000,
				duration: 300
			},
			pagination: {
				container: '.slide-home-wrapper .slide-home-pager',
				duration: 300
			}
		});
	});
</script>
{/literal}

