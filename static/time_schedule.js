/**
* Runs a xpath query and returns the result
*/
function runXpath(xpathExpression)
{
	var ORDERED_NODE_SNAPSHOT_TYPE = 7;
	return document.evaluate(xpathExpression, document, null, ORDERED_NODE_SNAPSHOT_TYPE, null);
}

/**
* Sets the height and width for all elements found with an xpath expression
*/
function setHeightAndWidth(xpathExpression, width, height)
{
	var elements = runXpath(xpathExpression);

	for (var i = 0; i < elements.snapshotLength; i++)
	{
		var element = elements.snapshotItem(i);
		element.style.height = height + "px";
		element.style.width = width + "px";
	}
}

/**
* The width of one cell in the time schedule
*/
var cellWidth;

/**
* The height for one cell in the time schedule
*/
var cellHeight;

/**
* Sets the default width and height for one cell in the time schedule
*/
function setTimeObjectLayout(width, height)
{
	cellWidth = width;
	cellHeight = height;
}

/**
* Sets the properties for one time object by the object's ID
* @offset integer Amount of minutes the object shall be moved down on the schedule
* @duration integer The duration of the time objects in minutes
*/
function setTimeObject(id, offset, duration, indent, indentMax)
{
	var element = document.getElementById(id);

	var offset = Math.floor(offset * (cellHeight / 60));
	var length = Math.floor(duration * (cellHeight / 60));

	var width = (CELL_WIDTH / indentMax) - 8;
	var widthOffset = (indent - 1) * (CELL_WIDTH / indentMax);

	if (length > cellHeight)	// If cross a border
	{
		length += Math.floor(length / cellHeight) * 3; // Add the size of the borders we crossed
	}

	element.style.height = length + "px";
	element.style.width = width + "px";
	element.style.marginLeft = widthOffset + "px";
	element.style.marginTop = offset + "px";
}

/**
* Sets the height for all the elements found with an xpath expression
*/
function setHeight(xpathExpression, height)
{
	var elements = runXpath(xpathExpression);

	for (var i = 0; i < elements.snapshotLength; i++)
	{
		var element = elements.snapshotItem(i);
		element.style.height = height + "px";
	}
}

/**
* Formats the time table according to the given parameters
*/
function formatTimeTable(cellHeight, cellWidth, cellDayHeaderHeight, cellDayPaddingHeight, cellTimeWidth)
{
	setContainerWidth(cellWidth, cellTimeWidth);
	setHeightAndWidth('//div[@class="weekIdentifier"]', cellTimeWidth - 4, cellDayHeaderHeight);
	setHeightAndWidth('//div[@class="timeIdentifier"]', cellTimeWidth - 4, cellHeight);
	setHeightAndWidth('//div[@class="dayHeader"]', cellWidth, cellDayHeaderHeight);
	setHeightAndWidth('//div[@class="singleHour"]', cellWidth, cellHeight);

	setHeightAndWidth('//div[contains(@class, "dayPadding")]', cellWidth, cellDayPaddingHeight);
	setHeightAndWidth('//div[contains(@class, "weekPadding")]', cellTimeWidth - 4, cellDayPaddingHeight);

	initTimeLine(cellDayHeaderHeight + cellDayPaddingHeight, 8, cellHeight);
}

var timeLineOffset; // Height from the top of the schedule and down to the first cell item (first hour)
var firstHour; // Number of the first hour on the schedule
var timeCellHeight; // The height of the cells

/**
* Initlaizes the time line variables and the timer function
*/
function initTimeLine(offset, firstScheduleHour, cellHeight) {
    timeLineOffset = offset + 2;
    timeCellHeight = cellHeight + 1;
    firstHour = firstScheduleHour;
    window.setInterval(onMinute, 60000);
    onMinute();
}

/**
* Function called each minute, moves the time line
*/
function onMinute()
{
    var now = new Date();
    setTimeLine(now.getHours(), now.getMinutes());
}

/**
* Moves the time line to a given hour/minute on the schedule
*/
function setTimeLine(hour, minute)
{
    var totalMinutes = (hour - firstHour) * 60 + minute;
    var pixelPerMinute = timeCellHeight / 60;
    var offset = totalMinutes * pixelPerMinute;

    document.getElementById('scheduleTimeLine').style.marginTop = (timeLineOffset + offset) + "px";
}

/**
* Sets the width of the time schedule container
*/
function setContainerWidth(cellWidth, celltimerWidth)
{
	var container = document.getElementById('scheduleContainer');
	var totalWidth = celltimerWidth + 2 + (cellWidth + 1) * 5;
	container.style.width = totalWidth + 'px';
}