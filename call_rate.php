<?php

require_once('config.php');
$conn = new Connection();

if(isset($_POST['userID']) && isset($_POST['teamID'])){
    $userID = $_POST['userID'];
    $teamID = $_POST['teamID'];
}


$calltarget = $conn->teamCallTarget($teamID);


//prevDay CR
$oneDayOffFieldDuration = $conn->checkPrevDayOnField($userID);

$PrevCR = 0;
$prevCRColor = 'bg-warning';
//Calculate only if Field Day Duration is greater than Zero
if ($oneDayOffFieldDuration > 0) {
    $onFieldDuration =  1- $oneDayOffFieldDuration ;
    $totalCalls = $conn->totalCallsForOneDay($userID);
    if ($onFieldDuration > 0) {
        $PrevCR = round(($totalCalls/$onFieldDuration)/4, 3);

        $halfPrevCR = $PrevCR/2;

        if($PrevCR >= $calltarget){
            $prevCRColor = 'bg-success';
        }else if($PrevCR < $calltarget && $PrevCR < $halfPrevCR ){
            $prevCRColor = 'bg-danger';
        }else{
            $prevCRColor = 'bg-warning';

        }
    }
}



//Prev 5 days calll rate

$fiveDayOffFieldDuration = $conn->checkFiveDayOnField($userID);

$fiveDays =0;
$prev5CRColor = '';

if ($fiveDayOffFieldDuration > 0 && $fiveDayOffFieldDuration <= 5) {
    $onField5DayDuration = 5 - $fiveDayOffFieldDuration;
    $fiveDayTotalCalls = $conn->totalCallsFor5Days($userID);

    $fiveDays = round(($fiveDayTotalCalls/$onField5DayDuration)/20, 3);
    
    

    $fiveDayCallTarget = ($calltarget/5)/20;
    $half5Days = $fiveDayCallTarget/2;


    if ($fiveDays >= $fiveDayCallTarget) {
        $prev5CRColor = 'bg-success';
    } elseif ($fiveDays < $fiveDayCallTarget && $fiveDays < $half5Days ) {
        $prev5CRColor = 'bg-danger';
    } else{
        $prev5CRColor =  'bg-warning';

        }

}



//Cycle Call Rate

$CycledateRange = $conn->getCycleDates($userID);
$origin = new DateTime($CycledateRange->startDate);
$target = new DateTime($CycledateRange->endDate);
$interval = $origin->diff($target);

$DateRange = $interval->days;




$cycle = $conn->checkCycleOffField($userID, $CycledateRange->startDate, $CycledateRange->endDate);
$cycleCallRate =0;
$prevCycleCRColor = '';

if ($cycle > 0) {
    $totalCycleCalls = $conn->cycleTotalCalls($userID, $CycledateRange->startDate, $CycledateRange->endDate);
    $onFieldCycleDuration = $DateRange - $cycle;
    $divideNum = $DateRange*4;
    $cycleCRTarget = ($calltarget/$DateRange)/$divideNum;
    $cycleHalf = $cycleCRTarget/2;
    if ($onFieldCycleDuration > 0) {
        $cycleCallRate = round(($totalCycleCalls/$onFieldCycleDuration)/$divideNum, 3);
        if ($cycleCallRate >= $cycleCRTarget) {
            $prevCycleCRColor = 'bg-success';
        } elseif ($cycleCallRate < $cycleCRTarget && $cycleCallRate < $cycleHalf  ) {
            $prevCycleCRColor = 'bg-danger';
        }else{
            $prevCycleCRColor = 'bg-warning';

        }

    }
}


$json_prevCR = '<div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box '.$prevCRColor.'" >
                                <div class="inner" id="preDay">
                                    <h3 id="prevDayCR">'.$PrevCR.'</h3>

                                    <p>PrevDay CR</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-android-call"></i>
                                </div>

                            </div>
                        </div>
';

$json_prev5days = '<div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box '.$prev5CRColor.'" id="prev5DayColor">
                                <div class="inner" id="pre5">
                                    <h3 id="prev5DayCR">'.$fiveDays.'</h3>

                                    <p>P5Days CR</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                            </div>
                        </div>';



$json_prevCycle = ' <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box '.$prevCycleCRColor.'" id="prevCycleColor">
                                <div class="inner" id="preCycle">
                                    <h3 id="cycleCR">'.$cycleCallRate.'</h3>

                                    <p>Current Cycle Call Rate</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-android-sync"></i>
                                </div>

                            </div>
                        </div>';

$call_rate = array(
    'prevDayCR' => $json_prevCR,
    'prev5DayCR' => $json_prev5days,
    'cycleCR' => $json_prevCycle,
);

foreach($call_rate as $cr){
    echo $cr;
}

?>