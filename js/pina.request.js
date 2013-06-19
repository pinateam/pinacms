var PinaRequest = {}

PinaRequest.handle = function(elem, data, fnSuccess)
{
	PinaSkin.hideErrors(elem);

	PinaSkin.hideModalMessage(function(){

		var packet = eval(data);

		if (packet.d && packet.d.message)
		{
			PinaSkin.alert(packet.d.message);
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
					PinaSkin.addError(elem, packet.e[i].s, packet.e[i].m);
				}
				
				errors.push(packet.e[i].m);
			}

			PinaSkin.showErrors(elem);

			if (errors.length > 0) {
				PinaSkin.alert(errors.join('\n'));
			}

		} else {
			if (fnSuccess)
			{
				fnSuccess(packet);
			}
		}
	});
}

PinaRequest.submit = function(elem, fnSuccess)
{
	PinaSkin.showModalMessage(PinaLng.lng("action_executed"), PinaLng.lng("please_wait_"));
	
	var params = {
		url: 'api.php',
		dataType: 'json',
		success: function(data) {
			PinaRequest.handle(elem, data, function(packet) {
				if (fnSuccess) fnSuccess(packet);
			});
		},
		error: function() {
			PinaSkin.hideModalMessage(function(){
				PinaSkin.alert(PinaLng.lng("request_sending_failed"));
			});
		}
	};
	$(elem).ajaxSubmit(params);
}