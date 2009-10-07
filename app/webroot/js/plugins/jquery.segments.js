$(function() {
	$('.segments input[type=submit]').click(function() {
		$form = $(this).parents('form');
		$form.attr('action', '/admin/segments/add');
		$form.submit();
	});
});