<div id="feedbackAdmin" class="overlay">
{literal}
<script type="text/javascript">
	function productAddReview() {
		var options = { 
			dataType: 'json',
			success: function(obj) {
				if (obj.err) {
					alert(obj.err.split('|').join('\n'));
				} else {
					alert(obj.msg.split('|').join('\n'));
					
					$('.close').click();
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert(errorThrown);
			},
			resetForm: false
		};
		
		$('#admin_question').ajaxSubmit(options);
	}


</script>
{/literal}

<h2>{lng lng="make_review"}</h2>

<p>{lng lng="star_marked_fields_is_necessary"}</p>

	<h5>{lng lng="question_for_admin"}</h5>
	<form id="admin_question" method="post" action="api.php">
	<input type="hidden" name="action" value="feedback.product" />
	<input type="hidden" name="product_id" value="{$product_id}" />

		<fieldset>
			<div class="emailform-col alignleft">
				<label for="askq_yourname">{lng lng="your_name"}</label>
				<input type="text" name="name" id="askq_yourname" size="35" maxlength="40" value="" />
			</div>
			<div class="emailform-col alignright">
				<label for="askq_email">{lng lng="your_email"}</label>
				<input type="text" name="user_email" id="askq_email" size="35" maxlength="40" value="" />
			</div>
			<label for="askq_question">{lng lng="question"}</label>
			<textarea rows="12" cols="60" name="message" id="askq_question"></textarea>
			<input class="formbutton" type="submit" alt="{lng lng="send_question"}" value="{lng lng="ask"}" name="" title="{lng lng="send_question"}" />
		</fieldset>
	</form>
</div>