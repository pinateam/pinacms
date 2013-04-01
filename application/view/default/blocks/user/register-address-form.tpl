<fieldset>

	<div class="form-line">
		<div class="form-line-item-3">
			{include file="skin/form-line-input.tpl" required=1 field="address_firstname" label="firstname"|lng fill=$address}
		</div>
		<div class="form-line-item-3">
			{include file="skin/form-line-input.tpl" required=0 field="address_middlename" label="middlename"|lng fill=$address}
		</div>
		<div class="form-line-item-3">
			{include file="skin/form-line-input.tpl" required=1 field="address_lastname" label="lastname"|lng fill=$address}
		</div>
	</div>

	<div class="form-line">
		<div class="form-line-item-2">
			{module action="user.register-address-country-select" wrapper="user-register-address-country-select-wrapper"}
		</div>
		<div class="form-line-item-2">
			{module action="user.register-address-state-select" country_key=$address.address_country_key wrapper="user-register-address-state-select-wrapper"}
		</div>
	</div>


	<div class="form-line">
		<div class="form-line-item-2">
			{include file="skin/form-line-input.tpl" required=1 field="address_city" label="city"|lng fill=$address}
		</div>
		<div class="form-line-item-2">
			{include file="skin/form-line-input.tpl" required=0 field="address_county" label="county"|lng fill=$address}
		</div>
	</div>

	<div class="form-line">
		<div class="form-line-item-3">
			{include file="skin/form-line-input.tpl" required=1 field="address_zip" label="zipcode"|lng fill=$address}
		</div>
		<div class="form-line-item-23">
			{include file="skin/form-line-input.tpl" required=1 field="address_street" label="address_street_house_appartament_office"|lng fill=$address}
		</div>
	</div>


	<div class="form-line">
		<div class="form-line-item-2">
			{include file="skin/form-line-input.tpl" required=1 field="address_phone" label="phone"|lng fill=$address}
		</div>
		<div class="form-line-item-2">
			{include file="skin/form-line-input.tpl" required=1 field="address_email" label="Email" fill=$address}
		</div>
	</div>
                
        {*module action="custom-field.list"*}

</fieldset>

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
			$('.user-register-address-state-select-wrapper').fadeTo(0, 1);
		},
		dataType: 'html'
	});
});

</script>
{/literal}