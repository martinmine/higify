	<div class="left">
		<div class="profile">
			<h3><?php echo $USERNAME; ?></h3>
			<div class="profileImage">
				<img src="displayProfilePicture.php" height="200" width="200"/>
			</div>
			<div class="editProfile">
				<a href="editprofile.php">
					<div class="changeButton">
						Edit profile
					</div>
				</a>
			</div>
		</div>
		
		<div id="searchProfile">
			<form id="newSearch" method="get" action="searchresultspage.php">
				<input type="text" class="searchInput" name="searchterm" onfocus="if(this.value == 'Search users..') { this.value = ''; }" value="Search users.."><input type="submit" value=">" name="search" class="searchButton">
			</form></br></br>
		</div>
		
		<div class="links">
			<ul>
			<li><a href="https://fronter.com/hig/index.phtml">Fonter</a></li>
			<li><a href="http://www.hig.no">Hig</a></li>
			<li><a href="https://www.studweb.no/as/WebObjects/studentweb2?inst=HiG">Studentweb</a></li>
			<li><a href="show_schedule.php">My timeschedule</a></li>
			</ul>
		</div>
	</div>