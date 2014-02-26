$(document).ready(onPageLoaded);        

/**
* Holds all the items that shall be either added or removed from the schedule
* Is an array of ResultSet
*/
var schedule;

/**
* Called once the page is loaded, registers event handlers and prepares variables
*/
function onPageLoaded()
{
    $("#search").submit(onSubmit);
    $("#objectForm").submit(onSave);
    schedule = new Array();
}

/**
* Function called once the search form is submitted, creates a JSON request
* to get the time objects for the search text
*/
function onSubmit(e)
{
    displayLoader();
    hideNotifications();

    var searchElement = document.getElementById("searchField");
    var searchTypeElement = document.getElementById("searchType");

    var searchText = encodeURIComponent(searchElement.value);
    var searchType = encodeURIComponent(searchTypeElement.value);

    $.getJSON("schedule_search.php?searchType=" + searchType + "&searchText=" + searchText, receivedSearchResult);
    e.preventDefault();
}

/**
* Function called when the user clicks on the save button on the end of the form
* Serializes the schedule to JSON data and adds it to the form
*/
function onSave(e)
{
    var scheduleData = document.getElementById("scheduleData");
    scheduleData.value = $.toJSON(schedule);
}

/**
* Function called when the search data is received
*/
function receivedSearchResult(data)
{
    hideLoader();
    var newItems = 0;   // The new items which gets added to the schedule

    var elements = data["results"];
    var resultSet = createResultSet(data["type"], data["info"], data["desc"], data["id"]);
    
    $.each(elements, function(index, obj)   // For every new course in return result
    {
        var course = createCourse(obj["code"], obj["desc"]);
        resultSet.results.push(course);
        var needsReadd = false;

        $.each(schedule, function(index, timeObject)    // set every other course with the same code to enabled
        {
            var sameObject = timeObject.tryGet(course.code);
            if (sameObject != null && sameObject.enabled == false)
            {
                sameObject.enabled = true;
                needsReadd = true;
                
            }
        });

        if (needsReadd)
        {
            appendTimeObject(course);
        }
        
        if (courseExists(course.code) == false) // If not already added,
        {
            appendTimeObject(course);           // add to output
            newItems++;
        }
    });

    if (newItems > 0)   // If there was any new items to add at all
        schedule.push(resultSet);   // add to schedule
    
    if (data["count"] == 0)
        displayNoSearchResultsFoundMessage();
}

/**
* Adds one time object to the HTML output and the underlying data-structure
*/
function appendTimeObject(obj)
{
    var list = $("#objectList");
    list.append('<div id="' + obj.code + '" class="searchResultElement">' +
                  '<div class="objectDescription">' + obj.code + ' - ' + obj.desc + '</div>' +
                  '<a href="#" onclick="removeTimeObject(\'' + obj.code + '\');" class="itemAction">Remove</a>' +
                '</div>');
}

/**
* Displays the loader icon at the end of the form with ID = search
*/
function displayLoader()
{
    var container = $("#notificationContainer");
    container.append('<img id="loaderIcon" class="loader" src="static/loader.gif" alt="Loading"/>');
}

/**
* Displays a notification to the user that nothing was found for this search
*/
function displayNoSearchResultsFoundMessage()
{
    var container = $("#notificationContainer");
    container.append('<div id="notification" class="notification">No items found</div>');
}

/**
* Removes the loader icon from the HTML document
*/
function hideLoader()
{
    removeHTMLElement("loaderIcon");
}

/**
* Hides the notification element from the HTML document
*/
function hideNotifications()
{
    removeHTMLElement("notification");
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
    var toRemove = new Array(); // Empty sets to be removed

    $.each(schedule, function(index, resultSet)
    {
        var code = resultSet.tryGet(id);
        if (code != null)
            code.enabled = false;

        if (resultSet.enabledCount() == 0) // Add to to-remove list if is empty
            toRemove.push(resultSet);
    });

    $.each(toRemove, function(index, scheduleObject)    // Remove all the empty sets
    {
        var scheduleIndex = schedule.indexOf(scheduleObject);
        schedule.splice(scheduleIndex);
    });
}

/**
* Checks if a course is already added (and enabled) in the time schedule
*/
function courseExists(courseCode)
{
    var found = false;
    $.each(schedule, function (index, resultSet)
    {
        var course = resultSet.tryGet(courseCode);
        if (course != null && course.enabled)
            found = true;
    });

    return found;
}

/**
* Creates a new ResultSet with a type, info and desc
* also defines the functions for the result set
*/
function createResultSet(type, info, desc, id)
{
    var resultSet = 
    {
        "id": id,
        "type": type, // What type this result set is for (room, lecturer, class, etc.)
        "info": info, // Information on the result set, eg IMT2321
        "desc": desc, // Description, eg. www-technology
        "results": new Array(), // All the course codes under the set

        // returns the amount of items under the result set
        count: function() 
        {
            return results.length;
        },

        // Returns the amount of enabled items in the result set, returns 0 if all the properties are enabled somewhere else
        enabledCount: function() 
        {
            var count = 0;
            var id = this.id;
            this.results.forEach(function(element) 
            {
                if (element.enabled)
                {
                    var rendundant = false; // Enabled of this type in other places
                    schedule.forEach(function (set)
                    {
                        if (set.id != id && set.hasCourseEnabled(element.code)) // Someone else has the code enabled, safe to disable here
                            rendundant = true;
                    });

                    if (!rendundant) // If nowhere to be found other places - this cannot be removed, increase the count
                        count++;
                }
            });

            return count;
        },

        hasCourseEnabled: function(course)
        {
            var found = false;
            this.results.forEach(function (element)
            {
                if (element.code == course && element.enabled)
                    found = true;
            });

            return found;
        },

        // Returns true or false if the set contains the course given as parameter
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

        // Tries to get a course from the set, returns null if none found
        tryGet: function(course) 
        {
            var hit = null;
            this.results.forEach(function(element) 
            {
                if (element.code == course)
                    hit = element;
            });
            return hit;
        }
    }

    return resultSet;
}

/**
* Creates a course with a code and a description
*/
function createCourse(code, desc)
{
    var course =
    {
        "code": code, // Code, eg. IMT123
        "desc": desc, // Description name, eg. Algorithmic Methods
        "enabled": true // When the user clicks remove, this is set to false
    }

    return course;
}

/**
* Removes an HTML element from the HTML document with the given ID
*/
function removeHTMLElement(id)
{
    var element = document.getElementById(id);
    if (element != null)
        element.parentElement.removeChild(element);
}