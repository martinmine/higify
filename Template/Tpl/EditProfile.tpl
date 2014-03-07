
	<div class="pageSideContainer">
        <div class="pageElement">
			
			<form action="editprofile.php" method="post" enctype="multipart/form-data">
			
				<div class="pageTitle">
				  Profile Accessories
				</div>
				<div class="pageElementContent">
					<div>
						<?php if (isset($ERROR_PROFILEPIC)) echo $ERROR_PROFILEPIC; ?>
						<label for="file">Upload a new profile picture</label>
						<div>
							<input type="file" name="file" id="file"></input>
						</div>
						<div>
							<input type="submit" value="Apply"></input>
						</div>
					</div>
				</div>
				
				<div class="pageTitle">
				  Email
				</div>
				  <div class="pageElementContent">
					<?php if (isset($ERROR_EMAIL)) echo $ERROR_EMAIL; ?> 
				    <div>
						<label for="email">New email</label>
						<div>
							<input type="email" name="email"></input>
						</div>
					</div>
					<div>
						<label for="email">Please verify new email</label>
						<div>
							<input type="email" name="emailverification"></input>
						</div>
						<div>
							<input type="submit" value="Apply"></input>
						</div>
					</div>
				  </div>
				<div class="pageTitle">
				Timetable Options
				</div>
				<div class="pageElementContent">
					<div>
						<a href="edit_schedule.php"><b>Change timetable information</b></a>
					</div>
					<br />
					<div>
						<label for="public">Check the box to set your timetable to public</label>    
						<div>
							<input type="checkbox" name="public" value ="1" <?php if ($PUBLIC)echo 'checked';?>></input>
						</div>
						<div>
							<input type="submit" value="Apply"></input>
						</div>
					</div>
				</div>
				
				<div class ="pageTitle">
				  Password
				</div>
				<div class="pageElementContent">
				  <?php if (isset($ERROR_PASSWORD)) echo $ERROR_PASSWORD; ?>
				    <div>
						<label for="oldpassword">Current password</label>
					    <div>
							<input type="password" name="oldpassword"></input>
					    </div>
				    </div>
					<div>
					    <label for="newpassword">New password</label>
					    <div>
							<input type="password" name="newpassword"></input>
					    </div>
						<div>
							<input type="submit" value="Apply"></input>
						</div>
					</div>
				</div>
				
				
			</form>
		</div>
	</div>

			<div class="pageWidgetContainer">
				<div class="pageElement">
					<div 
						class="pageTitle">Instructions
					</div>
					<div class="pageElementContent">
						On this page, you can change your profile settings.  <br/>
					</div>
				</div>
			</div>
			