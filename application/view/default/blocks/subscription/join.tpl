<h4 class="widget-title">{lng lng=subscribe}</h4>
<div class="subscriptions">
	<p>{lng lng="subscribe_to_be_in_touch"}</p>
	<form class="clearfix" action="api.php" method="post">
		<input type="hidden" name="action" value="subscription.join" />
		{include file="skin/form-line-input.tpl" required=1 name="subscription_email" title="enter_email"|lng size="35" maxlength="40"}
		{include file="skin/button.tpl" title="subscribe"|lng}
	</form>
</div>
