{literal}

//post_params:
//button_placeholder_id: "spanUploadImgMainBtn",
//upload_error_handler
//upload_progress_handler

var swfuSettingsDef = {
	flash_url: "{/literal}{site lib="swfupload/swfupload.swf"}{literal}",
	upload_url: "api.php",

	default_settings: {
		postfix: '',
		few: false
	},

	post_params: {
		action: 'image.manage.upload',
		force_ajax: true,
		sssid: '{/literal}{$smarty.cookies.PHPSESSID}{literal}'
	},

	file_types: "*.jpg;*.jpeg;*.png;*.gif",
	file_types_description: "{/literal}{lng lng="images"}{literal}",
	file_upload_limit: 1,
	file_queue_limit: 1,
	file_size_limit: '{/literal}{$swfuploadMaxFilesize}{literal}',
	debug: false,

	button_width: "80",
	button_height: "29",
	button_cursor: SWFUpload.CURSOR.HAND,
	button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
	button_text: '<span class="swfupload-button">{/literal}{lng lng="upload"}{literal}</span>',
	button_text_style: '.swfupload-button {color: #444444; font-weight: bold; font-size: 14px;}',
	button_text_left_padding: 12,
	button_text_top_padding: 5,

	file_dialog_start_handler: function(){
		this.setButtonDisabled(true);
	},

	file_queue_error_handler: function(file, errorCode, message){
		if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
			alert('{/literal}{lng lng="error_please_select_only_one_file"}{literal}');
		} else if (errorCode === SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE) {
			alert('{/literal}{lng lng="error_choosed_files_has_zero_bytes"}{literal}');
		} else {
			alert('{/literal}{lng lng="error"}{literal}: ' + message);
		}
	},

	file_dialog_complete_handler: function(numFilesSelected, numFilesQueued){
		this.setButtonDisabled(false);

		if (numFilesSelected == 1 && numFilesQueued == 1) {
			this.startUpload();
			this.setButtonDisabled(true);
		}
	},

	upload_complete_handler: function(file){
		this.setButtonDisabled(false);
	},

	upload_error_handler: function(file, errorCode, message){
		$(this.customSettings.progressTarget).text('');
		alert('{/literal}{lng lng="error"}{literal}: ' + message);
	},

	upload_progress_handler: function(file, completed, total){
		$(this.customSettings.progressTarget).text('{/literal}{lng lng="uploading"}{literal}...' + intval(completed / total * 100, 10) + '%');
	}
};

var swfuUploadHandlerDef = function(file, serverData){
	result = $.parseJSON(serverData);
	if (result.e) {
		$(this.customSettings.progressTarget).text('');
		var errors = []
		for (i = 0; i < result.e.length; i++)
		{
			errors.push(result.e[i].m);
		}

		if (errors.length > 0) {
			alert(errors.join('\n'));
		}
	} else {
		var settings = $.extend(this.settings.default_settings, this.settings.customSettings);
		var data = {
			action: 'image.manage.row',
			image_id: result.d.image_id,
			postfix: settings.postfix
		};
		if (settings.few) data["few"] = true;
		$.ajax({
			url: 'block.php',
			type: 'post',
			dataType: 'html',
			data: data,
			success: function(result) {
				$(settings.progressTarget).text('');

				var base = '.image-main';
				if (settings.postfix) base = '.image-' + settings.postfix;

				$(base + " .image-id").val(data.image_id);
				$(base + " .image-not-exists").hide();
				if (!settings.few)
				{
					$(base + " table.image .image-row").remove();
				}
				$(base + " table.image .button-bar").before(result);
			}
		});
	}

	var stats = this.getStats();
	stats.successful_uploads = 0;
	this.setStats(stats);
};

{/literal}