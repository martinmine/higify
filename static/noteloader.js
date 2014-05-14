
/*
	incrementNoteCounter
	
	Increments the global noteCounter.
	Executed when a note is loaded.
*/
function incrementNoteCounter()
{
	noteCounter++;
}

var noteCounter = 0;
var profileID;
var categoryID;
var noteID;


/*
	Retrieves pagetype
*/
$(document).ready(function() {

	// http://www.jquery4u.com/snippets/url-parameters-jquery/
	$.get = function(name) {						// Retrieves info from url
		var res = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
		if (res == null)	return null;
		else 				return res[1] || 0;
	}
	
	if ($.get('id') != null)
	{
		profileID = $.get('id');
		console.log(profileID);
	}
	
	if ($.get('cat') != null)
	{
		categoryID = $.get('cat');
		console.log(categoryID);
	}
	
	if ($.get('nid') != null)
	{
		noteID = $.get('nid');
		console.log(noteID);
	}
});

/*
	Loading notes on scroll
*/
 $(window).scroll(function() {
	if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
		console.log(noteCounter);
		$.ajax ({
			url: './get_notes.php',
			data: {'noteCounter': noteCounter, 'profileID': profileID, 'categoryID': categoryID, 'noteID': noteID},
			type: 'post',
			async: false,
			success: function (data) {		// Contains three notes as HTML
			    $( "#notes" ).append(data);	// Appends html
			},
			error: function(){console.log("failed to load notes");}
		});
	}
});