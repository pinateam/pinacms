{literal}
<script type="text/javascript">

$(".user-register-address-country-select-wrapper select").bind("change", function() {
	$('.user-register-address-state-select-wrapper').fadeTo(0, 0.5);
	$.ajax({
		async: false,
		type: 'post',
		url: 'block.php',
		data: {action: 'user.register-address-state-select', country_key: $(this).val(), value: '{/literal}{$address.address_state_key}{literal}'},
		success: function(html){
			$(".user-register-address-state-select-wrapper").html(html);
			$(".user-register-address-wrapper select[name=address_state_key], .user-register-address-wrapper input[name=address_state]").change(function(){
				$('.order-shipping-methods-wrapper').trigger('address-changed');
			});
			$('.user-register-address-state-select-wrapper').fadeTo(0, 1);
		},
		dataType: 'html'
	});
});

</script>
{/literal}