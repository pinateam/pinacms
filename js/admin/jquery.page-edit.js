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
			
			showBlockUI(PinaLng.lng("action_executed"), PinaLng.lng("please_wait_"));

			var object_id = options["object"] + '_id';
			var params = {};
			params["action"] = options["api_delete"];
			params[object_id] = id;

			$.ajax({
				type: 'post',
				url: 'api.php',
				data: params,
				success: function(result) {
					hideBlockUI(function(){

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
							}else{
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

$.fn.handleRequestResult = function(data, fnCall)
{
	var elem = this;
	hideBlockUI(function(){

		var packet = eval(data);
		$('.error').addClass('hidden');

		if (packet.d && packet.d.message)
		{
			alert(packet.d.message);
		}

		if (packet.t)
		{
			location.href = packet.t;
		}

		if (packet.e) {
			var errors = [];
			
			for (i = 0; i < packet.e.length; i++)
			{
				if (packet.e[i].s)
				{
					//elem.find("label[for="+packet.e[i].s+"] span").after('<span class="error">'+packet.e[i].m+'</span>');
					elem.find("label[for="+packet.e[i].s+"]").append('<span class="error">'+packet.e[i].m+'</span>');
				}
				
				errors.push(packet.e[i].m);
			}
			
			if (errors.length > 0) {
				alert(errors.join('\n'));
			}
		} else {
			if (fnCall)
			{
				fnCall(packet);
			}
		}
	});
}

$.fn.doSave = function(options)
{
	showBlockUI(PinaLng.lng("action_executed"), PinaLng.lng("please_wait_"));

	var elem = this;

	var params = {
		url: 'api.php',
		dataType: 'json',
		success: function(data) {
			$(elem).handleRequestResult(data, function(packet) {
				alert(PinaLng.lng("information_has_been_saved"));
				if (options["oncall"])
				{
					var fnCall = options["oncall"];
					fnCall(packet);
				}
			});
		},
		error: function() {
			hideBlockUI(function(){
				alert(PinaLng.lng("request_sending_failed"));
			});
		}
	};

	if ($(".mceEditor").attr("id"))
	{
		for (edId in tinyMCE.editors)
			tinyMCE.editors[edId].save();
	}
	

	$(elem).ajaxSubmit(params);
}