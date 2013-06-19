{include file="skin/form-head.tpl" class="contactForm"}
	<input type="hidden" name="action" value="feedback.contactus" />

	<fieldset>
		<div class="alignleft">
			{include file="skin/form-line-input.tpl" required=1 name="name" title="name"|lng size="35" maxlength="40"}
			{include file="skin/form-line-input.tpl" required=1 name="subject" title="subject"|lng size="35" maxlength="40"}
		</div>

		<div class="alignright">
			{include file="skin/form-line-input.tpl" required=1 name="user_email" title="Email" size="35" maxlength="40"}
			{include file="skin/form-line-input.tpl" required=0 name="order_id" title="order_id"|lng size="35" maxlength="40"}
		</div>

		{include file="skin/form-line-textarea.tpl" required=1 name="message" title="message"|lng rows="10" cols="50"}
		{include file="skin/button.tpl" title="send"|lng}
	</fieldset>
</form>