function onNoteDelete(noteID) {
	var standard = '#standard' + noteID;
	var onDelete = '#onDelete' + noteID;
	
	$(standard).slideUp("slow");
	$(onDelete).slideDown("slow");
}
	
function onNoteDeleteCancel(noteID) {
	var standard = '#standard' + noteID;
	var onDelete = '#onDelete' + noteID;
	
	$(standard).slideDown("slow");
	$(onDelete).slideUp("slow");
}