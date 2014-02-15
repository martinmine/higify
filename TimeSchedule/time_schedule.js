

function runXpath(xpathExpression)
{
	return document.evaluate(xpathExpression, document, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
}

function setHeightAndWidth(xpathExpression, width, height)
{
	var elements = runXpath(xpathExpression);
	var element;

	for (var i = 0; i < elements.snapshotLength; i++)
	{
		element = elements.snapshotItem(i);
		element.style.height = height + "px";
		element.style.width = width + "px";
	}
}

function setTimeObjects(xpathExpression, width, height)
{
	var elements = runXpath(xpathExpression);
	var element;

	for (var i = 0; i < elements.snapshotLength; i++)
	{
		element = elements.snapshotItem(i);

		var offset = element.getAttribute('offset') * (height / 60);
		var length = element.getAttribute('duration') * (height / 60);

		element.style.height = length + "px";
		element.style.width = width + "px";
		element.style.marginTop = offset + "px";
	}
}

function setHeight(xpathExpression, height)
{
	var elements = runXpath(xpathExpression);
	var element;

	for (var i = 0; i < elements.snapshotLength; i++)
	{
		element = elements.snapshotItem(i);
		element.style.height = height + "px";
	}
}

function formatTimeTable(CELL_HEIGHT, CELL_WIDTH, CELL_DAY_HEADER_HEIGHT, CELL_DAY_PADDING_HEGIHT, CELL_TIME_WIDTH)
{
	setHeightAndWidth('//div[@class="weekIdentifier"]', CELL_TIME_WIDTH, CELL_DAY_HEADER_HEIGHT);
	setHeightAndWidth('//div[@class="timeIdentifier"]', CELL_TIME_WIDTH - 4, CELL_HEIGHT);
	setHeightAndWidth('//div[@class="dayHeader"]', CELL_WIDTH, CELL_DAY_HEADER_HEIGHT);
	setHeightAndWidth('//div[@class="singleHour"]', CELL_WIDTH, CELL_HEIGHT);
	
	setTimeObjects('//div[contains(@class, "timeObjectContainer")]', CELL_WIDTH - 8, CELL_HEIGHT);
	setHeightAndWidth('//div[contains(@class, "dayPadding")]', CELL_WIDTH, CELL_DAY_PADDING_HEGIHT);
	setHeightAndWidth('//div[contains(@class, "weekPadding")]', CELL_TIME_WIDTH, CELL_DAY_PADDING_HEGIHT);
}

window.onload = function()
{
	try
	{
		var CELL_HEIGHT = 50;	// Height of all the cells in the time table
		var CELL_WIDTH = 200;	// Width of all the cells expect the time identifiers
		var CELL_DAY_HEADER_HEIGHT = 30;	// Height of the day labels
		var CELL_DAY_PADDING_HEGIHT = 10;	// Height of the cell bellow the day headers
		var CELL_TIME_WIDTH = 30;	// Width of all the other cells

		formatTimeTable(CELL_HEIGHT, CELL_WIDTH, CELL_DAY_HEADER_HEIGHT, CELL_DAY_PADDING_HEGIHT, CELL_TIME_WIDTH);
	}
	catch (ex)
	{
		all(ex.message);
	}
};
