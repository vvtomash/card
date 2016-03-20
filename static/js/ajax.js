var ajax = function(url, data, successHandler, errorHandler) {
	$.ajax(url, {
		method: 'post',
		dataType: 'json',
		data: data,
		success : function(response) {
			if (successHandler instanceof Function) {
				successHandler(response.data);
			}
		},
		error: function(response, textStatus) {
			if (textStatus == '403') {
				location.href = '/signup';
			}
			if (response.responseJSON && response.responseJSON.errors) {
				for(var i = 0; i < response.responseJSON.errors.length; i++) {
					notifications.trigger("error", response.responseJSON.errors[i]);
				}
			}
			if (errorHandler instanceof Function) {
				errorHandler(response.responseJSON.errors);
			}
		}
	});
}