function runXpath(xpathExpression)
{
	var ORDERED_NODE_SNAPSHOT_TYPE = 7;
	return document.evaluate(xpathExpression, document, null, ORDERED_NODE_SNAPSHOT_TYPE, null);
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

var cellWidth;
var cellHeight;

function setTimeObjectLayout(width, height)
{
	cellWidth = width;
	cellHeight = height;
}

function setTimeObject(id, offset, duration)
{
	var element = document.getElementById(id);

	var offset = Math.floor(offset * (cellHeight / 60));
	var length = Math.floor(duration * (cellHeight / 60));

	if (length > cellHeight)	// If cross a border
	{
		length += Math.floor(length / cellHeight) * 3; // Add the size of the borders we crossed
	}

	element.style.height = length + "px";
	element.style.width = cellWidth + "px";
	element.style.marginTop = offset + "px";
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
	setContainerWidth(CELL_WIDTH, CELL_TIME_WIDTH);
	setHeightAndWidth('//div[@class="weekIdentifier"]', CELL_TIME_WIDTH - 4, CELL_DAY_HEADER_HEIGHT);
	setHeightAndWidth('//div[@class="timeIdentifier"]', CELL_TIME_WIDTH - 4, CELL_HEIGHT);
	setHeightAndWidth('//div[@class="dayHeader"]', CELL_WIDTH, CELL_DAY_HEADER_HEIGHT);
	setHeightAndWidth('//div[@class="singleHour"]', CELL_WIDTH, CELL_HEIGHT);

	setHeightAndWidth('//div[contains(@class, "dayPadding")]', CELL_WIDTH, CELL_DAY_PADDING_HEGIHT);
	setHeightAndWidth('//div[contains(@class, "weekPadding")]', CELL_TIME_WIDTH - 4, CELL_DAY_PADDING_HEGIHT);
}

function setContainerWidth(cellWidth, celltimerWidth)
{
	var container = document.getElementById('scheduleContainer');
	var totalWidth = celltimerWidth + 2 + (cellWidth + 1) * 5;
	container.style.width = totalWidth + 'px';
}