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
    $classPercentage[$key] = ($value/($DateRange*$dailyTarget))*100;
}

//display class percentage in dials
$htmlClassPercentage = array();
foreach($classPercentage as $class => $percentage){
    $htmlClassPercentage['class-'.$class] = '<div class="col-6 col-md-3 text-center">
                <input type="text" class="knob" value="'.round($percentage,2).'" data-width="90" data-height="90"
                    data-fgColor="#3c8dbc" data-readOnly="true" data-thickness=".4">
                <div class="knob-label">Class '.$class.'</div>
            </div>';
}

//Calculate frequency for each class
$freqClass = array();
foreach($hcpCLassNotObject as $class => $calls){
    $freqClass[$class] = $calls/($dailyTarget*$DateRange);
}

//display class frequency
$htmlclassfreq = array();
foreach($freqClass as $class => $freq){
    $htmlclassfreq['freq-'.$class] = '<div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-secondary" id="prev5DayColor">
                                <div class="inner" id="pre5">
                                    <h3 id="prev5DayCR">'.round($freq,5).'</h3>

                                    <p>'.$class.'</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                            </div>
                        </div>';
}

$combinedClassAndFreq = $htmlClassPercentage + $htmlclassfreq;

foreach($combinedClassAndFreq as $classFreq){
    echo $classFreq;
}
?>