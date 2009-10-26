$(function() {
	$.fn.myDatepick = function(options) {
		defaults = {
			showOn: 'button',
			buttonImageOnly: true,
			buttonImage: 'js/datepicker/calendar-green.gif',
			yearRange: 'select'
		};

		var opts = $.extend({}, defaults, options);

		this.each(function() {
			var self = this;
			if (opts.yearRange == 'select') {
				var years = [];
				var $options = $('select[id*=Year] option', self);
				$options.each(function(i) {
					var val = $(this).attr('value');
					if (val != '') {
						years.push(val);
					}
				});

				years = years.sort();
				opts.yearRange = years[0] + ':' + years[years.length - 1];
			}

			$('input[type=hidden]', $(self))
				.datepick(opts)
				.change(function() {
					var dt = $(this).val();
					var dtArray = Array();
					dtArray = dt.split('/');

					$('select:eq(0)', self).val(dtArray[1]);
					$('select:eq(1)', self).val(dtArray[0]);
					$('select:eq(2)', self).val(dtArray[2]);
				});
		});
	}
});