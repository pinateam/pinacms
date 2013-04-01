var PinaSkin = {}

PinaSkin.alert = function(message)
{
	alert(message);
}

PinaSkin.hideErrors = function(elem)
{
	$('.error').addClass('hidden');
}

PinaSkin.addError = function(elem, subject, message)
{
	elem.find("label[for="+subject+"]").append('<span class="error">'+message+'</span>');
}

PinaSkin.showErrors = function(elem)
{

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