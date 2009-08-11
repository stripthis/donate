$(function() {
	if ($('#txtOtherAmount').val() != '') {
		$('input.otheramount').attr('checked', true);
		$('input.amount').each(function() {
			$(this).attr('checked', false);
		});
	};
});