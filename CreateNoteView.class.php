<?php

    $courses = ScheduleController::getCourseElements(SessionController::getLoggedinID());
    foreach ($courses as $id => $desc)
    {
        "<option value=" . $desc . ">" . $desc . "</option>";
    }
?>