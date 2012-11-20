<table id="subscription_sort_ids" class="w100 szc-dnd" cellspacing="0">
    <col width="60">
    <col>
    <col>
    <col>
    <thead>
        <tr>
            <th>{lng lng="act_"}</th>
            <th>
                {lng lng="user"}
            </th>
            <th>
                E-mail
            </th>
            <th>
                {lng lng="subscribed"}
            </th>
        </tr>
    </thead>
    <tbody>
	{if $subscriptions}
        {foreach from=$subscriptions item=subscription}
        <tr class="subscription-{$subscription.subscription_id}" id="{$subscription.subscription_id}">
            {block view="subscription.manage.row" subscription=$subscription}
        </tr>
        {/foreach}
	{else}
		<tr><td colspan="4">
		<center>{lng lng="not_found"}</center>
		</td></tr>
	{/if}
    </tbody>
</table>