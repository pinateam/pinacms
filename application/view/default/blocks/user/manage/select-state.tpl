{if $states}
{include file="skin/form-line-select.tpl" required=1 name="address_state_key" fill=$address list=$states}
{else}
{include file="skin/form-line-input.tpl" required=1 field="address_state" fill=$address}
{/if}