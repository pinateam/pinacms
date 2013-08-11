<fieldset>

	<div class="form-line">
		<div class="form-line-item-3">
			{include file="skin/form-line-input.tpl" required=1 name="address_firstname" title="firstname"|lng fill=$address}
		</div>
		<div class="form-line-item-3">
			{include file="skin/form-line-input.tpl" required=0 name="address_middlename" title="middlename"|lng fill=$address}
		</div>
		<div class="form-line-item-3">
			{include file="skin/form-line-input.tpl" required=1 name="address_lastname" title="lastname"|lng fill=$address}
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
			{include file="skin/form-line-input.tpl" required=1 name="address_city" title="city"|lng fill=$address}
		</div>
		<div class="form-line-item-2">
			{include file="skin/form-line-input.tpl" required=0 name="address_county" title="county"|lng fill=$address}
		</div>
	</div>

	<div class="form-line">
		<div class="form-line-item-3">
			{include file="skin/form-line-input.tpl" required=1 name="address_zip" title="zipcode"|lng fill=$address}
		</div>
		<div class="form-line-item-23">
			{include file="skin/form-line-input.tpl" required=1 name="address_street" title="address_street_house_appartament_office"|lng fill=$address}
		</div>
	</div>


	<div class="form-line">
		<div class="form-line-item-2">
			{include file="skin/form-line-input.tpl" required=1 name="address_phone" title="phone"|lng fill=$address}
		</div>
		<div class="form-line-item-2">
			{include file="skin/form-line-input.tpl" required=1 name="address_email" title="Email" fill=$address}
		</div>
	</div>
                
        {*module action="custom-field.list"*}

</fieldset>

{block view="user.register-address-form-js"}