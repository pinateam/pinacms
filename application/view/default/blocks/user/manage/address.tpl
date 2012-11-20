{if $address.address_id}
	<input type="hidden" name="{$prefix|cat:"address_id"}" value="{$address.address_id}" />
{/if}
{include file="skin/admin/form-line-input.tpl" name=$prefix|cat:"address_firstname" value=$address.address_firstname title="firstname"|lng class="w33"}
{include file="skin/admin/form-line-input.tpl" name=$prefix|cat:"address_middlename" value=$address.address_middlename title="middlename"|lng class="w33"}
{include file="skin/admin/form-line-input.tpl" name=$prefix|cat:"address_lastname" value=$address.address_lastname title="lastname"|lng class="w33"}

<div class="field w50">
	<label for="reg-country">{lng lng="country"} <span class="icon-info" onclick="alert('This is help')"></span></label>
	<select id="reg-country" class="w100">
		<option>Российская Федерация</option>
		<option>Соединённые Штаты Америки</option>
		<option>Очень-очень-очень-очень-очень-очень-очень длинная страна</option>
	</select>
</div>
{include file="skin/admin/form-line-input.tpl" name=$prefix|cat:"address_city" value=$address.address_city title="city"|lng class="w50"}

{include file="skin/admin/form-line-input.tpl" name=$prefix|cat:"address_street" value=$address.address_street title="address"|lng class=""}

{include file="skin/admin/form-line-input.tpl" name=$prefix|cat:"address_county" value=$address.address_county title="county"|lng class="w33"}
{include file="skin/admin/form-line-input.tpl" name=$prefix|cat:"address_zip" value=$address.address_address title="zipcode"|lng class="w33"}
{include file="skin/admin/form-line-input.tpl" name=$prefix|cat:"address_phone" value=$address.address_phone title="phone"|lng class="w33"}
