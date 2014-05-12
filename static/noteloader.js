
var noteCounter = 0;
var profileID;
var categoryID;
var noteID;

function incrementNoteCounter()
{
	noteCounter++;
}
$(document).ready(function() {

	// http://www.jquery4u.com/snippets/url-parameters-jquery/
	$.get = function(name) {
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

				
 $(window).scroll(function() {
	if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
		console.log(noteCounter);
		$.ajax ({
			url: './get_notes.php',
			data: {'noteCounter': noteCounter, 'profileID': profileID, 'categoryID': categoryID, 'noteID': noteID},
			type: 'post',
			async: false,
			success: function (data) {
			    $( "#notes" ).append(data);
				
				
				//addReadMoreLess();
			}
			
		});
	}
});