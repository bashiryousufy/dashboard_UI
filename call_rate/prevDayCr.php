<?php
require_once('config.php');
$conn = new Connection();

$oneDayOffFieldDuration = $conn->checkPrevDayOnField($_SESSION['userID']);

$PrevCR = 0;
//Calculate only if Field Day Duration is greater than Zero
if ($oneDayOffFieldDuration > 0) {
    $onFieldDuration =  1- $oneDayOffFieldDuration ;
    $totalCalls = $conn->totalCallsForOneDay($_SESSION['userID']);
    if ($onFieldDuration > 0) {
        $PrevCR = round(($totalCalls/$onFieldDuration)/4, 3);
    }
}



?>