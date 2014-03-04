<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title>Time schedule setup</title>
        <link rel="stylesheet" type="text/css" href="static/wizzard.css">
        <script type="text/javascript" src="static/jquery-latest.min.js"></script>
        <script type="text/javascript" src="static/jquery.json-2.4.min.js"></script>
        <script type="text/javascript" src="static/search_core.js"></script>
    </head>
    <body>
        <div class="container">
            <div>
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
            <div>
                <form id="objectForm" action="welcome.php" method="POST">
                    <h1>Items that will be added to your schedule:</h1>
                    <div id="objectList">

                    </div>
                    <input type="hidden" name="scheduleData" id="scheduleData">
                    <input class="saveBtn" type="submit" value="Save" />
                </form>
            </div>
        </div>
    </body>
</html>