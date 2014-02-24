<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8"/>
		<title>Time schedule</title>
		<link rel="stylesheet" type="text/css" href="TimeSchedule/time_schedule.css">
		<script type="text/javascript" src="TimeSchedule/wgxpath.install.js"></script>
		<script type="text/javascript" src="TimeSchedule/time_schedule.js"></script>
		<script type="text/javascript">

			window.onload = function()
			{
				wgxpath.install();	// Wicked-good-xpath: Ensure document.evaluate is working
				var CELL_HEIGHT = 50;	// Height of all the cells in the time table
				var CELL_WIDTH = 200;	// Width of all the cells expect the time identifiers
				var CELL_DAY_HEADER_HEIGHT = 30;	// Height of the day labels
				var CELL_DAY_PADDING_HEGIHT = 10;	// Height of the cell bellow the day headers
				var CELL_TIME_WIDTH = 30;	// Width of all the other cells

				formatTimeTable(CELL_HEIGHT, CELL_WIDTH, CELL_DAY_HEADER_HEIGHT, CELL_DAY_PADDING_HEGIHT, CELL_TIME_WIDTH);

				setTimeObjectLayout(CELL_WIDTH - 8, CELL_HEIGHT - 2); // Set the style for all the time objects

<?php echo $TABLEJS; ?>
			};


		</script>
	</head>
	<body>
		<div class="sceduleWrapper">
		<div id="scheduleContainer" class="scheduleContainer">
			<div class="timeStamps">
				<div class="weekIdentifier"></div>
				<div class="timeIdentifier weekPadding">
					<div class="timeContainer"><?php echo $HOURBEGIN; ?></div>
				</div>
<?php echo $TIMELABELS; ?>
			</div>
<?php echo $DAYS; ?>
		</div>
		</div>
	</body>
</html>
