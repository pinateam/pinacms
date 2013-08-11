<td>
    <ul class="operation-toolbar">
        <li><a href="javascript:void(0);" class="icon-delete"  sid="{$subscription.subscription_id}" title="{lng lng="delete"}"></a></li>
    </ul>
</td>
<td>
    {if $subscription.user_id eq 0}
        {lng lng="anonymous"}
    {else}
        {$subscription.user}
    {/if}
</td>
<td>
    {$subscription.subscription_email}
</td>
<td>
    {$subscription.subscription_created|format_datetime}
</td>