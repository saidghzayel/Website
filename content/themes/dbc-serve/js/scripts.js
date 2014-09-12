jQuery(document).ready(function($) {

	$("#select-country.drop-down-menu").click(function () {
		$("#select-country.drop-down-menu ul").toggle();
	});

	$("#sort-missionaries.drop-down-menu").click(function () {
		$("#sort-missionaries.drop-down-menu ul").toggle();
	});
	
	
	//mission conference registration form//
	$('.spouse input').blur(function() {
	    $('input[value="Spouse"] + label').text($('.spouse input').val());
	    if($('.spouse input').val() != "") {
	    	$('input[value="Spouse"]').toggle();
		$('input[value="Spouse"] + label').toggle();
	    }
	});
	
	$('input[value^="Child"]').toggle();
	$('input[value^="Child"] + label').toggle();
	$('input[value="Spouse"]').toggle();
	$('input[value="Spouse"] + label').toggle();
	
	$('input[value="Kids"]').click(function() {
	    $('input[value^="Child"]').toggle();
	    $('input[value^="Child"] + label').toggle();
	});
});
