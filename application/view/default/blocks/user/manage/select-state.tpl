{if $states}
{include file="skin/admin/form-line-select.tpl" required=1 name="address_state_key" title="" fill=$address list=$states}
{else}
{include file="skin/admin/form-line-input.tpl" required=1 name="address_state" title="" fill=$address}
{/if}