var msgSet = false;
	
			
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
			success: function (data) {
			
				$( "#searchresult" ).empty();
				$.each(data, function(i, item) {
					console.log(data[i]);
					
					var html = "<a href=" + '"' + "profile.php?id=" + data[i].userID + '"' + ">" + 
									 "<div class=" + '"' + "hit" + '"' + " id=" + '"' + data[i].userID  + '"'+ ">" + data[i].username + "</div>" + "</a>";
					
					$( "#searchresult" ).append(html);
				})
			},
			error: function(){console.log("fail")}
		});
	}
	
	else 
	{
		$( "#searchresult" ).empty();
		$( "#searchresult" ).append("Type a username");
	}
}

			