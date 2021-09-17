<?php
require_once('config.php');
$conn = new Connection();


//Cycle Call Rate

$CycledateRange = $conn->getCycleDates($_SESSION['userID']);
$origin = new DateTime($CycledateRange->startDate);
$target = new DateTime($CycledateRange->endDate);
$interval = $origin->diff($target);

$DateRange = $interval->days;




$cycle = $conn->checkCycleOffField($_SESSION['userID'], $CycledateRange->startDate, $CycledateRange->endDate);
$cycleCallRate =0;
if ($cycle > 0) {
    $totalCycleCalls = $conn->cycleTotalCalls($_SESSION['userID'], $CycledateRange->startDate, $CycledateRange->endDate);
    $onFieldCycleDuration = $DateRange - $cycle;
    $divideNum = $DateRange*4;
    if ($onFieldCycleDuration > 0) {
        $cycleCallRate = round(($totalCycleCalls/$onFieldCycleDuration)/$divideNum, 3);
    }
}


?>