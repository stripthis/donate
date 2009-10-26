$(function() {
	if ($('#txtOtherAmount').val() != '') {
		checkOtherAmount();
	};
	$('#txtOtherAmount').focus(function() {
		checkOtherAmount();
	});

	$('input.amount').click(function() {
		$('#txtOtherAmount').attr('checked', false);
		$('#txtOtherAmount').attr('value', '');
	});

	$('div.date').myDatepick();

	function checkOtherAmount() {
		$('input.otheramount').attr('checked', true);
		$('input.amount').each(function() {
			$(this).attr('checked', false);
		});
	}
});