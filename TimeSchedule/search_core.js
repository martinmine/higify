$(document).ready(onPageLoaded);        

/**
* Called once the page is loaded, registers the event on the search form
*/
function onPageLoaded()
{
    $("#search").submit(onSubmit);
    schedule = new Array();
}

/**
* Function called once the search form is submitted, creates a JSON request
* to get the time objects for the search text
*/
function onSubmit(e)
{
    var searchElement = document.getElementById("searchField");
    var searchTypeElement = document.getElementById("searchType");

    var searchText = encodeURIComponent(searchElement.value);
    var searchType = encodeURIComponent(searchTypeElement.value);

    $.getJSON("search.php?searchType=" + searchType + "&searchText=" + searchText, receivedSearchResult);
    e.preventDefault();
}

var schedule;
/**
* Function called when the search data is received
*/
function receivedSearchResult(data)
{
    var elementCount = data["count"];
    var elements = data["results"];

    var resultSet = createResultSet(data["type"], data["info"], data["desc"]);


    $.each(elements, function(index, obj)   // For every new course in return result
    {
        var course = createCourse(obj["code"], obj["desc"]);
        resultSet.results.push(course);

        $.each(schedule, function(index, timeObject)    // set every other course with the same code to enabled
        {
            var sameObject = timeObject.tryGet(course.code);
            if (sameObject != null)
                sameObject.enabled = true;
        });

        appendTimeObject(course);
    });

    // check if is a union of existing?

    schedule.push(resultSet);   // add to schedule
}

/**
* Adds one time object to the HTML output and the underlying data-structure
*/
function appendTimeObject(obj)
{
    var form = $("#objectList");
    form.append('<div id="' + obj.code + '" class="searchResultElement">' +
    '<div class="objectDescription">' +  obj.code + ' ' + obj.desc +'</div>' +
    '<button class="removeButton" onclick="removeTimeObject(\'' + obj.code +'\'); return false">Remove</button>' +
    '</div>');
}

/**
* Removes a time object from the HTML and the underlying data-structure
*/
function removeTimeObject(id) 
{ 
    var element = document.getElementById(id);
    element.parentNode.removeChild(element);

    // Find the amount with LEAST enabled elements
    var enabledRatio = 1;
    var toRemove = new Array();

    $.each(schedule, function(index, resultSet)
    {
        var code = resultSet.tryGet(id);
        if (code != null)
            code.enabled = false;

        if (resultSet.enabledCount() == 0)
        {
            toRemove.push(resultSet);
        }
    });

    $.each(schedule, function(index, scheduleObject)
    {
        var scheduleIndex = schedule.indexOf(scheduleObject);
        schedule.splice(scheduleIndex);
    });
}

function createResultSet(type, info, desc)
{
    var resultSet = 
    {
        "type": type,
        "info": info,
        "desc": desc,
        "results": new Array(),

        count: function() 
        {
            return results.length;
        },

        enabledCount: function()
        {
            var count = 0;
            this.results.forEach(function(element) 
            {
                if (element.enabled == true)
                    count++;
            });

            return count;
        },

        contains: function(course) 
        {
            var found = false;
            this.results.forEach(function(element) 
            {
                if (element.code == course)
                    found = true;
            });

            return found;
        },

        tryGet: function(course)
        {
            var course = null;
            this.results.forEach(function(element) 
            {
                if (element.code == course)
                    course = element;
            });
            return course;
        }
    }

    return resultSet;
}

function createCourse(code, desc)
{
    var course = 
    {
        "code": code,
        "desc": desc,
        "enabled": true
    }

    return course;
}