<h1><span class="section-icon icon-money"></span> {lng lng="my_account"}</h1>
<div class="right-narrow-column">
	<fieldset class="operations">
			<h2>{lng lng="operations"}</h2>
			<div class="button-bar">
				<button class="css3">{lng lng="make_deposit"}</button>
			</div>
		</fieldset>
</div>

<div class="left-wide-column">
	<p>{lng lng="account_balance"}: {$account.account_balance|default:"0.00"|format_price}</p>
</div>

