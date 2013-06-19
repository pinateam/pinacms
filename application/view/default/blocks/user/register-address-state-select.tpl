{if $states}
{include file="skin/form-line-select.tpl" required=1 name="address_state_key" icon="delivery" title="state"|lng fill=$address list=$states}
{else}
{include file="skin/form-line-input.tpl" required=1 name="address_state" icon="delivery" title="state"|lng fill=$address}
{/if}