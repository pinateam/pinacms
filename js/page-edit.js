
function handleRequestResult(elem, data, fnCall)
{
	var packet = eval(data);
	$(elem).find('.error').removeClass('error error-message');

	hideBlockUI(function(){

		if (packet.t)
		{
			location.href = packet.t;
		}

		if (packet.e) {
			for (i = 0; i < packet.e.length; i++)
			{
				if (packet.e[i].s)
				{
					$(elem).find("label[for="+packet.e[i].s+"]").addClass("error error-message");
					$(elem).find("input[name="+packet.e[i].s+"]").addClass("error");
					$(elem).find("select[name="+packet.e[i].s+"]").addClass("error");
					$(elem).find("textarea[name="+packet.e[i].s+"]").addClass("error");

					$(elem).find("label[for="+packet.e[i].s+"]").attr("error-message", packet.e[i].m);
				}
				else
				{
					alert(packet.e[i].m);
				}
			}
		} else {
			if (fnCall)
			{
				fnCall(packet);
			}
		}

	});
}

$.fn.ajaxPageEdit = function(successCallBack)
{
	$(this).find(".error-message").live("click", function() {
		alert($(this).attr("error-message"));
	});

	$(this).bind("submit", function() {

		showBlockUI('Action executed', 'Please wait...');

		var elem = this;
		var params = {
			url: 'api.php',
			dataType: 'json',
			success: function(data) {
				handleRequestResult(elem, data, function(packet) {
					if (successCallBack) successCallBack();
				});
			}
		};
		$(elem).ajaxSubmit(params);
		return false;
	});
}