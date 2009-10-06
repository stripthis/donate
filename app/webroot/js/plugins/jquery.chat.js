(function($) {
	var opts = {};
	var clearTextbox = false;

	$.fn.chat = function(options) {
		opts = $.extend({}, $.fn.chat.defaults, options);

		return this.each(function() {
			var $this = $(this);
			init($this);
			update($this);
			setInterval(function() {
				update($this);
			}, opts.interval);

			$(this).find('form').submit(function() {
				post($(this));
				return false
			});
		});
	};

	function init($obj) {
		$message = $obj.find("textarea[name='data[Chat][message]']");
		$message	
			.bind('keydown', 'return', function() {
				post($obj.find('form'));
			});
	}

	function update($obj) {
		$.ajax({
			url: opts.update + '/' + $obj.attr('name'),
			success: function(ret) {
				$obj.find('.chat_window').html(ret);
				if (clearTextbox) {
					$obj.find("textarea[name='data[Chat][message]']").val('');
					clearTextbox = false;
					$('.chat_window', $obj.parents()).scrollTo(150, 800);
				};
			}
		});
	};

	function post($obj) {
		var $message = $obj.find("textarea[name='data[Chat][message]']");
		var $submit = $obj.find("input[type='submit']");

		if ($.trim($message.val()) == '') {
			return;
		}

		var form = $obj.serialize();
		$message.attr('disabled', true);
		$submit.attr('disabled', true);  

		$.ajax({
			type: 'POST',
			url: $obj.attr('action'),
			data: form,
			success: function() {
				clearTextbox = true;
			},
			complete: function() {
				$message.attr('disabled', false);
				$submit.attr('disabled', false);
			}
		});
	};

	$.fn.chat.defaults = {
		update: '/chat/update',
		interval: 5000
	};
})(jQuery);