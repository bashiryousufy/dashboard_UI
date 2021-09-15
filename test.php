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

// if($fullday->duration > 0){
//     $onFieldDuration =  1- $fullday->duration ;

//     $totalCalls = $conn->totalCallsForOneDay($_SESSION['userID']);

//     $PrevCR = $totalCalls->totalcalls/$onFieldDuration;

//     echo "PrevDay CR = ".$PrevCR;

// }

$fiveDayOffFieldDuration = $conn->checkFiveDayOnField($_SESSION['userID']);


if($fiveDayOffFieldDuration > 0 && $fiveDayOffFieldDuration <= 5){
    $onFieldDuration = 5 - $fiveDayOffFieldDuration;
    $fiveDayTotalCalls = $conn->totalCallsFor5Days($_SESSION['userID']);

    $fiveDays = $fiveDayTotalCalls/$onFieldDuration;

    echo round($fiveDays,2);
}




?>