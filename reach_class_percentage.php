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

print_r($hcpCLassNotObject);

?>