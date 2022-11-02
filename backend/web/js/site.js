var body = $('body');
var content = $('#content');
var toggle = $('#toggle');
var fullView = false;
var smallWindow = false;

if($(window).width() < 900) {
	body.addClass('full-view');
	body.addClass('pushed');
	body.addClass('no-animation');
	
	fullView = true;
	smallWindow = true;
}

$(window).resize(function() {
	body.removeClass('no-animation');
	if($(window).width() < 900) {
		body.addClass('full-view');
		body.addClass('pushed');
		
		fullView = true;
		smallWindow = true;
	} else {
		body.removeClass('full-view');
		body.removeClass('pushed');
		
		fullView = false; 
		smallWindow = false;
	}
});

content.on('click touchend', function(event) {
	body.removeClass('no-animation');
	if(smallWindow) { 
		body.addClass('full-view');
		fullView = true; 
	}
});

function change() {
	body.removeClass('no-animation');
	if (fullView) {
		body.removeClass('full-view');
		fullView = false; 
	}
	else {
		body.addClass('full-view');
		fullView = true;
	}
}

toggle.on('click', function(event) {
	change();
});

$(document).ready(function() {
	// toggle sub area
	$("button.show-sub-area").click(function() {
		$("#" + $(this).attr("for")).toggle();
	});
	
	// show selected details from type
	$("#type-details-" + $("#field-type").val()).removeClass("hidden");
});

$(function() {
	$('#new-group-button').click(function() {
		$('#new-group').modal('show')
			.find('#new-group-content')
			.load($(this).attr('value'));
	});
	
	$('#edit-group-button').click(function() {
		$('#edit-group').modal('show')
			.find('#edit-group-content')
			.load($(this).attr('value'));
	});
	
	// show details from selected type
	$('#field-type').on('change', function() {
		$('.type-details').addClass("hidden");
		$('#type-details-' + this.value).removeClass("hidden");
	});
	
	// autocomplete name from label
	$("input[name=label]").on('keyup', function() {
		var label = $(this);
		var name = $("input[name=name]");
		
		name.val(neutralizeString(label.val()));
	})
});

function neutralizeString(string) {
	string = string.toLowerCase();
	string = string.replace(" ", "-");
	string = string.replace(/[^a-z0-9-]/gi, "");
	return string;
}