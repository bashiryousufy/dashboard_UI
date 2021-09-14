<?php
require_once('config.php');

session_start();
$email = "bashiryousufy@gmail.com";
$conn = new Connection();

if (!isset($_SESSION['userID'])) {
    $_SESSION['userID'] = $conn->getUserID($email);
}






$fullday = $conn->checkIfFullDay($_SESSION['userID']);

if($fullday->duration > 0){
    $onFieldDuration =  1- $fullday->duration ;

    $totalCalls = $conn->totalCallsForOneDay($_SESSION['userID']);

    $PrevCR = $totalCalls->totalcalls/$onFieldDuration;

    echo "PrevDay CR = ".$PrevCR;

}

?>