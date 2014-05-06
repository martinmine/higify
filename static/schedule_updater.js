$(document).ready(setScheduleTimeout);

/**
* Finds all the schedule items that is in the HTML, parses the end time of them 
* and schedules a removal of the item when the item ends
*/
function setScheduleTimeout()
{
    var scheduleElements = runXpath('//div[@class="hours"]/div[contains(@class, "timeObjectContainer")]', document);
    var now = new Date();

    for (var i = 0; i < scheduleElements.snapshotLength; i++)
    {
        var scheduleElement = scheduleElements.snapshotItem(i);
        var elementID = scheduleElement.getAttribute('id');
        var elementsEnd = runXpath('./div[@class="timeEnd"]', scheduleElement);

        if (elementsEnd.snapshotLength == 1)
        {
            var endElement = elementsEnd.snapshotItem(0);
            var endTimeData = endElement.textContent.trim().split(':');

            var elementEndTime = new Date();
            elementEndTime.setHours(endTimeData[0]);
            elementEndTime.setMinutes(endTimeData[1]);
            elementEndTime.setSeconds(0);
            
            var timeoutLength = elementEndTime.getTime() - now.getTime();
            
            setTimeout(removeScheduleElement, timeoutLength, elementID);
        }
    }
}

/**
* Removes an item from the schedule with the "collapse" effect
*/
function removeScheduleElement(id) {
    $("#" + id).effect("blind", 500);
}

/**
* Runs an xpath expression
*/
function runXpath(xpathExpression, context) {
    var ORDERED_NODE_SNAPSHOT_TYPE = 7;
    return document.evaluate(xpathExpression, context, null, ORDERED_NODE_SNAPSHOT_TYPE, null);
}