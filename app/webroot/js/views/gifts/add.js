$(function() {
	if ($('#txtOtherAmount').val() != '') {
		checkOtherAmount();
	};
	$('#txtOtherAmount').focus(function() {
		checkOtherAmount();
	})

	function checkOtherAmount() {
		$('input.otheramount').attr('checked', true);
		$('input.amount').each(function() {
			$(this).attr('checked', false);
		});
	}
});