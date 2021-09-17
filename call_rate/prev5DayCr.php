<?php
require_once('config.php');
$conn = new Connection();



//Prev 5 days calll rate

$fiveDayOffFieldDuration = $conn->checkFiveDayOnField($_SESSION['userID']);

$fiveDays =0;
if ($fiveDayOffFieldDuration > 0 && $fiveDayOffFieldDuration <= 5) {
    $onField5DayDuration = 5 - $fiveDayOffFieldDuration;
    $fiveDayTotalCalls = $conn->totalCallsFor5Days($_SESSION['userID']);

    $fiveDays = round(($fiveDayTotalCalls/$onField5DayDuration)/20, 3);
}











?>