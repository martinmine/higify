    <div class="banner">
        <div class="bannerWrapper">
            <div class="bannerCenterContainer">
                <div class="bannerTitle">
					<?php echo $USERNAME; ?>
                </div>
            </div>
        </div>
        <div class="controllerWrapper">
            <div class="pageControllerContainer">
                <div class="searchWrapper">
                    <div class="searchContainer">
                        <form class="form-wrapper cf" method="get" action="searchresults.php">
                            <input type="text" name="searchterm" placeholder="Search by username..." required>
                            <button type="submit">Search</button>
                        </form>  
                    </div>
                </div>
                <div class="profileWrapper">
                    <div class="profileContainer">
						<a href="mainpage.php">
							<img src="displayProfilePicture.php?id=<?php echo $USER_ID; ?>" width="120" />
						</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="container">