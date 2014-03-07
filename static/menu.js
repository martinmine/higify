$(document).ready(setMenuFloaters); // Register event handlers
$(window).resize(setMenuFloaters);

/**
 * Resize the floaters on the sides of the menu center container as this can't be done with CSS  
 */
function setMenuFloaters()
{
    var left = document.getElementById("bannerFloaterLeft");
    var right = document.getElementById("bannerFloaterRight");
    var floaterWidth = ($(document).width() - 1000) / 2;
    left.style.width = floaterWidth + "px";
    right.style.width = floaterWidth + "px";
}