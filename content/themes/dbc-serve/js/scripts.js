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
	$('input[value="I need childcare"]').hide();
	$('input[value="I need childcare"] + label').hide();
	
	$('input[value="I need childcare"]').click(function() {
	    if($('input[value="I need childcare"]').is(":checked")) {
	        $('input[value="I need childcare"]').show();
		$('input[value="I need childcare"] + label').show();
	    }
	});


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
	
	$('.child2 input').blur(function() {
	    $('input[value="Child 2"] + label').text($('.child2 input').val());
	    if($('.child2 input').val() != "") {
	    	$('input[value="Child 2"]').show();
		$('input[value="Child 2"] + label').show();
	    }
	    else {
	    	$('input[value="Child 2"]').hide();
		$('input[value="Child 2"] + label').hide();
	    }
	});
	
	$('.child3 input').blur(function() {
	    $('input[value="Child 3"] + label').text($('.child3 input').val());
	    if($('.child3 input').val() != "") {
	    	$('input[value="Child 3"]').show();
		$('input[value="Child 3"] + label').show();
	    }
	    else {
	    	$('input[value="Child 3"]').hide();
		$('input[value="Child 3"] + label').hide();
	    }
	});
	
	$('.child4 input').blur(function() {
	    $('input[value="Child 4"] + label').text($('.child4 input').val());
	    if($('.child4 input').val() != "") {
	    	$('input[value="Child 4"]').show();
		$('input[value="Child 4"] + label').show();
	    }
	    else {
	    	$('input[value="Child 4"]').hide();
		$('input[value="Child 4"] + label').hide();
	    }
	});
	
	$('.child5 input').blur(function() {
	    $('input[value="Child 5"] + label').text($('.child5 input').val());
	    if($('.child5 input').val() != "") {
	    	$('input[value="Child 5"]').show();
		$('input[value="Child 5"] + label').show();
	    }
	    else {
	    	$('input[value="Child 5"]').hide();
		$('input[value="Child 5"] + label').hide();
	    }
	});
	
	
	$('.child6 input').blur(function() {
	    $('input[value="Child 6"] + label').text($('.child6 input').val());
	    if($('.child6 input').val() != "") {
	    	$('input[value="Child 6"]').show();
		$('input[value="Child 6"] + label').show();
	    }
	    else {
	    	$('input[value="Child 6"]').hide();
		$('input[value="Child 6"] + label').hide();
	    }
	});
});
