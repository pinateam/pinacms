<h1 class="page-title whereAmI">{lng lng="contact_us"}</h1>
<div class="page page_post narrow alignleft">
	<form class="contactForm" method="post" action="api.php" />
		<input type="hidden" name="action" value="feedback.contactus" />

		<fieldset>
			<div class="alignleft">
				{include file="skin/form-line-input.tpl" required=1 field="name" label="name"|lng size="35" maxlength="40"}
				{include file="skin/form-line-input.tpl" required=1 field="subject" label="subject"|lng size="35" maxlength="40"}
			</div>

			<div class="alignright">
				{include file="skin/form-line-input.tpl" required=1 field="user_email" label="Email" size="35" maxlength="40"}
				{include file="skin/form-line-input.tpl" required=0 field="order_id" label="order_id"|lng size="35" maxlength="40"}
			</div>

			{include file="skin/form-line-textarea.tpl" required=1 field="message" label="message"|lng rows="10" cols="50"}
			{include file="skin/button.tpl" title="send"|lng}
		</fieldset>
	</form>
</div>

{block view="company.address"}