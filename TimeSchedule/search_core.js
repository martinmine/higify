$(document).ready(onPageLoaded);		

/**
* Called once the page is loaded, registers the event on the search form
*/
function onPageLoaded()
{
	$("#search").submit(onSubmit);
}

/**
* Function called once the search form is submitted, creates a JSON request
* to get the time objects for the search text
*/
function onSubmit(e)
{
	var searchElement = document.getElementById("searchField");
	$.getJSON("search_results.js", receivedSearchResult); // Add searchElement to the URL (filter)
	e.preventDefault();
}

/**
* Function called when the search data is received
*/
function receivedSearchResult(data)
{
    var elementCount = data["count"];
    var elements = data["results"];
    $.each(elements, appendTimeObject);
}

/**
* Adds one time object to the HTML output and the underlying data-structure
*/
function appendTimeObject(objIndex, obj)
{
    var objID = obj["id"];
    var objDesc = obj["name"];
    var form = $("#objectList");
    form.append('<div id="' + objID + '" class="searchResultElement">' +
    '<div class="objectDescription">' +  objDesc +'</div>' +
    '<button class="removeButton" onclick="removeTimeObject(\'' + objID +'\'); return false">Remove</button>' +
    '</div>');
}

/**
* Removes a time object from the HTML and the underlying data-structure
*/
function removeTimeObject(id) 
{ 
    var element = document.getElementById(id);
    element.parentNode.removeChild(element);
}