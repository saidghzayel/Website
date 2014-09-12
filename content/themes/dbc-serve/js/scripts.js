jQuery(document).ready(function($) {

	$("#select-country.drop-down-menu").click(function () {
		$("#select-country.drop-down-menu ul").toggle();
	});

	$("#sort-missionaries.drop-down-menu").click(function () {
		$("#sort-missionaries.drop-down-menu ul").toggle();
	});
	
	
	$('.spouse input').blur(function() {
	    $('input[value="Spouse"] + label').text($('.spouse input').val());
	});
	
	$('input[value^="Child"]').toggle();
	$('input[value^="Child"] + label').toggle();
	
	$('input[value="Children"]').click(function() {
	    $('input[value^="Child"]').toggle();
	    $('input[value^="Child"] + label').toggle();
	});
	
});
