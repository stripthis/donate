function initStateDropdown() {
	checkSelectedCountry();
	$('#UserCountryId').change(function() {
		checkSelectedCountry();
	});
}

function checkSelectedCountry() {
	var $country = $('#UserCountryId'), $state = $('#UserStateId');

	var current = $country.val();
	var currentState = $('.state_id').text();

	$('option', $state).remove();
	$.getJSON('/states/by_country/' + current + '.json', function(data) {
		$.each(data, function(i, state) {
			$('<option/>')
				.attr('value', state.State.id)
				.text(state.State.name)
				.appendTo($state);
		});
		$('option[value='+ currentState +']', $state).attr('selected', 'selected');
	});
}