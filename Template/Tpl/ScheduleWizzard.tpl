
			<div class="pageSideContainer">
            <div class="pageElement">
				<div class="wizzardWrapper">
				
					<form id ="search">
						<input class="searchField toolbar" type="text" id="searchField" name="searchField" />
						<select id="searchType" class="toolbar">
							<option value="182">Class</option>
							<option value="183">Course</option>
							<option value="184">Lecturer</option>
							<option value="185">Room name</option>
						</select>
						<input class="searchBtn toolbar" type="submit" value="Add" />
					</form>
					<div id="notificationContainer">
					</div>
				</div>
				<div class="pageTitle">
						Your schedule consists of:
				</div>
				<div class="wizzardWrapper">
					<form id="objectForm" action="edit_schedule.php" method="POST">		
						<div id="objectList">

						</div>
						<input type="hidden" name="scheduleData" id="scheduleData">
						<div class="scheduleOptionWrapper">
							<input type="checkbox" name="schedulePublic" value="private" <?php if (!$IS_PUBLIC) echo 'checked'; ?>>Nobody should see my schedule
						</div>
						<div class="saveBtnWrapper">
							
							<input class="saveBtn" type="submit" value="Save" />
							<a href="mainpage.php"><button type="button" class="saveBtn"><?php echo (($FIRST_TIME) ? 'I\'ll do this later' : 'Cancel'); ?></button></a>
						</div>
					</form>
				</div>
            </div>
			</div>
			<div class="pageWidgetContainer">
				<div class="pageElement">
					<div class="pageTitle">Instructions</div>
					<div class="wizzardInstructions">
						On this page, you get to add and exclude which items that shall appear on your schedule. <br/>
						Type in a search term, select the category and click add or press enter to add the items associated with your search to your schedule.
						You can then remove the classes associated with your search term by clicking remove.
					</div>
				</div>
			</div>
			