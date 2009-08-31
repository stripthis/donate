jQuery.extend({
	processCakeResponse: function(json) {
		if (!json.error && json.redirect) {
			window.location = json.redirect;
		}

		return json;
	},

	validateCakeForm: function(formId, validationRules) {
		var form = $('#' + formId);
		var validation = { rules: {}, messages: {} };

		if (validationRules) {
			for (var key in validationRules) {
				if (typeof validationRules[key] != 'object' || typeof validationRules[key].length == 'undefined') {
					validationRules[key] = $.makeArray(validationRules[key]);
				}

				$(validationRules[key]).each(function() {
					var rule = this;

					elements = key.split('.');
					if (elements.length == 2) {
					    key = 'data[' + elements[0] + '][' + elements[1] + ']';
					}

					ruleName = rule.rule;
					value = rule.value || true;

					if (typeof validation.rules[key] == 'undefined') {
						validation.rules[key] = {};
					}

					if (typeof validation.messages[key] == 'undefined') {
						validation.messages[key] = {};
					}

					validation.rules[key][ruleName] = value;
					validation.messages[key][ruleName] = rule.message || 'Please specify a valid value';
				});
			}
		}

		var success = form.validate(jQuery.extend({
			debug: false,
			errorPlacement: function(error, element) {
				error.appendTo(element.parent());
			}
		}, validation || {})).form();

		return success;
	},

	processCakeForm: function(formId, validationRules, onSuccess, url, contentId) {
		success = $.validateCakeForm(formId, validationRules);
		if (success) {
			var form = $('#' + formId);
			var inputs = [];
			$(':input', form).each(function() {
				if (this.id.charAt(this.id.length - 1) != '_') {
					inputs.push(this.name + "=" + encodeURIComponent(this.value));
				}
			});
			$.postCake(url || form.attr('action'), inputs.join('&'), onSuccess, contentId);
		}

		return success;
	},

	postCake: function(url, data, onSuccess, contentId) {
		contentId = contentId || 'general_msg';

		if (typeof onSuccess != 'function' && typeof onSuccess != 'object') {
			onSuccess = false;
		}

		var options = {
			url: url,
			dataType: 'json',
			error: function (xhr, desc, exceptionobj) {
				alert('There has been an error: ' + xhr.responseText);
			},
			success : function (json) {
				json.success = (typeof json.success == 'undefined' ? true : json.success);

				if (json.success && typeof onSuccess == 'function') {
					onSuccess(json);
				}

				if (!json.message && json.responseText) {
					json.message = json.responseText;
				}

				if (typeof onSuccess == 'object') {
					if (typeof onSuccess.container != 'undefined') {
						$(onSuccess.container).load(onSuccess.url, function() {
							if (json.message) {
								$.renderCakeMessage(contentId, json.message, json.success);
							}
						});
					} else if (typeof onSuccess.url != 'undefined') {
						window.location.href = onSuccess.url;
					}

					if (typeof onSuccess.callback == 'function') {
						onSuccess.callback(json);
					}
				} else if ($('#' + contentId).length > 0 && json.message) {
					$.renderCakeMessage(contentId, json.message, json.success);
				}

				$.processCakeResponse(json);
			}
		}

		if (data) {
			options = $.extend(options, {
				type: 'POST',
				data: data
			});
		}

		$('#' + contentId).removeClass().html('').show();

		// $.blockUI();
		$.ajax(options);
	},

	renderCakeMessage: function (containerId, message, slideUp) {
		$('#' + containerId)
			.html(message)
			.animate({opacity: 1.0}, 3000);
	}
});