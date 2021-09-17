<?php
require_once('config.php');

session_start();
$email = "bashiryousufy@gmail.com";
$conn = new Connection();

if (!isset($_SESSION['userID'])) {
    $_SESSION['userID'] = $conn->getUserID($email);
}






// $fullday = $conn->checkPrevDayOnField($_SESSION['userID']);
// print_r($fullday);

// if($fullday > 0){
//     $onFieldDuration =  1- $fullday ;

//     $totalCalls = $conn->totalCallsForOneDay($_SESSION['userID']);

//     $PrevCR = $totalCalls/$onFieldDuration;

//     echo "PrevDay CR = ".$PrevCR;

// }

// $fiveDayOffFieldDuration = $conn->checkFiveDayOnField($_SESSION['userID']);


// if($fiveDayOffFieldDuration > 0 && $fiveDayOffFieldDuration <= 5){
//     $onFieldDuration = 5 - $fiveDayOffFieldDuration;
//     $fiveDayTotalCalls = $conn->totalCallsFor5Days($_SESSION['userID']);

//     $fiveDays = $fiveDayTotalCalls/$onFieldDuration;

//     echo round($fiveDays,2);
// }


//cycle CR

// $CycledateRange = $conn->getCycleDates($_SESSION['userID']);
// $origin = new DateTime($CycledateRange->startDate);
// $target = new DateTime($CycledateRange->endDate);
// $interval = $origin->diff($target);

// $DateRange = $interval->days;




// $cycle = $conn->checkCycleOffField($_SESSION['userID'],$CycledateRange->startDate,$CycledateRange->endDate);

// if($cycle > 0){
//     $totalCycleCalls = $conn->cycleTotalCalls($_SESSION['userID'] , $CycledateRange->startDate,$CycledateRange->endDate);
//     $onFieldDuration = $DateRange - $cycle;
//     $cycleCallRate = $totalCycleCalls/$onFieldDuration;

//     echo round($cycleCallRate,3);
// }

$result = $conn->getUserIDFromTeamID(1);
print_r($result);

?>

<div>
    <h1>Select UserID:</h1>
    <form action="">
        <select name="userID" id="userID">
            <option value="">Select an ID</option>
            <?php
                    foreach($result as $user):?>
            <option value=<?=$user->userID?>><?=$user->userID;?></option>

            <?php endforeach;?>
        </select>
    </form>
</div>