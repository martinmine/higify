$(document).ready(pageLoaded); // Register event handlers
$(window).resize(setMenuFloaters);

/**
 * Resize the floaters on the sides of the menu center container 
 * as this can't easily be done with CSS  
 */
function setMenuFloaters()
{
    var left = document.getElementById("bannerFloaterLeft");
    var right = document.getElementById("bannerFloaterRight");
    var floaterWidth = Math.floor(($(document).width() - 1000) / 2) - 1;
    left.style.width = floaterWidth + "px";
    right.style.width = floaterWidth + "px";
}

/**
 * Sets the max page width of the site
 */
function pageLoaded()
{
    var center = document.getElementById("bannerCenter").offsetWidth;
    var picture = document.getElementById("bannerProfilePicture").offsetWidth;
    var username = document.getElementById("bannerUsername").offsetWidth;

    var totalWidth = center + picture + username + 200;

    $("body").css(
    {
        "min-width": totalWidth + "px"
    });

    setMenuFloaters();
}
