<?php
include_once 'config.php';

$conn = new Connection();

if(isset($_POST['userID']) && isset($_POST['teamID'])){
    $userID = $_POST['userID'];
    $teamID = $_POST['teamID'];
}

//get user territory ID
$territoryConfigID = $conn->getUserTerritoryID($userID,$teamID);

//get block ID Array 
$blockIDArray = $conn->getTerritoryBlockIDArray($territoryConfigID);
$arrayOFBlockID = explode(",", $blockIDArray);


//get pracPlaceIDArray 

foreach($arrayOFBlockID as $blockID){
    $practicePlaceArray = $conn->getPracPlaceIDArray($blockID);
}
$arrayOFPracticePlace = explode(",",$practicePlaceArray);


//get all the hcp in the user's territory

foreach($arrayOFPracticePlace as $practicePlace){
    $allHcpInTerritory = $conn->getAllHCP($practicePlace);
}

//get primmaryProdPortfolio 
$primaryProdOrPortfolioID = $conn->getPrimaryProdOrPortfolioID($territoryConfigID);

// get hcp class
foreach($allHcpInTerritory as $HcpID){
    $hcpCLass = $conn->getHCPCLass($HcpID->hcpID,$primaryProdOrPortfolioID);
}



//get total HCP calls for each HCP
// $totalCallsArray = array();

// foreach($allHcpInTerritory as $hcpID){
//     $totalCallsArray[] = $conn->getTotalCallUsingHcpID($hcpID->hcpID);
// }

$hcpCLassNotObject = array();
foreach ($hcpCLass as $HC) {
    $hcpCLassNotObject[$HC->classDesc] = $conn->getTotalCallUsingHcpID($HC->hcpID);
}

//cycle range 
$cycleRange = $conn->getCycleDates($userID);
$origin = new DateTime($cycleRange->startDate);
$target = new DateTime($cycleRange->endDate);
$interval = $origin->diff($target);

$DateRange = $interval->days;


//getting daily target in a territory
$dailyTarget = $conn->getDailyTargetCalls($territoryConfigID);

// Calculating % reach for each class
$classPercentage = array();
foreach($hcpCLassNotObject as $key => $value){
    $classPercentage['class-'.$key] = round(($value/($DateRange*$dailyTarget))*100,4);
}


//Calculate frequency for each class
$freqClass = array();
foreach($hcpCLassNotObject as $class => $calls){
    $freqClass['freq-'.$class] = round($calls/($dailyTarget*$DateRange),4);
}




$combinedArray = Array(
    "class" => array($classPercentage),
    "freq" => array($freqClass)
);

echo json_encode($combinedArray);


?>