var PinaSkin = {}

PinaSkin.alert = function(message)
{
	alert(message);
}

PinaSkin.hideErrors = function(elem)
{
	$(elem).find('.error').removeClass('error error-message');
}

PinaSkin.addError = function(elem, subject, message)
{
	$(elem).find("label[for="+subject+"]").addClass("error error-message");
	$(elem).find("input[name="+subject+"]").addClass("error");
	$(elem).find("select[name="+subject+"]").addClass("error");
	$(elem).find("textarea[name="+subject+"]").addClass("error");

	$(elem).find("label[for="+subject+"]").attr("error-message", message);
}

PinaSkin.showErrors = function(elem)
{
	$(elem).find(".error-message").bind("click", function() {
		PinaSkin.alert($(this).attr("error-message"));
	});
}

PinaSkin.showModalMessage = function(title, message) {
	$.blockUI({
		theme: true,
		title: title,
		message: message,
		overlayCSS: {
			backgroundColor: '#fff'
		}
	});
}

PinaSkin.hideModalMessage = function(callback) {
	$.unblockUI({
		onUnblock: function() {
			if (callback) {
				callback.call();
			}
		}
	});
}