$(document).ready(function() {

	// http://www.jquery4u.com/snippets/url-parameters-jquery/
	$.get = function(name) {
		var res = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
		if (res == null)	return null;
		else 				return res[1] || 0;
	}
	
	if ($.get('nid') != null)
	{
		var notebox = '#'+$.get('nid');
		
		$(function() {
			$(notebox).effect("highlight", 3000);
		});
	}
});


// This function is called on each note on loading, this way the feature
//		also applies on new notes loaded by scrolling:
function addReadMoreLess(noteID) {
		
	var content = '#content' + noteID;
	var height = $(content).height();
	var id = '#readMore' + noteID;
	
	if ( height > 200 ) 
	{
		$(id).show();
		$(content).css({
			height : 200,
			overflow: 'hidden'
		});
	}
	else
	{
		$(id).hide();
	}
}

//	Expands the content of a note to its auto height by changing css.
function readMore(noteID)
{
	var readMore = '#readMore' + noteID;
	var content = '#content' + noteID;
	var readLess = 'javascript:readLess(' + noteID + ')';
	
	$(readMore).html('Read less');
	
	//	Saving current and the auto height. Have to know these to animate it:
	var curHeight = $(content).height();
	var autoHeight = $(content).css('height','auto').height();
	
	// set height back to current before animateing it to the desired height.
	$(content).height(curHeight).animate({height: autoHeight}, 1000);
	
	$(readMore).attr("href", readLess);
}

//	Contracts the content to its default.
function readLess(noteID)
{
	var readLess = '#readMore' + noteID;
	var content = '#content' + noteID;
	var readMore = 'javascript:readMore(' + noteID + ')';
	
	$(readLess).html('Read more');
	$(content).animate({height: 200}, "slow", function() {
		$(this).css("overflow", "hidden");
	});
	
	$(readLess).attr("href", readMore);
}

function onNoteDelete(noteID) 
{
	var standard = '#standard' + noteID;
	var onDelete = '#onDelete' + noteID;
	
	$(standard).slideUp("fast");
	$(onDelete).slideDown("fast");
}
	
function onNoteDeleteCancel(noteID) 
{
	var standard = '#standard' + noteID;
	var onDelete = '#onDelete' + noteID;
	
	$(standard).slideDown("fast");
	$(onDelete).slideUp("fast");
}

function onNoteDeleteConfirm(noteID)
{
	var noteContainer = '#' + noteID;
	var urll = 'mainpage.php?noteID=' + noteID + '&changeType=1';

	$.ajax({
		url: urll,
		beforeSend: function(note) {
			$(noteContainer).effect("blind", 1000);
		}
	});
}

function onReport(noteID) 
{
	//	Reporting note by ID with GET to report_note.php:
	var urll = 'report_note.php?id=' + noteID;
	
	//	Unique id of the feedback dialogue to show message: 
	var onReport = '#onReport' + noteID;
	
	//	Unique id to the report link to change it to 'reported':
	var reportID = '#report' + noteID;
	
	//	If it's not been reported before (can refresh and report again)
	//	Ajax used to update database:
	if ($(reportID).text() == 'Report') {
	
		$.ajax({
			url: urll,
			
			//	Fade in dialogue, with the ability to 
			//	close it by clicking outside of it:
			success: function() {
				$(onReport).fadeIn("fast", function() {
					$('body').click(function() {
						$(onReport).fadeOut("fast");
						$(reportID).text("Reported");
					});
				});
		}});
	}
}

//	Fade out on the dialogue by clicking a button:
function onReportContinue(noteID)
{
	var onContinue = '#onReport' + noteID;
	$(onContinue).fadeOut("slow");
}