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
	?>
</head>
<body>
    <div class="banner">
        <div class="bannerWrapper">
            <div class="bannerCenterContainer">
                <div class="bannerTitle">
                    <?php echo $BANNER_TITLE; ?>
                </div>
            </div>
        </div>
        <div class="controllerWrapper">
            <div class="pageControllerContainer">
                <div class="searchWrapper">
                    <div class="searchContainer">
                        <form class="form-wrapper cf">
                            <input type="text" placeholder="Search by username..." required>
                            <button type="submit">Search</button>
                        </form>  
                    </div>
                </div>
                <div class="profileLinkWrapper">
                    <a href="#" class="profileLink">martinmine</a>
                </div>
                <div class="profileWrapper">
                    <nav>
                        <ul>
                            <li class="head">
                                <a href="#"><img src="http://go-dong.me/dong.gif" width="50" height="50" /></a>
                                <ul>
                                    <li><a href="#" class="menuItem">My Profile</a></li>
                                    <li><a href="#" class="menuItem">Home</a></li>
                                    <li><a href="#" class="menuItem">Settings</a></li>
                                    <li><a href="#" class="menuItem">Sign Out</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="pageContainer">