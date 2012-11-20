<h4 class="widget-title">{lng lng="unsubscribe_entering_email"}</h2>
<div class="subscriptions">
    <form name="unsubscribe" action="api.php" method="POST">
        <input type="hidden" name="action" value="subscription.unsubscribe" />
        <div class="field">
                <input type="text" value="" class="long-text" id="email" name="email">
                <div class="button-bar">
                        {include file="skin/button.tpl" title="unsubscribe"|lng}
                </div>
        </div>
    </form>
</div>