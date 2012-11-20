{literal}

//post_params:
//button_placeholder_id: "spanUploadImgMainBtn",
//upload_error_handler
//upload_progress_handler

var swfuSettingsDef = {
	flash_url: "{/literal}{site lib="swfupload/swfupload.swf"}{literal}",
	upload_url: "api.php",

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
	button_text_style: '.swfupload-button {color: #96194A; font-weight: bold; font-size: 14px;}',
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
	var ret = serverData.split('|');
	if (ret[0] == 'OK') {
		$(this.customSettings.imageTarget).attr('src', ret[1]);
		$(this.customSettings.notExistsTarget).addClass('hidden');
		$(this.customSettings.existsTarget).removeClass('hidden');
		$(this.customSettings.progressTarget).text('');

	} else if (serverData != '') {
		$(this.customSettings.progressTarget).text('');
		alert('{/literal}{lng lng="error"}{literal}: ' + serverData);
	} else {
		$(this.customSettings.progressTarget).text('');
		alert('{/literal}{lng lng="unknown_error"}{literal}');
	}

	var stats = this.getStats();
	stats.successful_uploads = 0;
	this.setStats(stats);
};

{/literal}