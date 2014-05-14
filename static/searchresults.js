var msgSet = false;
	
/*
getSearchResults
Searches database for matches and partial matches on every change within the search form.

@param searchString: Current input in the searchfield

*/	
function getSearchResults(searchString)
{
	if (msgSet == false)
	{
		$( ".searchmsg").append("Results:");
		msgSet = true;
	}
	
	if (searchString.length > 0)
	{
		$.ajax ({
			url: './getsearchresults.php',
			data: {'search': searchString},
			type: 'post',
			dataType: "json",
			success: function (data) {						// Username and ID, json encoded
			
				$( "#searchresult" ).empty();
				$.each(data, function(i, item) {				// generate html for hits
					
					var html = "<a href=" + '"' + "profile.php?id=" + data[i].userID + '"' + ">" + 
									"<div class=" + '"' + "hit" + '"' + " id=" + '"' + data[i].userID  + '"'+ ">" + data[i].username + "</div>" + "</a>";
					
					$( "#searchresult" ).append(html);
				})
			},
			error: function(){console.log("failed to connect")}
		});
	}
	
	else // Search box has been used, but is now empty.
	{
		$( "#searchresult" ).empty();
		$( "#searchresult" ).append("Type a username");
	}
}

			