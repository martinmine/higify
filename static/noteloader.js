
var noteCounter = 0;

function incrementNoteCounter()
{
	noteCounter++;
}
				
 $(window).scroll(function() {
	if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
		console.log(noteCounter);
		$.ajax ({
			url: './get_notes.php',
			data: {'noteCounter': noteCounter},
			type: 'post',
			async: false,
			success: function (data) {
			    $( "#notes" ).append(data);
			}
		})	;
	}
});