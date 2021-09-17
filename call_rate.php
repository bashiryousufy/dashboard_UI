<?php
require_once('config.php');
$conn = new Connection();

if(isset($_POST['userID'])){
    $userID = $_POST['userID'];
}

//prevDay CR
$oneDayOffFieldDuration = $conn->checkPrevDayOnField($userID);

$PrevCR = 0;
//Calculate only if Field Day Duration is greater than Zero
if ($oneDayOffFieldDuration > 0) {
    $onFieldDuration =  1- $oneDayOffFieldDuration ;
    $totalCalls = $conn->totalCallsForOneDay($userID);
    if ($onFieldDuration > 0) {
        $PrevCR = round(($totalCalls/$onFieldDuration)/4, 3);
    }
}



//Prev 5 days calll rate

$fiveDayOffFieldDuration = $conn->checkFiveDayOnField($userID);

$fiveDays =0;
if ($fiveDayOffFieldDuration > 0 && $fiveDayOffFieldDuration <= 5) {
    $onField5DayDuration = 5 - $fiveDayOffFieldDuration;
    $fiveDayTotalCalls = $conn->totalCallsFor5Days($userID);

    $fiveDays = round(($fiveDayTotalCalls/$onField5DayDuration)/20, 3);
}



//Cycle Call Rate

$CycledateRange = $conn->getCycleDates($userID);
$origin = new DateTime($CycledateRange->startDate);
$target = new DateTime($CycledateRange->endDate);
$interval = $origin->diff($target);

$DateRange = $interval->days;




$cycle = $conn->checkCycleOffField($userID, $CycledateRange->startDate, $CycledateRange->endDate);
$cycleCallRate =0;
if ($cycle > 0) {
    $totalCycleCalls = $conn->cycleTotalCalls($userID, $CycledateRange->startDate, $CycledateRange->endDate);
    $onFieldCycleDuration = $DateRange - $cycle;
    $divideNum = $DateRange*4;
    if ($onFieldCycleDuration > 0) {
        $cycleCallRate = round(($totalCycleCalls/$onFieldCycleDuration)/$divideNum, 3);
    }
}


$call_rate = array(
    'prevDayCR' => $PrevCR,
    'prev5DayCR' => $fiveDays,
    'cycleCR' => $cycleCallRate
);

echo json_encode($call_rate);

?>