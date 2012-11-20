<div class="admin_question_form">


	
	<form id="ask_a_question" method="post" action="api.php">
	<input type="hidden" name="action" value="feedback.product" />


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
			
			<div class="formbuttonQuestion">
				<input class="formbutton" type="button" alt="{lng lng="send_question"}" value="{lng lng="ask"}" sid="{$product_id}" title="{lng lng="send_question"}" />
			</div>
		</fieldset>
	</form>
</div>




{literal}
<script language="JavaScript">
	$("div.formbuttonQuestion input").click(function(){

		if ($(this).attr("sid") != "0")
		{
			
			var user_email = $('.emailform-col input[name="user_email"]')
			var name = $('.emailform-col input[name="name"]')
			var message = $('.admin_question_form textarea')
				
			$.ajax({
				dataType: 'json',
				url: "api.php?action=feedback.product&product_id="+$(this).attr("sid")+"&name="+name.attr("value")+"&user_email="+user_email.attr("value")+"&message="+message.val(),
				cache: false,
					
				success: function(packet)
				{
					if (packet.e) {
						var errors = [];
			
						for (i = 0; i < packet.e.length; i++)
						{
							errors.push(packet.e[i].m);
						}
			
						if (errors.length > 0) {
							alert(errors.join('\n'));
						}
					}
					else
					{
						$("#ask_a_question").html("Сообщение отправлено");
					}
							
				}
			});

		}
	
	});
</script>
{/literal}