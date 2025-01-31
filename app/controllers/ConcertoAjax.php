<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/FrontEndController.php';

class ConcertoAjax extends FrontEndController {

	public function __construct() {
		parent::__construct();
		$this->txtSessionIDtxtUserInput = '<input type="hidden" id="txtSessionIDtxtUserID"
        value="'.($this->organisation.'::'.$this->userid.'::'.$this->OrganisationApiName).'" />';
		if(IsMobileBrowser()) 
			$this->viewFolder = "/concerto/mobile/";
		else
			$this->viewFolder = "/concerto/";

			$this->load->model('concerto_model','concerto');
	}
	public function PingServer_ApiCall() {
		$object = array('nargout'=>1,'rhs' => array('ping'));
		$lists = self::__getJTCApiAssetData(json_encode($object),'runATR1_1');
		echo $lists;
	}
	public function loadrATR_ApiCall() {
		$atrtype = decryptKey($this->input->post('atrtype'));
		$currentCurrency = 'USD';
		if(isset($_COOKIE['selectedcurrencyvalue']) && $_COOKIE['selectedcurrencyvalue'] == '£') {
			$currentCurrency = 'GBP';
		}elseif(isset($_COOKIE['selectedcurrencyvalue']) && $_COOKIE['selectedcurrencyvalue'] == '€') {
			$currentCurrency = 'EUR';
		}elseif(isset($_COOKIE['selectedcurrencyvalue']) && $_COOKIE['selectedcurrencyvalue'] == '$') {
			$currentCurrency = 'USD';
		}
		if( $atrtype != '' && !empty($atrtype) ) {
			$modetype = $this->input->post('modetype');
			$columnNames = explode('_', $modetype);
			$columnName = $columnNames[0];
			$info = $this->concerto->getjtcinfo();
			if( $atrtype == 'runGrowthPage') {
				$horizonColmn = $columnName.'_horizon';
				$horizonInfo = json_decode($info->$horizonColmn,true);
				$object = array('nargout'=>1,'rhs' => 
					array(
						"PotValue",(int)$this->DefaultPortValue,
						"Age",(int)$horizonInfo['current_age'],
						"RetirementAge",(int)$horizonInfo['retirerment_age']
					)
				);
			} else if( $atrtype == 'runPotentialFalls') {
				$horizonColmn = $columnName.'_potentialfalls';
				$horizonInfo = json_decode($info->$horizonColmn,true);
				$object = array('nargout'=>1,'rhs' => 
					array(
						"PotValue",(int)$this->DefaultPortValue,
						"Currency",$currentCurrency,
					)
				);
			}
			
			$lists = self::__getJTCApiAssetData(json_encode($object),$atrtype);
			$apiresponse = array();
			if( !empty($lists) ) {
				$apiresponse = json_decode($lists, true);
			}
			$this->LoadHtmlLayout( $apiresponse, $atrtype, $columnName );
		}
		
	}
	public function LoadHtmlLayout( $apiresponse, $atrtype, $columnName ){
		$html = '';
		if( !empty($atrtype)  && $atrtype == 'runGrowthPage') {
			if(IsMobileBrowser()) {
				$html = $this->loadPageHtml_runGrowth_mobile($apiresponse, $columnName);
			} else {
				$html = $this->loadPageHtml_runGrowth_desktop($apiresponse, $columnName);
			}
		} else if( !empty($atrtype)  && $atrtype == 'runPotentialFalls') {
			if(IsMobileBrowser()) {
				$html = $this->loadPageHtml_runPotentialFalls_mobile($apiresponse, $columnName);
			} else {
				$html = $this->loadPageHtml_runPotentialFalls_desktop($apiresponse, $columnName);
			}
			
		}
		echo $html;
	}

	public function loadPageHtml_runGrowth_mobile($apiresponse, $columnName) {
		$apidata = $apiresponse['lhs'][0]['mwdata'];
		$projectionlist = $apidata['mxProjection'][0]['mwdata'];
		$projectionlists = array_chunk($projectionlist, ceil(count($projectionlist)/3));

		$info = $this->concerto->getjtcinfo();
		$growthColmn = $columnName.'_growth';
		$GrowthInfo = json_decode($info->$growthColmn);
		
		$html = '<div class="uk-width-expand@l narrow-block-mobile">
		<ul id="growth-projections" class="uk-switcher growth-projections" style="background-image: url('.assets_url('concerto/icons/diagram-growth-alt.svg').'); background-position: center; background-repeat: no-repeat; background-size: 100% 100%; ">';
		if( isset($projectionlists) && !empty($projectionlists) ) {
			$transposedArray = array();
			foreach ($projectionlists as $row => $columns) {
				foreach ($columns as $column => $value) {
					$transposedArray[$column][$row] = $value;
				}
			}
			if( isset($transposedArray) && !empty($transposedArray) ) {
				foreach($transposedArray as $index=>$transposedinfo ){
					$html .= '
					<li class="uk-animation-slide-top-small '.( $GrowthInfo->planting_growth_label == $index ? 'uk-active':'').'">
                        <svg id="_01" data-name="01" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 700 460">
                            <text id="outcomeValue1" class="diagram-text-large" transform="translate(11 269.39)">
                            <tspan x="0" y="0">'.(isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$').number_format($apidata['PotValue'][0]['mwdata'][0]).'</tspan>
                            </text>
                            <text id="outcomeValue2" class="diagram-text-large" transform="translate(550 48.77)">
                            <tspan x="0" y="0">'.(isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$').number_format($transposedinfo[2]).'</tspan>
                            </text>
                            <text id="outcomeValue3" class="diagram-text-large" transform="translate(550 211.78)">
                            <tspan x="0" y="0">'.(isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$').number_format($transposedinfo[1]).'</tspan>
                            </text>
                            <text id="outcomeValue4" class="diagram-text-large" transform="translate(550 375.36)">
                            <tspan x="0" y="0">'.(isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$').number_format($transposedinfo[0]).'</tspan>
                            </text>
                        </svg>					
					</li>';
				}
			}
		}
		$html .= '</ul>
		</div>';
		$html .= '
			<input id="planting_growth_info" type="hidden" name="planting_growth_info" value="'. ( !empty($GrowthInfo->planting_growth_info) ? $GrowthInfo->planting_growth_info : '' ).'">
			<div class="uk-width-2-5@m growth-matrix">
				<h4 class="uk-text-light">I would like my money to&mldr;</h4>
				<ul class="uk-tab-left half-pill-button-left '.( empty($GrowthInfo->planting_growth_label) ? 'remove-default-rquired-li' : '' ).'" uk-tab="connect: #growth-projections">
					<li class="'.($GrowthInfo->planting_growth_label =='5' ? 'uk-active' : '' ).'" onclick="getbuttonvalue(this);" data-btnVal="5"  data-btnId="planting_growth_label" data-btnIdInfo="planting_growth_info" data-btnValInfo="Grow as much as possible"><a>Grow as much as possible</a></li>
					<li class="'.($GrowthInfo->planting_growth_label =='4' ? 'uk-active' : '' ).'" onclick="getbuttonvalue(this);" data-btnVal="4"  data-btnId="planting_growth_label" data-btnIdInfo="planting_growth_info" data-btnValInfo="Grow in a balanced way"><a>Grow in a balanced way</a></li>
					<li class="'.($GrowthInfo->planting_growth_label =='3' ? 'uk-active' : '' ).'" onclick="getbuttonvalue(this);" data-btnVal="3"  data-btnId="planting_growth_label" data-btnIdInfo="planting_growth_info" data-btnValInfo="Beat inflation"><a>Beat inflation</a></li>
					<li class="'.($GrowthInfo->planting_growth_label =='2' ? 'uk-active' : '' ).'" onclick="getbuttonvalue(this);" data-btnVal="2"  data-btnId="planting_growth_label" data-btnIdInfo="planting_growth_info" data-btnValInfo="Keep pace with inflation"><a>Keep pace with inflation</a></li>
					<li class="'.($GrowthInfo->planting_growth_label =='1' ? 'uk-active' : '' ).'" onclick="getbuttonvalue(this);" data-btnVal="1"  data-btnId="planting_growth_label" data-btnIdInfo="planting_growth_info" data-btnValInfo="Maintain capital value"><a>Maintain capital value</a></li>
				</ul>
            </div>
		';
		return $html;

	}

	public function loadPageHtml_runGrowth_desktop($apiresponse, $columnName) {
		$apidata = $apiresponse['lhs'][0]['mwdata'];
		$projectionlist = $apidata['mxProjection'][0]['mwdata'];
		$projectionlists = array_chunk($projectionlist, ceil(count($projectionlist)/3));

		$info = $this->concerto->getjtcinfo();
		$growthColmn = $columnName.'_growth';
		$GrowthInfo = json_decode($info->$growthColmn);

		$html = '
		<input id="planting_growth_info" type="hidden" name="planting_growth_info" value="'. ( !empty($GrowthInfo->planting_growth_info) ? $GrowthInfo->planting_growth_info : '' ).'">
			<div class="uk-width-2-5@m growth-matrix uk-visible@s">
				<ul class="uk-tab-left half-pill-button-left '.( empty($GrowthInfo->planting_growth_label) ? 'remove-default-rquired-li' : '' ).'"
					uk-tab="connect: #growth-projections">
					<li class="'.($GrowthInfo->planting_growth_label =='5' ? 'uk-active' : '' ).' "
						onclick="getbuttonvalue(this);" data-btnVal="5" data-btnIdInfo="planting_growth_info" data-btnValInfo="Grow as much as possible" data-btnId="planting_growth_label" ><a>Grow as much as possible</a></li>
					<li class="'.($GrowthInfo->planting_growth_label =='4' ? 'uk-active' : '' ).'"
						onclick="getbuttonvalue(this);" data-btnVal="4" data-btnValInfo="Grow in a balanced way"  data-btnId="planting_growth_label" data-btnIdInfo="planting_growth_info"><a>Grow
							in a balanced way</a></li>
					<li class="'.($GrowthInfo->planting_growth_label =='3' ? 'uk-active' : '' ).'"
						onclick="getbuttonvalue(this);" data-btnVal="3" data-btnValInfo="Beat inflation"  data-btnId="planting_growth_label" data-btnIdInfo="planting_growth_info"><a>Beat inflation</a></li>
					<li class="'.($GrowthInfo->planting_growth_label =='2' ? 'uk-active' : '' ).'"
						onclick="getbuttonvalue(this);" data-btnVal="2" data-btnValInfo="Keep pace with inflation"   data-btnId="planting_growth_label" data-btnIdInfo="planting_growth_info"><a>Keep
							pace with inflation</a></li>
					<li class="'.($GrowthInfo->planting_growth_label =='1' ? 'uk-active' : '' ).'"
						onclick="getbuttonvalue(this);" data-btnVal="1" data-btnValInfo="Maintain capital value"  data-btnId="planting_growth_label" data-btnIdInfo="planting_growth_info">
						<a>Maintain capital value</a></li>
				</ul>
			</div>
		';
		$html .= '<div class="uk-width-expand@l narrow-block-mobile">
			<ul id="growth-projections" class="uk-switcher growth-projections">
		';
		if( isset($projectionlists) && !empty($projectionlists) ) {
			foreach($projectionlists as $index=>$projectionlist ){
				foreach($projectionlist as $key=>$pair ) {
					$html .= '
					<li class="'.( $GrowthInfo->planting_growth_label == $key ? 'uk-active':'').'">
						<div class="uk-text-center" uk-grid uk-height-match="target: > div > div">
						<div class="uk-width-1-4@m">
							<div class="uk-flex uk-flex-center uk-flex-middle growth-outcome">
								<p class="uk-flex uk-flex-wrap uk-flex-middle">Current plan value
									<span>'.(isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$').''.number_format($apidata['PotValue'][0]['mwdata'][0]).'</span>
								</p>
							</div>
						</div>
						<div class="uk-width-expand@m uk-padding-remove-left">
							<div class="uk-height-medium uk-flex uk-flex-center uk-flex-middle uk-background-contain uk-light"
								data-src="'.assets_url('concerto/icons/diagram-growth-alt.svg').'"
								uk-img></div>
						</div>
						<div class="uk-width-auto@m uk-padding-remove-left growth-outcome">';
							$html .= '
							<div class="">
								<p class="uk-flex uk-flex-middle uk-flex-column">Good outcome: <span
										class="uk-animation-slide-top-small growthstatsdatainformations" '.( empty($GrowthInfo->planting_growth_label) ? 'hidden' : '' ).'>'.(isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$').''.number_format($projectionlists[2][$key]).'</span></p>
								<p style="height: 250px;" class="uk-flex uk-flex-center uk-flex-column">Typical
									outcome: <span class="uk-animation-slide-top-small growthstatsdatainformations" '.( empty($GrowthInfo->planting_growth_label) ? 'hidden' : '' ).'>'.(isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$').''.number_format($projectionlists[1][$key]).'</span></p>
								<p class="uk-flex uk-flex-middle uk-flex-column">Poor outcome: <span
										class="uk-animation-slide-top-small growthstatsdatainformations" '.( empty($GrowthInfo->planting_growth_label) ? 'hidden' : '' ).'>'.(isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$').''.number_format($projectionlists[0][$key]).'</span></p>
								<p style="height: 100px;">&nbsp;</p>
							</div>'; 
						$html .= '</div>';
						$html .= '</div>
						<p class="uk-margin-remove-top uk-text-center" style="font-weight: 100; font-size: 1.6em; padding-left: 150px">'.$apidata['Time'][0]['mwdata'][0].' years</p>
					</li>';
				}
			}
		}
		$html .= '</ul>
		</div>';
		return $html;

	}

	public function loadPageHtml_runPotentialFalls_desktop($apiresponse, $columnName) {
		$apidata = $apiresponse['lhs'][0]['mwdata'];
		$txtOptionsInfoLists = $apidata['txtOptions'][0]['mwdata'];
		
		$html = '';
		if( isset($txtOptionsInfoLists) && !empty($txtOptionsInfoLists) ) {
			$PotValue = $apidata['FormatPotValue'][0]['mwdata'][0]['mwdata'][0];
			$txtOutput = $apidata['txtOutput'][0]['mwdata'][0]['mwdata'][0];
			$vecFormatTroughLists = $apidata['vecFormatTrough'][0]['mwdata'];
			$vecYearFormatLists = $apidata['vecYearFormat'][0]['mwdata'];

			$info = $this->concerto->getjtcinfo();
			$PotentialfallsColmn = $columnName.'_potentialfalls';
			$PotentialFallsInfo = json_decode($info->$PotentialfallsColmn);

			$html .= '
			<input id="planting_potentialfalls_info" type="hidden" name="planting_potentialfalls_info" value="'. ( !empty($PotentialFallsInfo->planting_potentialfalls_info) ? $PotentialFallsInfo->planting_potentialfalls_info : '' ).'">
			<input type="hidden" name="planting_potentialfalls_tagline" value="'. ( !empty($txtOutput) ? $txtOutput : '' ).'">
			<h4 class="uk-margin-medium-top uk-text-light uk-visible@s"><span uk-tooltip="title: Current plan value; delay: 500">'.$txtOutput.'</span></h4>
			<div uk-grid class="uk-grid-match "> 
			<div class="uk-width-2-5@m growth-matrix  uk-visible@s">
				<ul class="uk-tab-left half-pill-button-left '.( empty($PotentialFallsInfo->planting_potentialfalls_label) ? 'remove-default-rquired-li' : '' ).'"
					uk-tab="connect: .potential-falls-projections;">';
					if( isset($txtOptionsInfoLists)) {
						$loopcount = 1;
						foreach($txtOptionsInfoLists as $index=>$txtOptionsInfoList ){
							$html .= '<li class="'.( $PotentialFallsInfo->planting_potentialfalls_label == $loopcount ? 'uk-active' : '' ).'"
								onclick="getbuttonvalue(this);" data-btnVal="'.$loopcount++.'" data-btnId="planting_potentialfalls_label" data-btnIdInfo="planting_potentialfalls_info" data-btnValInfo="'.$txtOptionsInfoList['mwdata'][0].'">
								<a>'.$txtOptionsInfoList['mwdata'][0].'</a>
							</li>';
						}
					}
					$html .= '</ul>
			</div>';

			$html .= '<div class="uk-width-expand@m narrow-block-mobile">
                    <ul id="potential-falls-projections"
                        class="uk-switcher potential-falls-projections '.( empty($PotentialFallsInfo->planting_potentialfalls_label) ? 'remove-default-rquired-li' : '' ).'"
                        style="background-image: url('.assets_url('concerto/icons/diagram-potential-falls_base.svg').'); background-position: center; background-repeat: no-repeat; background-size: 100% 100%; ">';

						if( isset($vecFormatTroughLists)) {
							foreach($vecFormatTroughLists as $index=>$vecFormatTroughList ){
								$translate_diagram = '';
								if( ($index+1) == 1) {
									$translate_diagram = 'translate(241.29405 31.91595)';
								} 
								if( ($index+1) == 2) {
									$translate_diagram = 'translate(330.8382 31.91595)';
								} 
								if( ($index+1) == 3) {
									$translate_diagram = 'translate(496.99997 31.91595)';
								} 
								if( ($index+1) == 4) {
									$translate_diagram = 'translate(562.47534 31.91595)';
								}
								if( ($index+1) == 5) {
									$translate_diagram = 'translate(621.30084 31.91595)';
								}
								$html .= '
								<li style="background-image: url('.assets_url('concerto/icons/diagram-potential-falls_'.($index+1).'_base.svg').'); background-position: center; background-repeat: no-repeat; background-size: 100% 100%; "
									class="uk-animation-slide-left-small '.( $PotentialFallsInfo->planting_potentialfalls_label == ($index+1) ? 'uk-active Kumar' : '' ).' "
									data-labe="'.( $PotentialFallsInfo->planting_potentialfalls_label).'">
									<svg id="_'.($index+1).'" data-name="'.($index+1).'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 700 460">
										<text id="outcomeValue'.($index+1).'" class="diagram-text-large"
											transform="translate(11.00012 51.38684)"> 
											<tspan x="0" y="0">'.$PotValue.'</tspan>
										</text>
										<text id="outcomeValue'.($index+1).'" class="diagram-text-large"
											transform="translate(173.8499 451.00047)">
											<tspan x="0" y="0">'.$vecFormatTroughList['mwdata'][0].'</tspan>
										</text>
										<text class="diagram-text-large" transform="'.$translate_diagram.'">
											<tspan x="0" y="0">'.$vecYearFormatLists[$index]['mwdata'][0].'</tspan>
										</text>
									</svg>
								</li>';
							}
						}
				$html .= '</ul>
			</div>			
			</div>			
			';
		}
		return $html;
	
	}
	public function loadPageHtml_runPotentialFalls_mobile($apiresponse, $columnName) {
		$apidata = $apiresponse['lhs'][0]['mwdata'];
		$txtOptionsInfoLists = $apidata['txtOptions'][0]['mwdata'];
		
		$html = '';
		if( isset($txtOptionsInfoLists) && !empty($txtOptionsInfoLists) ) {
			$PotValue = $apidata['FormatPotValue'][0]['mwdata'][0]['mwdata'][0];
			$txtOutput = $apidata['txtOutput'][0]['mwdata'][0]['mwdata'][0];
			$vecFormatTroughLists = $apidata['vecFormatTrough'][0]['mwdata'];
			$vecYearFormatLists = $apidata['vecYearFormat'][0]['mwdata'];

			$info = $this->concerto->getjtcinfo();
			$PotentialfallsColmn = $columnName.'_potentialfalls';
			$PotentialFallsInfo = json_decode($info->$PotentialfallsColmn);

			$html .= '
				<div class="uk-width-expand@m narrow-block-mobile">
                    <ul id="potential-falls-projections"
                        class="uk-switcher potential-falls-projections "
                        style="background-image: url('.assets_url('concerto/icons/diagram-potential-falls_base.svg').'); background-position: center; background-repeat: no-repeat; background-size: 100% 100%; ">';

						if( isset($vecFormatTroughLists)) {
							foreach($vecFormatTroughLists as $index=>$vecFormatTroughList ){
								$translate_diagram = '';
								if( ($index+1) == 1) {
									$translate_diagram = 'translate(241.29405 31.91595)';
								} 
								if( ($index+1) == 2) {
									$translate_diagram = 'translate(330.8382 31.91595)';
								} 
								if( ($index+1) == 3) {
									$translate_diagram = 'translate(496.99997 31.91595)';
								} 
								if( ($index+1) == 4) {
									$translate_diagram = 'translate(562.47534 31.91595)';
								}
								if( ($index+1) == 5) {
									$translate_diagram = 'translate(621.30084 31.91595)';
								}
								$html .= '
								<li style="background-image: url('.assets_url('concerto/icons/diagram-potential-falls_'.($index+1).'_base.svg').'); background-position: center; background-repeat: no-repeat; background-size: 100% 100%; "
									class="uk-animation-slide-left-small '.( $PotentialFallsInfo->planting_potentialfalls_label == ($index+1) ? 'uk-active Kumar' : '' ).' "
									data-labe="'.( $PotentialFallsInfo->planting_potentialfalls_label).'">
									<svg id="_'.($index+1).'" data-name="'.($index+1).'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 700 460">
										<text id="outcomeValue'.($index+1).'" class="diagram-text-large"
											transform="translate(11.00012 51.38684)"> 
											<tspan x="0" y="0">'.$PotValue.'</tspan>
										</text>
										<text id="outcomeValue'.($index+1).'" class="diagram-text-large"
											transform="translate(173.8499 451.00047)">
											<tspan x="0" y="0">'.$vecFormatTroughList['mwdata'][0].'</tspan>
										</text>
										<text class="diagram-text-large" transform="'.$translate_diagram.'">
											<tspan x="0" y="0">'.$vecYearFormatLists[$index]['mwdata'][0].'</tspan>
										</text>
									</svg>
								</li>';
							}
						}
				$html .= '</ul>
				</div>			
			</div>';

			$html .= '
			<input id="planting_potentialfalls_info" type="hidden" name="planting_potentialfalls_info" value="'. ( !empty($PotentialFallsInfo->planting_potentialfalls_info) ? $PotentialFallsInfo->planting_potentialfalls_info : '' ).'">
			<div class="uk-width-1-3@m growth-matrix">
				<h4 class="uk-text-light"><span uk-tooltip="title: Current plan value; delay: 50;pos: top-left;"> '.$txtOutput.'</span></h4>
				<ul class="uk-tab-left half-pill-button-left '.( empty($PotentialFallsInfo->planting_potentialfalls_label) ? 'remove-default-rquired-li' : '' ).'" uk-tab="connect: #potential-falls-projections;">';
					if( isset($txtOptionsInfoLists)) {
						$loopcount = 1;
						foreach($txtOptionsInfoLists as $index=>$txtOptionsInfoList ){
							$html .= '<li class="'.( $PotentialFallsInfo->planting_potentialfalls_label == $loopcount ? 'uk-active' : '' ).'"
								onclick="getbuttonvalue(this);" data-btnVal="'.$loopcount++.'" data-btnId="planting_potentialfalls_label" data-btnIdInfo="planting_potentialfalls_info" data-btnValInfo="'.$txtOptionsInfoList['mwdata'][0].'">
								<a>'.$txtOptionsInfoList['mwdata'][0].'</a>
							</li>';
					}
				}
				$html .= '</ul>
			</div>';

		}
		return $html;
	
	}

	public function loadriskresult_ApiCall() {
		$object = $this->input->post('current_age');
		$reset = $this->input->post('reset');
		
		$Contributions_per_annum = $this->input->post('Contributions_per_annum');
		$target_annual_income = $this->input->post('target_annual_income');
		$retirerment_age = $this->input->post('retirerment_age');
		$risknumber = $this->input->post('risknumber');

		if( isset($reset) && $reset == 'true' ) {
			$screen = $this->input->post('screen');
			$columnNames = explode('_', $screen);
			$columnName = $columnNames[0];

			$info = $this->concerto->getjtcinfo();
			$transInfo =  json_decode($info->contributing_background);
			$horizonInfo =  json_decode($info->contributing_horizon);
			$riskInfo =  json_decode($info->contributing_risk);
			$Contributions_per_annum = ( $columnName != 'contributing' ? 0 : $transInfo->Contributions_per_annum );
			$retirerment_age = $horizonInfo->retirerment_age;
			$risknumber = $riskInfo->risknumber;
			$target_annual_income = 5000;
		}
		$object = array('nargout'=>1,
			'rhs' => array(
				"logicalSolveRetirementIncome",$this->input->post('SolveRetirementIncome'),
				"sclrTargetAnnualIncome",( (int)$target_annual_income == 0 ? 1 : (int)$target_annual_income),
				"sclrCurrentAge",(int)$this->input->post('current_age'),
				"sclrRetirementAge",(int)$retirerment_age,
				"sclrRiskProfile",(int)$risknumber,
				"sclrCurrentPlanValue",(int)$this->input->post('current_plan_value'),
				"sclrMonthlyContributions",(int)$Contributions_per_annum,
				"sclrIncomeGoal",(int)$this->input->post('retirementincomegoal'),
			)
		);
		$modifiedJsonString = str_replace('"false"', 'false', json_encode($object));
		
		$lists = self::__getJTCApiAssetData($modifiedJsonString,'runSmallCashFlowModel1_1');
		$vecAssetValues0 = 0;$vecAssetValues1 = 0;$vecAssetValues2 = 0;$vecSolvedIncomeValue0 = 0;$vecSolvedIncomeValue1 = 0;$vecSolvedIncomeValue2 = 0;$sclrSolvedMonthlyContribution = 0;

		$errorMesage = '';
		if( !empty($lists) ) {
			$apiresponse = json_decode($lists);
			if( isset($apiresponse->error) ) {
				$errorMesage = $apiresponse->error->message;
			}
			$vecAssetValues0 = $apiresponse->lhs[0]->mwdata->vecAssetValues[0]->mwdata[0];
			$vecAssetValues1 = $apiresponse->lhs[0]->mwdata->vecAssetValues[0]->mwdata[1];
			$vecAssetValues2 = $apiresponse->lhs[0]->mwdata->vecAssetValues[0]->mwdata[2];

			$vecSolvedIncomeValue0 = $apiresponse->lhs[0]->mwdata->vecSolvedIncomeValue[0]->mwdata[0];
			$vecSolvedIncomeValue1 = $apiresponse->lhs[0]->mwdata->vecSolvedIncomeValue[0]->mwdata[1];
			$vecSolvedIncomeValue2 = $apiresponse->lhs[0]->mwdata->vecSolvedIncomeValue[0]->mwdata[2];

			$vecLogicThumbs1 = $apiresponse->lhs[0]->mwdata->vecLogicThumbs[0]->mwdata[0];
			$vecLogicThumbs2 = $apiresponse->lhs[0]->mwdata->vecLogicThumbs[0]->mwdata[1];
			$vecLogicThumbs3 = $apiresponse->lhs[0]->mwdata->vecLogicThumbs[0]->mwdata[2];

			$Indicator = $apiresponse->lhs[0]->mwdata->Indicator[0]->mwdata[0];

			$sclrSolvedMonthlyContribution = $apiresponse->lhs[0]->mwdata->sclrSolvedMonthlyContribution[0]->mwdata[0];
		}
		$indicatorHtml = '';
		if ($Indicator == 0) {
			$indicatorHtml = '
				<img src="'.assets_url('concerto/icons/rating-icon-bad-on.svg').'" width="32px" height="32px"/>
				<img src="'.assets_url('concerto/icons/rating-icon-average-off.svg').'" width="32px" height="32px"/>
				<img src="'.assets_url('concerto/icons/rating-icon-good-off.svg').'" width="32px" height="32px"/>
			';
		} else if ($Indicator == 1) {
			$indicatorHtml = '
				<img src="'.assets_url('concerto/icons/rating-icon-bad-off.svg').'" width="32px" height="32px"/>
				<img src="'.assets_url('concerto/icons/rating-icon-average-on.svg').'" width="32px" height="32px"/>
				<img src="'.assets_url('concerto/icons/rating-icon-good-off.svg').'" width="32px" height="32px"/>
			';
		} else if ($Indicator == 2) {
			$indicatorHtml = '
				<img src="'.assets_url('concerto/icons/rating-icon-bad-off.svg').'" width="32px" height="32px"/>
				<img src="'.assets_url('concerto/icons/rating-icon-average-off.svg').'" width="32px" height="32px"/>
				<img src="'.assets_url('concerto/icons/rating-icon-good-on.svg').'" width="32px" height="32px"/>
			';
		}
		$data = array(
			'resultinfo' => array(
				'vecAssetValues0' => (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$').number_format($vecAssetValues0),
				'vecAssetValues1' => (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$').number_format($vecAssetValues1),
				'vecAssetValues2' => (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$').number_format($vecAssetValues2),
				'vecSolvedIncomeValue0' => (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$').number_format($vecSolvedIncomeValue0),
				'vecSolvedIncomeValue1' => (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$').number_format($vecSolvedIncomeValue1),
				'ProjectedAnnualIncom' => number_format($vecSolvedIncomeValue1),
				'vecSolvedIncomeValue2' => (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$').number_format($vecSolvedIncomeValue2),
				'MonthlyContributionIncome' => number_format($sclrSolvedMonthlyContribution),
				'sclrSolvedMonthlyContribution' => (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$').number_format($sclrSolvedMonthlyContribution),
				'indicatorHtml' => $indicatorHtml,
				'vecLogicThumbs1' => ( !empty($vecLogicThumbs1) ? '<img src="'.assets_url('concerto/icons/rating-icon-good-on.svg').'" width="32px" height="32px"/>' : '<img src="'.assets_url('concerto/icons/rating-icon-bad-on.svg').'" width="32px" height="32px"/>'),
				'vecLogicThumbs2' => ( !empty($vecLogicThumbs2) ? '<img src="'.assets_url('concerto/icons/rating-icon-good-on.svg').'" width="32px" height="32px"/>' : '<img src="'.assets_url('concerto/icons/rating-icon-bad-on.svg').'" width="32px" height="32px"/>'),
				'vecLogicThumbs3' => ( !empty($vecLogicThumbs3) ? '<img src="'.assets_url('concerto/icons/rating-icon-good-on.svg').'" width="32px" height="32px"/>' : '<img src="'.assets_url('concerto/icons/rating-icon-bad-on.svg').'" width="32px" height="32px"/>')
			),
			'IsMobileBrowser' => IsMobileBrowser(),
			'errorMesage' =>$errorMesage,
			'reset' =>$reset,
		);
		echo json_encode($data);
	}
	public function loadRiskScreenResult_ApiCall() {
		$screen = $this->input->post('screen');
		if( !empty($screen) ) {
			$columnNames = explode('_', $screen);
			$columnName = $columnNames[0];
			$transparencyColmn = $columnName.'_background';
			$horizonColmn = $columnName.'_horizon';
			$growthColmn = $columnName.'_growth';
			$potentialfallsColmn = $columnName.'_potentialfalls';
			$regretColmn = $columnName.'_missing_out';
			$liquidityColmn = $columnName.'_liquidity';
			$info = $this->concerto->getjtcinfo();
			$transparencyInfo = json_decode($info->$transparencyColmn,true);

			$Contributions_per_annum = ($transparencyInfo['Contributions_per_annum'] <= 0 ? 10 : $transparencyInfo['Contributions_per_annum']);
			$horizonInfo = json_decode($info->$horizonColmn,true);
			$growthInfo = json_decode($info->$growthColmn,true);
			$potentialfallsInfo = json_decode($info->$potentialfallsColmn,true);
			$regretInfo = json_decode($info->$regretColmn,true);
			$liquidityInfo = json_decode($info->$liquidityColmn,true);
			$PotValue = $this->DefaultPortValue;
			$Pathwayreturn = $columnName == 'contributing' ? 'Planting' :  ($columnName == 'investing' ? 'Growing' :  ($columnName == 'withdrawing' ? 'Harvesting' : ucfirst($columnName)));
			$object = array('nargout'=>1,
				'rhs' => array(
					"Pathway",$Pathwayreturn,
					"PotValue",(int)$PotValue,
					"Experience",strtolower($transparencyInfo['Experience_investing']),
					"Knowledge",strtolower($transparencyInfo['Knowledge']),
					"DecisionMaker",strtolower($transparencyInfo['Investment_decision_maker']),
					"Income",(int)$transparencyInfo['Income_per_annum'],
					"Contributions",(int)$Contributions_per_annum,
					"MainSourceOfRetirementIncome",strtolower($transparencyInfo['Other_sources_of_income']),
					"Age",(int)$horizonInfo['current_age'],
					"RetirementAge",(int)$horizonInfo['retirerment_age'],
					"Growth",(int)$growthInfo['planting_growth_label'],
					"Fall",(int)$potentialfallsInfo['planting_potentialfalls_label'],
					"MissingOut",(int)$regretInfo['planting_regret_label'],
					"Liquidity",(int)$liquidityInfo['withdraw_percentage']
				)
			);
			$lists = self::__getJTCApiAssetData(json_encode($object),'runATR1_1');
			if( !empty($lists) ) {
				$apiresponse = json_decode($lists);
				$returnArray = array(
					'sclrRiskLevel' =>self::numberToWord($apiresponse->lhs[0]->mwdata->sclrRiskLevel[0]->mwdata[0]),
					'sclrRiskNumber' =>$apiresponse->lhs[0]->mwdata->sclrRiskLevel[0]->mwdata[0],
					'vecFalls' =>$apiresponse->lhs[0]->mwdata->vecFalls[0]->mwdata,
					'vecGrowth' =>$apiresponse->lhs[0]->mwdata->vecGrowth[0]->mwdata,
					'vecHorizon' =>$apiresponse->lhs[0]->mwdata->vecHorizon[0]->mwdata,
					'vecLiquidity' =>$apiresponse->lhs[0]->mwdata->vecLiquidity[0]->mwdata,
					'vecMissingOut' =>$apiresponse->lhs[0]->mwdata->vecMissingOut[0]->mwdata,
					'vecTransparency' =>$apiresponse->lhs[0]->mwdata->vecTransparency[0]->mwdata,
					'RiskDangerLabel' =>$this->RiskDangerLabel,
					'RiskCheckLabel' =>$this->RiskCheckLabel,
					'type' => encryptKey($columnName.'_risk'),
					'PotValue' => $PotValue,									
					'screen' => $columnName,									
					'message' => (isset($apiresponse->error) ? $apiresponse->error->message : ''),
					'httpredirect' => encryptKey(website_url('concerto/'.$columnName.'-results')),
				);
				echo json_encode($returnArray);
			}
		} else {
			echo json_encode(array('status'=>false, 'message'=>'screen not defined ro get result'));
		}
	}	
	static function numberToWord($number) {
		$words = array(
			0 => 'zero',
			1 => 'one',
			2 => 'two',
			3 => 'three',
			4 => 'four',
			5 => 'five',
			6 => 'six',
			7 => 'seven',
			8 => 'eight',
			9 => 'nine',
			10 => 'ten',
		);
		return isset($words[$number]) ? $words[$number] : '';
	}


	/** Report Generations */
	public function generate_report() {
		$screen = $this->input->post('screen');
		$RetirementGoal = ( !empty($this->input->post('RetirementGoal')) ? $this->input->post('RetirementGoal') : 20000);
		if( !empty($screen) ) {
			$columnNames = explode('_', $screen);
			$columnName = $columnNames[0];
			$transparencyColmn = $columnName.'_background';
			$horizonColmn = $columnName.'_horizon';
			$growthColmn = $columnName.'_growth';
			$regretColmn = $columnName.'_missing_out';
			$liquidityColmn = $columnName.'_liquidity';
			$riskColmn = $columnName.'_risk';
			$IntentionColm = 'contributing_pathway';
			$potentialfallsColmn = $columnName.'_potentialfalls';
			$ReportColmn = $columnName.'_report';

			$info = $this->concerto->getjtcinfo();
			$horizonInfo = json_decode($info->$horizonColmn,true);
			$transparencyInfo = json_decode($info->$transparencyColmn,true);
			$growthInfo = json_decode($info->$growthColmn,true);
			$regretInfo = json_decode($info->$regretColmn,true);
			$liquidityInfo = json_decode($info->$liquidityColmn,true);
			$riskInfo = json_decode($info->$riskColmn,true);
			$potentialfallsInfo = json_decode($info->$potentialfallsColmn,true);
			$IntentionInfo = $info->$IntentionColm;
			$currentCurrency = 'USD';
			if(isset($_COOKIE['selectedcurrencyvalue']) && $_COOKIE['selectedcurrencyvalue'] == '£') {
				$currentCurrency = 'GBP';
			}elseif(isset($_COOKIE['selectedcurrencyvalue']) && $_COOKIE['selectedcurrencyvalue'] == '€') {
				$currentCurrency = 'EUR';
			}elseif(isset($_COOKIE['selectedcurrencyvalue']) && $_COOKIE['selectedcurrencyvalue'] == '$') {
				$currentCurrency = 'USD';
			}
			$Pathwayreturn = $columnName == 'contributing' ? 'Planting' :  ($columnName == 'investing' ? 'Growing' :  ($columnName == 'withdrawing' ? 'Harvesting' : ucfirst($columnName)));
			$IntentionInfo = $IntentionInfo == 'FlexibleIncome' ? 'Flexible Income' :  ($IntentionInfo == 'CashLumpSum' ? 'Cash Lump Sum' :  ($IntentionInfo == 'Annuity' ? 'Annuity' : $IntentionInfo));

			$Contributions_per_annum = ($columnName == 'contributing' ? $transparencyInfo['Contributions_per_annum'] :  0);

			$object = array('nargout'=>1,
				'rhs' => array(
					"Organisation",$this->OrganisationName,
					"PotValue",(int)$this->DefaultPortValue,
					"Age",(int)$horizonInfo['current_age'],
					"Currency",$currentCurrency,
					"Pathway",$Pathwayreturn,
					"Intention",$IntentionInfo,
					"Experience",strtolower($transparencyInfo['Experience_investing']),
					"Knowledge",strtolower($transparencyInfo['Knowledge']),
					"DecisionMaker",strtolower($transparencyInfo['Investment_decision_maker']),
					"Income",(int)$transparencyInfo['Income_per_annum'],
					"Contributions",(int)$Contributions_per_annum,
					"MainSourceOfRetirementIncome",strtolower($transparencyInfo['Other_sources_of_income']),
					"RetirementAge",(int)$horizonInfo['retirerment_age'],
					"Growth",(int)$growthInfo['planting_growth_label'],
					"Fall",(int)$potentialfallsInfo['planting_potentialfalls_label'],
					"MissingOut",(int)$regretInfo['planting_regret_label'],
					"Liquidity",(int)$liquidityInfo['withdraw_percentage'],
					"RiskOutput",(int)$riskInfo['risknumber'],
					"RetirementGoal",(int)(str_replace(',','',$RetirementGoal)),
				)
			);
			$lists = self::__getJTCApiAssetData(json_encode($object),'runConcertoReport');
			if( !empty($lists) ) {
				ini_set('max_execution_time', 300); 
				ini_set('memory_limit', '256M');
				ini_set('output_buffering', 'On');
				ini_set('zlib.output_compression', 'Off');

				$apiresponse = json_decode($lists);
				$blobDataArray = $apiresponse->lhs[0]->mwdata->Report[0]->mwdata->BlobData_pdf_Encoded[0]->mwdata[0];
				$ReportType = $apiresponse->lhs[0]->mwdata->SRATable[0]->mwdata->BlobData_Type[0]->mwdata[0];
				$ReportPath = $apiresponse->lhs[0]->mwdata->pathReport[0]->mwdata[0];

				$blobDataString = preg_replace('/^string\(\d+\)\s*/', '', $blobDataArray);
				$blobDataString = trim($blobDataString, '"');
				$blobDataArray = json_decode($blobDataString, true);
				$binaryData = '';
				foreach ($blobDataArray as $byte) {
					$binaryData .= chr($byte);
				}

				$filePath = date('Ymd').'_JTC_Concerto_Report.pdf';
				$dircpath =  FCPATH. 'assets'. DIRECTORY_SEPARATOR .'concerto'. DIRECTORY_SEPARATOR .'reports'. DIRECTORY_SEPARATOR . $filePath ;
				$result = file_put_contents($dircpath, $binaryData);

				$unlinkOldFiles = $dircpath =  FCPATH. 'assets'. DIRECTORY_SEPARATOR .'concerto'. DIRECTORY_SEPARATOR .'reports'. DIRECTORY_SEPARATOR . date('Ymd',strtotime('-1 day', strtotime(date('Y-m-d')))).'_JTC_Concerto_Report.pdf';
				if(file_exists($unlinkOldFiles)) {
					unlink($unlinkOldFiles);
				}
				
				if ($result === false) {
					$error = error_get_last();
					echo json_encode(array('status'=>false, 'message'=>'Issue with file generations'));
				} else {
					$JTCparameters[$ReportColmn] = date('d M Y H:i A');
					$this->concerto->UpdateJtcToolnfo($JTCparameters);
					$this->concerto->UpdateJtcToolnfoHistory($JTCparameters);
					echo json_encode(array('status'=>true,'request'=>json_encode($object),'http_redirect' =>assets_url('reports/'.urlencode($filePath)), 'message'=>'PDF file has been successfully created'));
				}
			}
		}
	}
}
?>