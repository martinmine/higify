<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title><?php echo $PAGE_TITLE; ?></title>
	<?php
	foreach ($CSS as $stylesheet)
	{
		echo '<link rel="stylesheet" type="text/css" href="static/' . $stylesheet . '.css"/> ';
	}
	
	if (isset($JS))
	{
		foreach ($JS as $javascript)
		{
			echo '<script type="text/javascript" src="static/' . $javascript . '.js"></script> ';
		}
	}
	?>
</head>
<body>
    <div class="banner">
		<div id="bannerFloaterLeft" class="remainingWidthElement bannerPreWrapper">
			<a href="mainpage.php" style="text-decoration: none;">
				<div class="bannerTitle bannerLogo">
					Higify
				</div>
			</a>
		</div>
        <div class="bannerWrapper" id="bannerCenter">

            <div class="bannerCenterContainer">
				<div class="bannerTitle">
                    <?php echo $BANNER_TITLE; ?>
                </div>
            </div>
        
			<div class="controllerWrapper">
				<div class="pageControllerContainer">
					<div class="searchWrapper">
						<div class="searchContainer">
							<form class="form-wrapper cf" method="get" action="searchresults.php">
								<input type="text" name="searchterm" placeholder="Search by username..." required></input>
								<button type="submit">Search</button>
							</form>  
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="bannerFloaterRight" class="remainingWidthElement bannerPostWrapper">
			<div class="profileWrapper" id="bannerProfilePicture">
				<nav>
					<ul>
						<li class="head">
							<a href="#"><img src="display_profile_picture.php?id=<?php echo $USER_ID; ?>" width="50" height="50" /></a>
							<ul>
								<li><a href="profile.php?id=<?php echo $USER_ID; ?>" class="menuItem">My Profile</a></li>
								<li><a href="mainpage.php" class="menuItem">Home</a></li>
								<li><a href="edit_profile.php" class="menuItem">Settings</a></li>
								<li><a href="logout.php" class="menuItem">Sign Out</a></li>
							</ul>
						</li>
					</ul>
				</nav>
			</div>
			<div class="profileLinkWrapper" id="bannerUsername">
				<a href="mainpage.php" class="profileLink"><?php echo $USERNAME_BANNER; ?></a>
			</div>
		</div>
    </div>

    <div class="pageContainer">