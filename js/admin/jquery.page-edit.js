$.fn.managePage = function(options)
{
	var elem = this;

	$(".button-cancel").bind("click", function(){
		history.back();
		return false;
	});

	$(".button-save, .button-add, .button-edit").bind("click", function() {
		$(elem).doSave(options);
		return false;
	});

	if (options && options["api_delete"])
	{
		$(".button-delete").bind("click", function() {
			var message = $(this).attr("data-message");
			if (!message) message = PinaLng.lng("are_you_sure_to_delete");

			if (!confirm(message)) {
				return;
			}

			var id = $(this).attr("sid");
			if (!id) alert("Please specify SID");
			
			PinaSkin.showModalMessage(PinaLng.lng("action_executed"), PinaLng.lng("please_wait_"));

			var object_id = options["object"] + '_id';
			var params = {};
			params["action"] = options["api_delete"];
			params[object_id] = id;

			$.ajax({
				type: 'post',
				url: 'api.php',
				data: params,
				success: function(result) {
					PinaSkin.hideModalMessage(function(){

						if (result.e) {
							var errors = []
							for (i = 0; i < result.e.length; i++)
							{
								errors.push(result.e[i].m);
							}

							if (errors.length > 0) {
								alert(errors.join('\n'));
							}
						} else {
							if(result.d && result.d.message != "") {
							    alert(result.d.message);
							} else {
							    alert(PinaLng.lng("information_has_been_deleted"));
							}

							if(typeof result.t !== "undefined") {
							    window.location.href = result.t;
							}else {
							    history.back();
							}
						}
					});
				},
				error: function() {
					alert(PinaLng.lng("request_sending_failed"));
				},
				dataType: 'json'
			});
			return false;
		});
	}

	$(elem).bind("submit", function() {
		return false;
	});
}

$.fn.doSave = function(options)
{
	if ($(".mceEditor").attr("id"))
	{
		for (edId in tinyMCE.editors)
			tinyMCE.editors[edId].save();
	}

	PinaRequest.submit(this, function(packet){
		PinaSkin.alert(PinaLng.lng("information_has_been_saved"));
		if (options["oncall"])
		{
			var fnCall = options["oncall"];
			fnCall(packet);
		}
	});
}