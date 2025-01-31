<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(!function_exists('SolutionDefaulValues')) {
	function SolutionDefaulValues( $type ){
		if( $type == 'Folder') {
			$value ="%7B%22solnRow%22%3A%9288888379979%22%2C%22Model%22%3A%22Folder%22%7D";
			$name = 'New Folder';
		} else if( $type == 'CashflowModell') {
			$value = "%7B%22Model%22%3A%22CashflowModel%22%2C%22Age_value%22%3A71%2C%22AmountInvested%22%3A%2260000000%22%2C%22CWR_Select%22%3A2%2C%22Fund_Select%22%3A%22Destination%204%22%2C%22ClientName%22%3A%22New%Cashflow%Model%22%2C%22AdvisorName%22%3A%22AC%20Trust%22%2C%22solnRow%22%3A%221046%22%2C%22Age%22%3A%2250%22%2C%22RetirementAge%22%3A%2265%22%2C%22GlobalNCashFlowBars%22%3A1%2C%22NStrategyYears%22%3A4%2C%22InputLabel%22%3A%5B%22Initial%20investment%22%5D%2C%22InflowOutflow%22%3A%5B%220%22%5D%2C%22CashFlowArr%22%3A%5B%220%22%5D%2C%22Type%22%3A%5B%220%22%5D%2C%22Start%22%3A%5B%221%22%5D%2C%22TypeEnd%22%3A%5B%220%22%5D%2C%22TypeAsset%22%3A%5B%220%22%5D%2C%22TypePot%22%3A%5B%220%22%5D%2C%22TypeYearStrategy%22%3A%5B%5B%220%22%2C%220%22%5D%2C%5B%220%22%2C%220%22%5D%2C%5B%220%22%2C%220%22%5D%2C%5B%220%22%2C%220%22%5D%5D%2C%22TypeOverallStrategy%22%3A%5B%5B%220%22%2C%220%22%5D%2C%5B%220%22%2C%220%22%5D%2C%5B%220%22%2C%220%22%5D%2C%5B%220%22%2C%220%22%5D%5D%2C%22timestamp%22%3A%2209%20September%202019%2C%2010%3A16%3A27%20AM%22%2C%22ReturnsPot%22%3A%5B%220%22%2C%220%22%2C%220%22%2C%220%22%5D%2C%22ProjectionHorizon%22%3A%2290%22%7D";
			$name = 'New Solution';
		} else if ($type == 'CashflowModel'){
			$value = "%7B%22solnRow%22%3A%22371%22%2C%22Model%22%3A%22CashflowModel%22%2C%22ClientName%22%3A%22Client+B+Solution%22%2C%22DrawdownStart%22%3A%5B0%5D%2C%22Age%22%3A%2250%22%2C%22RetirementAge%22%3A%2265%22%2C%22GlobalNCashFlowBars%22%3A0%2C%22NStrategyYears%22%3A1%2C%22ProjectionHorizon%22%3A%22100%22%2C%22FundExpenses%22%3A%5B0.015%5D%2C%22FundTax%22%3A%5B0%5D%2C%22InputLabel%22%3A%5B%22Cashflow+name%22%5D%2C%22InflowOutflow%22%3A%5B%220%22%5D%2C%22CashFlowArr%22%3A%5B%2222000%22%5D%2C%22Type%22%3A%5B0%5D%2C%22Start%22%3A%5B0%5D%2C%22TypeEnd%22%3A%5B-3%5D%2C%22TypeAsset%22%3A%5B%220%22%5D%2C%22TypePot%22%3A%22%5B0%5D%22%2C%22TypeYearStrategy%22%3A%5B%5B0%5D%5D%2C%22TypeOverallStrategy%22%3A%5B%5B%223%22%5D%5D%2C%22TypeGlideOrFixedStrategy%22%3A%5B%5B0%5D%5D%2C%22StrategyOptimisationMax%22%3A%5B10%5D%2C%22vecInputSymbol%22%3A%5B0%5D%2C%22vecSolverInputFinalAmount%22%3A%5B%5B0%5D%5D%2C%22vecGoalSeekPotValue%22%3A%5B0%5D%2C%22vecGoalSeekTime%22%3A%5B2%5D%2C%22vecGoalSeekPercentile%22%3A%5B2%5D%2C%22WasLastRunGoalSeek%22%3Afalse%2C%22LastSclrSolveInput%22%3A%5B%5D%2C%22ReturnsPot%22%3A%5B%220%22%5D%2C%22FeeModelPot%22%3A%5B1%5D%2C%22RealNominalSelection%22%3A%22Real%22%2C%22ChartPos_Neg%22%3A%22PositiveOnly_Y%22%2C%22TimeSelection%22%3A%22Age%22%2C%22NumberOfDrawdowns%22%3A1%2C%22AssumptionsSet2Use%22%3A1%2C%22LiveColourOptions%22%3A%5B%22%23697d8a%22%5D%2C%22PotOptions%22%3A%5B%22Investment+pot+1%22%5D%2C%22timestamp%22%3A%2221+March+2023%2C+01%3A34%3A57+PM%22%2C%22vecGoalSeekRealNominal%22%3A%5B%22Real%22%5D%2C%22MeanReversion%22%3Afalse%2C%22RiskArrestation%22%3Afalse%7D";
			$name = 'New Solution';
		}
		return array(
			'name' => $name,
			'value' => $value,
		);
	}
}
if(!function_exists('defaultAssumptionData')) {
    function defaultAssumptionData() {
        $result = '{"asset_class":{"Cash":{"asset_fiveyear":"0","asset_sixyear":"0"},"Sovereign Debt":{"asset_fiveyear":"1","asset_sixyear":"0"},"Investment Grade":{"asset_fiveyear":"2.4","asset_sixyear":"2.4"},"High Yield":{"asset_fiveyear":"2.7","asset_sixyear":"2.7"},"Index Yield":{"asset_fiveyear":"1.8","asset_sixyear":"1.8"},"DW Equity":{"asset_fiveyear":"4.3","asset_sixyear":"4.3"},"EM Equity":{"asset_fiveyear":"6.4","asset_sixyear":"6.4"},"Property":{"asset_fiveyear":"2.3","asset_sixyear":"2.3"},"Resources":{"asset_fiveyear":"5.5","asset_sixyear":"5.5"},"Gold":{"asset_fiveyear":"7.1","asset_sixyear":"7.1"},"Alternatives":{"asset_fiveyear":"3.7","asset_sixyear":"3.7"}},"portfolios":{"CASH":[{"Cash":"100"},{"Sovereign Debt":"0"},{"Investment Grade":"0"},{"High Yield":"0"},{"Index Yield":"0"},{"DW Equity":"0"},{"EM Equity":"0"},{"Property":"0"},{"Resources":"0"},{"Gold":"0"},{"Alternatives":"0"}],"DEFENSIVE":[{"Cash":"5.75"},{"Sovereign Debt":"20"},{"Investment Grade":"23"},{"High Yield":"4.5"},{"Index Yield":"22.5"},{"DW Equity":"14.25"},{"EM Equity":"1.5"},{"Property":"0"},{"Resources":"0"},{"Gold":"2"},{"Alternatives":"6.5"}],"CAUTIOUS":[{"Cash":"5.25"},{"Sovereign Debt":"16.5"},{"Investment Grade":"19"},{"High Yield":"4.5"},{"Index Yield":"23.5"},{"DW Equity":"17"},{"EM Equity":"3"},{"Property":"0"},{"Resources":"1.5"},{"Gold":"2.25"},{"Alternatives":"7.5"}],"CAUTIOUS BALANCED":[{"Cash":"5"},{"Sovereign Debt":"10.75"},{"Investment Grade":"20"},{"High Yield":"7.5"},{"Index Yield":"12"},{"DW Equity":"25.5"},{"EM Equity":"5"},{"Property":"0"},{"Resources":"1.5"},{"Gold":"2.25"},{"Alternatives":"10.5"}],"BALANCED":[{"Cash":"3.75"},{"Sovereign Debt":"10"},{"Investment Grade":"13"},{"High Yield":"9.5"},{"Index Yield":"5"},{"DW Equity":"37"},{"EM Equity":"6"},{"Property":"0"},{"Resources":"1.75"},{"Gold":"2.5"},{"Alternatives":"11.5"}],"BALANCED GROWTH":[{"Cash":"3.25"},{"Sovereign Debt":"7.5"},{"Investment Grade":"10"},{"High Yield":"9.5"},{"Index Yield":"2.5"},{"DW Equity":"43"},{"EM Equity":"8.25"},{"Property":"0"},{"Resources":"1.75"},{"Gold":"2.5"},{"Alternatives":"11.75"}],"GROWTH":[{"Cash":"2.75"},{"Sovereign Debt":"5"},{"Investment Grade":"9"},{"High Yield":"10.5"},{"Index Yield":"0"},{"DW Equity":"46.75"},{"EM Equity":"10"},{"Property":"0"},{"Resources":"2"},{"Gold":"2.5"},{"Alternatives":"11.5"}],"HIGH GROWTH":[{"Cash":"2.5"},{"Sovereign Debt":"3"},{"Investment Grade":"2.5"},{"High Yield":"8"},{"Index Yield":"0"},{"DW Equity":"56.75"},{"EM Equity":"12.75"},{"Property":"0"},{"Resources":"2"},{"Gold":"2.5"},{"Alternatives":"10"}],"AGGRESSIVE GROWTH":[{"Cash":"2.5"},{"Sovereign Debt":"2"},{"Investment Grade":"2"},{"High Yield":"8"},{"Index Yield":"0"},{"DW Equity":"61"},{"EM Equity":"13"},{"Property":"0"},{"Resources":"0"},{"Gold":"2.5"},{"Alternatives":"7"}],"EQUITY":[{"Cash":"2.5"},{"Sovereign Debt":"0"},{"Investment Grade":"0"},{"High Yield":"0"},{"Index Yield":"0"},{"DW Equity":"77.5"},{"EM Equity":"20"},{"Property":"0"},{"Resources":"0"},{"Gold":"0"},{"Alternatives":"0"}]},"portfolioitrs":{"Inflation":{"portfolioitr_riskname":"","portfolioitr_fiveyear":"2.6","portfolioitr_sixyear":"2","portfolioitr_yearone":"","portfolioitr_yeartwo":"","drawanyears":["","","","","",""]},"CASH":{"portfolioitr_riskname":"0.6","portfolioitr_fiveyear":"0","portfolioitr_sixyear":"1.5","portfolioitr_yearone":"0.11","portfolioitr_yeartwo":"recovery","drawanyears":["","","","","",""]},"DEFENSIVE":{"portfolioitr_riskname":"5.8","portfolioitr_fiveyear":"4.67","portfolioitr_sixyear":"5.8","portfolioitr_yearone":"-11","portfolioitr_yeartwo":"15","drawanyears":["recovery","","","","",""]},"CAUTIOUS":{"portfolioitr_riskname":"6.4","portfolioitr_fiveyear":"4.91","portfolioitr_sixyear":"6.3","portfolioitr_yearone":"-12","portfolioitr_yeartwo":"0.69","drawanyears":["14","recovery","","","",""]},"CAUTIOUS BALANCED":{"portfolioitr_riskname":"8","portfolioitr_fiveyear":"5.35","portfolioitr_sixyear":"6.8","portfolioitr_yearone":"-17","portfolioitr_yeartwo":"-0.76","drawanyears":["22","recovery","","","",""]},"BALANCED":{"portfolioitr_riskname":"10.1","portfolioitr_fiveyear":"5.73","portfolioitr_sixyear":"7.3","portfolioitr_yearone":"-21","portfolioitr_yeartwo":"-2.4","drawanyears":["24","4.3","recovery","","",""]},"BALANCED GROWTH":{"portfolioitr_riskname":"11.6","portfolioitr_fiveyear":"6","portfolioitr_sixyear":"7.8","portfolioitr_yearone":"-23","portfolioitr_yeartwo":"-3.3","drawanyears":["27","11","recovery","","",""]},"GROWTH":{"portfolioitr_riskname":"12.7","portfolioitr_fiveyear":"6.21","portfolioitr_sixyear":"8.3","portfolioitr_yearone":"-26","portfolioitr_yeartwo":"-3.9","drawanyears":["29","12","recovery","","",""]},"HIGH GROWTH":{"portfolioitr_riskname":"14.8","portfolioitr_fiveyear":"6.52","portfolioitr_sixyear":"8.7","portfolioitr_yearone":"-15","portfolioitr_yeartwo":"-14","drawanyears":["-7.2","18","7","19","recovery",""]},"AGGRESSIVE GROWTH":{"portfolioitr_riskname":"15.6","portfolioitr_fiveyear":"6.59","portfolioitr_sixyear":"9","portfolioitr_yearone":"-17","portfolioitr_yeartwo":"-15","drawanyears":["-7.8","19","7.3","19","4.5","recovery"]},"EQUITY":{"portfolioitr_riskname":"19.2","portfolioitr_fiveyear":"6.91","portfolioitr_sixyear":"9.3","portfolioitr_yearone":"-23","portfolioitr_yeartwo":"-18","drawanyears":["-11","21","8","24","12","recovery"]}}}';
        
        return $result;
    }
}

if(!function_exists('DefaulTypeBeginData')) {
    function DefaulTypeBeginData( $selected = NULL){
        $return = array(
            "One off amount today"=>"Money moving today, either in, or out of your pots.",
            "One off nominal amount at" =>"Money moving at a point in the future.",
            "One off real amount at" =>"Money moving at a point in the future, increasing in line with inflation",
            "Annual nominal" =>"Money moving in or out of your pot every year with a start point and an end point.",
            "Annual nominal increasing 1%" =>"Money moving in or out of your pot every year with a start point and an end point, increasing by 1% per annum",
            "Annual nominal increasing 2%" =>"Money moving in or out of your pot every year with a start point and an end point, increasing by 2% per annum",
            "Annual nominal increasing 3%" =>"Money moving in or out of your pot every year with a start point and an end point, increasing by 3% per annum",
            "Annual nominal increasing 4%" =>"Money moving in or out of your pot every year with a start point and an end point, increasing by 4% per annum",
            "Annual nominal increasing 5%" =>"Money moving in or out of your pot every year with a start point and an end point, increasing by 5% per annum",
            "Annual nominal increasing 6%" =>"Money moving in or out of your pot every year with a start point and an end point, increasing by 6% per annum",
            "Annual nominal increasing 7%" =>"Money moving in or out of your pot every year with a start point and an end point, increasing by 7% per annum",
            "Annual nominal increasing 8%" =>"Money moving in or out of your pot every year with a start point and an end point, increasing by 8% per annum",
            "Annual real" =>"Money moving in or out of your pot every year over a range of dates with a start point and an end point, increasing in line with inflation.",
            "Annual real increasing 1%" =>"Money moving in or out of your pot every year over a range of dates with a start point and an end point, increasing in line with inflation plus 1% per annum.",
            "Annual real increasing 2%" =>"Money moving in or out of your pot every year over a range of dates with a start point and an end point, increasing in line with inflation plus 2% per annum.",
            "Annual real increasing 3%" =>"Money moving in or out of your pot every year over a range of dates with a start point and an end point, increasing in line with inflation plus 3% per annum.",
            "Annual real increasing 4%" =>"Money moving in or out of your pot every year over a range of dates with a start point and an end point, increasing in line with inflation plus 4% per annum.",
            "Annual real increasing 5%" =>"Money moving in or out of your pot every year over a range of dates with a start point and an end point, increasing in line with inflation plus 5% per annum.",
            "Annual real increasing 6%" =>"Money moving in or out of your pot every year over a range of dates with a start point and an end point, increasing in line with inflation plus 6% per annum.",
            "Annual real increasing 7%" =>"Money moving in or out of your pot every year over a range of dates with a start point and an end point, increasing in line with inflation plus 7% per annum.",
            "Annual real increasing 8%" =>"Money moving in or out of your pot every year over a range of dates with a start point and an end point, increasing in line with inflation plus 8% per annum.",
            "Quarterly nominal"=>"Money moving in or out of your pot every quarter over a range of dates",
            "Quarterly nominal increasing per annum 1%" =>"Money moving in or out of your pot every quarter over a range of dates, increasing by 1% per annum.",
            "Quarterly nominal increasing per annum 2%" =>"Money moving in or out of your pot every quarter over a range of dates, increasing by 2% per annum.",
            "Quarterly nominal increasing per annum 3%" =>"Money moving in or out of your pot every quarter over a range of dates, increasing by 3% per annum.",
            "Quarterly nominal increasing per annum 4%" =>"Money moving in or out of your pot every quarter over a range of dates, increasing by 4% per annum.",
            "Quarterly real"=>"Money moving in or out of your pot every quarter over a range of dates, increasing in line with inflation",
            "Quarterly real increasing per annum 1%" =>"Money moving in or out of your pot every quarter over a range of dates, increasing in line with inflation plus 1% per annum",
            "Quarterly real increasing per annum 2%" =>"Money moving in or out of your pot every quarter over a range of dates, increasing in line with inflation plus 2% per annum",
            "Quarterly real increasing per annum 3%" =>"Money moving in or out of your pot every quarter over a range of dates, increasing in line with inflation plus 3% per annum",
            "Quarterly real increasing per annum 4%" =>"Money moving in or out of your pot every quarter over a range of dates, increasing in line with inflation plus 4% per annum",
            "Monthly nominal" =>"Money moving in or out of your pot every month over a range of dates.",
            "Monthly nominal increasing per annum 1%" =>"Money moving in or out of your pot every month over a range of dates, increasing by 1% per annum",
            "Monthly nominal increasing per annum 2%" =>"Money moving in or out of your pot every month over a range of dates, increasing by 2% per annum",
            "Monthly nominal increasing per annum 3%" =>"Money moving in or out of your pot every month over a range of dates, increasing by 3% per annum",
            "Monthly nominal increasing per annum 4%" =>"Money moving in or out of your pot every month over a range of dates, increasing by 4% per annum",
            "Monthly real" =>"Money moving in or out of your pot every month over a range of dates, increasing in line with inflation. ",
            "Monthly real increasing per annum 1%" =>"Money moving in or out of your pot every month over a range of dates, increasing in line with inflation plus 1% per annum",
            "Monthly real increasing per annum 2%" =>"Money moving in or out of your pot every month over a range of dates, increasing in line with inflation plus 2% per annum",
            "Monthly real increasing per annum 3%" =>"Money moving in or out of your pot every month over a range of dates, increasing in line with inflation plus 3% per annum",
            "Monthly real increasing per annum 4%" =>"Money moving in or out of your pot every month over a range of dates, increasing in line with inflation plus 4% per annum",
        );
        return $return;
    }
}
if(!function_exists('DefaultStrategyDropdownData')) {
    function DefaultStrategyDropdownData( $selected = NULL){
        $return = array("Cash","Defensive","Cautious","Cautious Balanced","Balanced","Balanced Growth","Growth","High Growth","Aggressive Growth","Equity");
        return $return;
    }
}
if(!function_exists('DefaultTypeStartData')) {
    function DefaultTypeStartData( $selected = NULL){
        $return = array('Retirement', 'Now', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '25', '30', '35', '40', 'Horizon');
        return $return;
    }
}

if(!function_exists('DefaultarrFlowData')) {
    function DefaultarrFlowData( $selected = NULL){
        $return = array("Inflow","Outflow");
        return $return;
    }
}
if(!function_exists('DefaultReturnPathData')) {
    function DefaultReturnPathData( $selected = NULL){
        $return = array("Normal markets","Mean reverting markets");
        return $return;
    }
}
if(!function_exists('DefaultFeeModelData')) {
    function DefaultFeeModelData( $selected = NULL){
        $return = array("Standard","Wealth","Bespoke");
        return $return;
    }
}
if(!function_exists('goalseekprojectionAtTime')) {
    function goalseekprojectionAtTime( $agevalue=50, $selected = NULL){
        $result = array('Retirement','Now');
		for( $start = $agevalue; $start<=105; $start++) {
			$returndata[] = $start;
		}
		$resasdsult = array_merge($result, $returndata);
        return $resasdsult;
    }
}
if(!function_exists('DefaultTypeEndOptionsData')) {
    function DefaultTypeEndOptionsData( $agevalue,$selected = NULL){
        $result = array('then stop','to retirement','to projection age');
		for( $start = $agevalue; $start<=105; $start++) {
			$returndata[] = 'to age '.$start;
		}
		$resasdsult = array_merge($result, $returndata);
        return $resasdsult;
    }
}
if(!function_exists('DefaultTypePercentileslData')) {
    function DefaultTypePercentileslData( $selected = NULL){
        $return = array('50th','60th','70th','80th','90th','95th');
        return $return;
    }
}
if(!function_exists('NumberFormat')) {
    function NumberFormat( $number, $digits = 3 ){
        if( !empty($number)) {
            $return = number_format((float)($number/100), $digits, '.', '');
        } else {
            $return = 0;
        }
        return $return;
    }
}
if(!function_exists('DefaultRatingDropdownData')) {
    function DefaultRatingDropdownData( $selected = NULL){
        $strategyDropdownlists = DefaultStrategyDropdownData();
        $return = '
            <ul class="uk-nav uk-dropdown-nav">
            <li class="uk-nav-header">STRATEGY</li>';
            foreach( $strategyDropdownlists as $strategyDropdownlist ) {
                $return .= '<li><a href="javascript:void(0);">'.$strategyDropdownlist.'</a></li>';
            }
            $return .= '
                <li class="uk-nav-divider RatingDropdownTools" hidden></li>
                <li class="uk-nav-header RatingDropdownTools" hidden>Tools</li>	
                <li class="RatingDropdownTools" hidden><a href="#" ><span class="uk-margin-small-right uk-icon" uk-icon="trash"></span>Remove Strategy</a></li>
                <li class="RatingDropdownTools" hidden><a href="#"><span class="uk-margin-small-right uk-icon" uk-icon="future"></span>Glide</a></li>
                <li class="RatingDropdownTools" hidden><a href="#"><span class="uk-margin-small-right uk-icon" uk-icon="download"></span>Static</a></li>';
            $return .= '</ul>';   
        return false;
    }
}
if(!function_exists('DefaultIndicatorinfo')) {
    function DefaultIndicatorinfo( $type = 'indicator'){
        if($type == 'indicator') {
            $return = '
                <div>
                    <a uk-icon="icon: info" class="DFM1-infoColour uk-icon" aria-expanded="true"></a>
                    <div uk-drop="mode: click" id="infoReturnsType" class="uk-card uk-card-body uk-card-default uk-text-left uk-drop uk-drop-bottom-right" style="padding: 20px 20px; border-radius: unset;">
                        <strong>Traffic light Indicator:</strong> 
                        Shows how likely a given outflow cashflow is of being achieved. The chance of each outflow is calculated given all the inflows in that Pot, as well as outflows higher up the list in the same Pot.<br><br>
                        <strong>Green Indicator:</strong> 
                        Likely outcome.<br>
                        <strong>Yellow Indicator:</strong> Potential outcome.<br>
                        <strong>Red Indicator:
                        </strong> Unlikely outcome.<br><br>
                        <strong>Blue Indicator:</strong> Shows Inflows into the Pot, or Percentage amounts.<br>
                    </div>
                </div>';
        } else if($type == 'inoutflow') {
            $return = '
                <div>
                    <a uk-icon="icon: info" class="DFM1-infoColour uk-icon" aria-expanded="true"></a>
                    <div uk-drop="mode: click" id="infoReturnsType" class="uk-card uk-card-body uk-card-default uk-text-left uk-drop uk-drop-bottom-right" style="padding: 20px 20px;border-radius: unset;">
                        Choose IN (inflow) <br>or  OUT (outflow)
                    </div>
                </div>';
        }
        return $return;
    }
}
if(!function_exists('DefaultTypeStartYearData')) {
    function DefaultTypeStartYearData( $selected = NULL){
        $result = array('Retirement','Now');
        $currentYear = date('Y');
		for( $start = $currentYear; $start<=2078; $start++) {
			$returndata[] = 'From '.$start;
		}
		$resasdsult = array_merge($result, $returndata);
        return $resasdsult;
    }
}
if(!function_exists('DefaultTypeStartTodayData')) {
    function DefaultTypeStartTodayData( $selected = NULL){
        $result = array('Retirement','Now', 'Today, time 0');
		for( $start = 1; $start<=55; $start++) {
			$returndata[] = 'In year '.$start;
		}
		$resasdsult = array_merge($result, $returndata);
        return $resasdsult;
    }
}
if(!function_exists('DefaultgoalseekprojectionAtTime')) {
    function DefaultgoalseekprojectionAtTime( $agevalue=50, $selected = NULL){
        $result = array('then stop','to retirement','to projection age');
		for( $start = $agevalue; $start<=105; $start++) {
			$returndata[] = 'to age '.$start;
		}
		$resasdsult = array_merge($result, $returndata);
        return $resasdsult;
    }
}
