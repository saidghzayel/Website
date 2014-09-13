jQuery(document).ready(function($) {

	$("#select-country.drop-down-menu").click(function () {
		$("#select-country.drop-down-menu ul").toggle();
	});

	$("#sort-missionaries.drop-down-menu").click(function () {
		$("#sort-missionaries.drop-down-menu ul").toggle();
	});
	
	
	//mission conference registration form//
	$('input[value^="Child"]').hide();
	$('input[value^="Child"] + label').hide();
	$('input[value="Spouse"]').hide();
	$('input[value="Spouse"] + label').hide();
	
	$('.spouse input').blur(function() {
	    $('input[value="Spouse"] + label').text($('.spouse input').val());
	    if($('.spouse input').val() != "") {
	    	$('input[value="Spouse"]').show();
		$('input[value="Spouse"] + label').show();
	    }
	    else {
	    	$('input[value="Spouse"]').hide();
		$('input[value="Spouse"] + label').hide();
	    }
	});
	
	
	$('.child1 input').blur(function() {
	    $('input[value="Child 1"] + label').text($('.child1 input').val());
	    if($('.child1 input').val() != "") {
	    	$('input[value="Child 1"]').show();
		$('input[value="Child 1"] + label').show();
	    }
	    else {
	    	$('input[value="Child 1"]').hide();
		$('input[value="Child 1"] + label').hide();
	    }
	});
});
