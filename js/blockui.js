function showBlockUI(title, message) {
	$.blockUI({
		theme: true,
		title: title,
		message: message,
		overlayCSS: {
			backgroundColor: '#fff'
		}
	});
}

function hideBlockUI(callback) {
	$.unblockUI({
		onUnblock: function() {
			if (callback) {
				callback.call();
			}
		}
	});
}