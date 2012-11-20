{if $states}
{include file="skin/form-line-select.tpl" required=1 name="address_state_key" label="state"|lng fill=$address list=$states}
{else}
{include file="skin/form-line-input.tpl" required=1 field="address_state" label="state"|lng fill=$address}
{/if}