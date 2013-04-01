
$.fn.ajaxPageEdit = function(successCallBack)
{
	$(this).bind("submit", function() {
		PinaRequest.submit(this, successCallBack);
		return false;
	});
}