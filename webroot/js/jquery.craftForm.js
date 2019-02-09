(function($){
	$.craftForm = {
		tokenUrl: null,
		tokenKey: null,
		config: {},

		init: function(_config) {
			$.each(_config, function(key, value) {
				if (value == '') {
					delete _config[key];
				}
			});
			$.craftForm.config = $.extend({
				messageSuccess: '送信しました',
				messageFailed: '送信に失敗しました',
				messageValidationError: '入力内容を確認してください',
				messageDisabled: 'このフォームは無効になっています'
			}, _config);

			$.craftForm.tokenUrl = $.craftForm.config.baseUrl + '/bc_form/ajax_get_token';
			$.craftForm.getToken().then(function(res) {
				$.craftForm.tokenKey = res;
				$('.craft_form_submit').attr('disabled', false);
			});
		},

		getToken: function() {
			var myDefer = $.Deferred();

			$.ajax({
				url: $.craftForm.tokenUrl,
				type: 'GET',
				success: function(result) {
					myDefer.resolve(result);
				},
				failed: function(result) {
					myDefer.reject();
				}
			});

			return myDefer.promise();
		},

		submit: function(formElement, _options) {
			var options = $.extend({
				a: 'eeeee',
			}, _options);

			var submitElement = formElement.find('.craft_form_submit');

			submitElement.attr('disabled', true);

			var param = {};
			$(formElement.serializeArray()).each(function(i, v) {
				param[v.name] = v.value;
			});
			param['data[_Token][key]'] = $.craftForm.tokenKey;

			$.ajax({
				url: formElement.attr('action'),
				type: formElement.attr('method'),
				data: param,
				dataType: 'json',
				success: function(result) {
					formElement.find('.craft_form_error').remove();
					formElement.find('.craft_form_output').text('');

					if (result.response.status === 'success') {
						formElement.find('.craft_form_output').text($.craftForm.config.messageSuccess);
					} else {
						switch (result.response.error) {
							case 'send_limit':
								formElement.find('.craft_form_output').text(result.response.send_limit_errors[0]);
								break;
							case 'validation':
								$.each(result.response.validation_errors, function(key, element) {
									formElement.find('.craft_form_' + key).after('<div class="craft_form_error">'
										+ element[0] + '</div>');
								});
								formElement.find('.craft_form_output').text($.craftForm.config.messageValidationError);
								break;
							case 'send':
								formElement.find('.craft_form_output').text($.craftForm.config.messageFailed);
								break;
							case 'disabled':
								formElement.find('.craft_form_output').text($.craftForm.config.messageDisabled);
								break;
						}
					}
				},
				error: function(result) {
					formElement.find('.craft_form_output').text($.craftForm.config.messageFailed);
				},
				complete: function(xhr, textStatus) {
					$.craftForm.getToken().then(function(res) {
						$.craftForm.tokenKey = res;
						submitElement.attr('disabled', false);
					});
				}
			});
		}
	};
})(jQuery);
