<h1><span class="section-icon icon-people"></span> {lng lng="subscription_management"}</h1>

<div class="right-narrow-column">


	<fieldset class="operations">
		<h2>{lng lng="actions"}</h2>
		<div class="button-bar">
			<button class="css3 additional button-export" onclick="document.location='api.php?action=subscription.manage.export'">{lng lng="download_as_csv"}</button>
		</div>
	</fieldset>
</div>

<div class="left-wide-column">
	    {module action="subscription.manage.list" wrapper="subscription-list"}
</div>

{literal}
<script type="text/javascript">

$(".subscription-list").manageTable({
	action_list: 'subscription.manage.list',
        api_delete: "subscription.manage.delete",
        object: "subscription"
});

</script>
{/literal}