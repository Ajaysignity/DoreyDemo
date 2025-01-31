<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/FrontEndController.php';

class Cashflow extends FrontEndController {
	
	const API_URL = "https://doreyappproduction.com/DecumulationTools1_24g/";
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('solutions'));
		$this->load->model([
			'Solution_model' => 'solutions', 
			'Cashflow_model' => 'cashflows', 
			'Assumptions_model' => 'assumptions'
		]);
		$this->tokenkey = decryptKey($this->input->get('tokenkey'));
	}
	
	public function index() {
		$tokenkey = decryptKey($this->input->get('tokenkey'));
		$datainfo  = $this->solutions->getsolutionInfo($this->userid,$tokenkey);
		$UserInfo = $this->auth->getuserinfo($this->userid);
		$assumptionlistscount = $this->assumptions->checkunique_modals($this->organisation);
		if($assumptionlistscount){
			$assumptionlists = $this->assumptions->getunique_modals($this->organisation);
		}else{
			$assumption_params = array(
				"assumption_name"=> "Development Balance Sheet",
				"userid"=> $this->userid,
				"organisation"=> $this->organisation,
				"assets_data"=> defaultAssumptionData(),
				"status"=> "review",
				"referred_date"=> date("d/m/Y"),
			);
			$assumptionSaved = $this->assumptions->insertunique_modals($assumption_params);
			$assumptionlists = $this->assumptions->getunique_modals($this->organisation);
		}
		$data = array(
			'info' =>$datainfo,
			'UserInfo' => $UserInfo,
			'tokenkey' => $this->input->get('tokenkey'),
			'typebeginlists' => DefaulTypeBeginData(),
			'withsecuritylists' => DefaultTypePercentileslData(),
			'TypeOverallStrategy' => DefaultStrategyDropdownData(),
			'timelistdropdown' => goalseekprojectionAtTime(),
			'Defaultgoalseekprojection' => DefaultgoalseekprojectionAtTime(),
			'assumptionlists' =>$assumptionlists,
			'title' =>$datainfo->Solution.' | '.$this->title
		);
		$view = $this->template.'/cashflowmodel/solutoinshtml';
		$this->load->view('authlayouthtml',  array('data'=>$data,'views'=> $view));
	}
	static function encodeURIComponent($Parameters) {
		$liveVariables= urldecode($Parameters);	
	 	$data = json_decode($liveVariables,true);
		return $data[0];
	}
	public function LoadSolnParameters( $idusersolutions ){
		$datainfo  = $this->solutions->getsolutionInfo($this->userid,$idusersolutions);
		$data['info'] = $datainfo;
		$data['title']  = $datainfo->Solution.' | '.$this->title;
		$args = array(
			'Parameters' => $datainfo->Parameters,
			'idusersolutions' => $datainfo->idusersolutions,
			'Solution' => $datainfo->Solution,
			'Type' => $datainfo->Type,
		);
		$Parameters = $args["Parameters"];
		$liveVariables= urldecode($Parameters);
		$datasoln = json_decode($liveVariables,true);
		$datasoln["solnRow"] = $args["idusersolutions"];         
		$data["Model"] = $args["Type"]; 
		$datasoln["Model"] = $args["Type"];                             
		$datasoln["ClientName"] = $args["Solution"];
		$Parameters = rawurlencode(json_encode($datasoln));
		return $Parameters;
	}
	public function exportsolutions(){
		$this->load->helper('download');
		$tokenkey = $this->tokenkey;
		$objectDataa = $this->cashflows->get_solutionsparams($tokenkey);	
		$objectDataaa = urldecode($objectDataa['Parameters']);
		$objectDataArr = json_decode($objectDataaa, true);

		//print_r($objectDataArr); 

		// file name 
		$filename = 'cashflow_'.date('Ymdhis').'.csv'; 
		$header = array();
		foreach ($objectDataArr as $key=>$line){ 
			array_push($header, $key);
		}
		
		$file = fopen('php://output', 'w');
        fputcsv($file, $header);
		$t= array();
		foreach ($objectDataArr as $key=>$line){ 
			
			if(is_array($line)){
				if($key == 'TypeYearStrategy' || $key == 'TypeOverallStrategy' || $key == 'TypeGlideOrFixedStrategy' || $key == 'vecSolverInputFinalAmount'){
				
					if($key == 'TypeYearStrategy'){
						
						$startarr = array();
						$startbeginlists = goalseekprojectionAtTime();
						foreach($objectDataArr[$key] as $ky => $flow  ) {
							foreach($flow as $flowKey=> $value ){  
								foreach($startbeginlists as $startKey=> $title ){  
									if($startKey == $value){ $val = $title;  }
								}	
								array_push($startarr, $val);
							}
						}
						$l = implode(',', $startarr);
						array_push($t, $l);
						

					}else if($key == 'TypeOverallStrategy' ){ 	
						$strategyarr = array();
						$strategyDropdownlists = DefaultStrategyDropdownData();
						foreach($objectDataArr[$key] as $ky => $flow  ) {
							foreach($flow as $flowKey=> $value ){  
								foreach($strategyDropdownlists as $strategyKey=>  $strategytitle ){  
									if($strategyKey == $value){ $val = $strategytitle;  }
								}
								array_push($strategyarr, $val);
							}	
						}
						$l = implode(',', $strategyarr);
						array_push($t, $l);
					

					}else{
						$ln_arr = array();
						foreach ($objectDataArr[$key] as $ky => $value) {
						
							$l = implode(',', $value);
							array_push($ln_arr, $l);
						}						
						array_push($t, implode(',', $ln_arr));
					}
					
				}else{
					if($key == 'InflowOutflow'){
						$inflowOutflowarr= array();
						foreach($objectDataArr[$key] as $ky => $flow  ) {
							if($flow == 0){ $val = 'inflow';  }else{ $val = 'outflow'; }
							array_push($inflowOutflowarr, $val);
						}
						$l = implode(',', $inflowOutflowarr);
						array_push($t, $l);

					}else if($key == 'Start' || $key == 'TypeEnd'){
						$startarr= array(); 
						$startbeginlists = goalseekprojectionAtTime();
						foreach($objectDataArr[$key] as $ky => $flow  ) {
							foreach($startbeginlists as $startKey=> $title ){  
								if($startKey == $flow){ $val = $title;  }
							}
							array_push($startarr, $val);
						}
						$l = implode(',', $startarr);
						array_push($t, $l);
					}else if($key == 'Type'){
						$Typearr= array(); 
						$typebeginlists = DefaulTypeBeginData();
						foreach($objectDataArr[$key] as $ky => $typeflow  ) {
							$typevalue=0;
							foreach($typebeginlists as $typeKey=> $title ){  
								if($typevalue == $typeflow){ $val = $typeKey;  }
								$typevalue++;
							}
							array_push($Typearr, $val);
						}
						$l = implode(',', $Typearr);
						array_push($t, $l);
					}else{
						$l = implode(',', $line);
						array_push($t, $l);
					}					
				}				
			}else{
				array_push($t, $line);
			}			
		}
		fputcsv($file, $t); 		

		header('Content-Description: File Transfer');
		header('Content-Type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($filename));

		$data = file_get_contents('php://output'); 
		force_download($filename, $data);
		fclose($file); 
		exit; 
	}

	public function get_doc_html(){
		$orderdata = array();
		$view = $this->template.'/cashflowmodel/exportdochtml'; 
		$stringg = $this->load->view($view, $orderdata, false);
		return $stringg;
	}
	public function exportdocsolutions_(){
		$phpWord = new PhpOffice\PhpWord\PhpWord(); //initilize object
		\PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);


		// Adding an empty Section to the document...
		$section =  $phpWord->addSection();
		$orderhtml = $this->get_doc_html(); //call html file
		
	    // print_r($orderhtml->output);
		// echo 'HTML>>>  '.$orderhtml->output->final_output;
		// die;
		
		\PhpOffice\PhpWord\Shared\Html::addHtml($section, $orderhtml->output->final_output, true, true);

		$file = "cashflow_report_".date("ddmmyyhis").'.docx';
		header("Content-Description: File Transfer");
		header('Content-Disposition: attachment; filename="' . $file . '"');
		header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
		header('Content-Transfer-Encoding: binary');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Expires: 0');		
		ob_clean();
	
		$phpWord->save("php://output", "Word2007");
		ob_end_clean();
		exit;
	}


	public function exportdocsolutions(){
		$phpWord = new PhpOffice\PhpWord\PhpWord(); //initilize object
		$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('template_CashflowReport_Cashflow.docx');
		\PhpOffice\PhpWord\Settings::setDefaultPaper('Letter');
		\PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
		//get current user cashflow data
		$tokenkey = decryptKey($this->input->get('tokenkey'));
		$objectDataa = $this->cashflows->get_solutionsparams($tokenkey);	
		$objectDataaa = urldecode($objectDataa['Parameters']);
		$objectDataArr = json_decode($objectDataaa, true);
			//print_r($objectDataArr); die;

		//Set values in template
		$templateProcessor->setValue('current_date', date("d M, Y"));
		$templateProcessor->setValue('modal_title', $objectDataArr['ClientName']);
		$templateProcessor->setValue('age', $objectDataArr['Age']);
		$templateProcessor->setValue('retirement_age', $objectDataArr['RetirementAge']);
		$templateProcessor->setValue('projection_age', $objectDataArr['ProjectionHorizon']);

		//Table row style
		$fancyTableFontStyle = ['size' => 10,'name' => 'Verdana', 'color' => '#FFFFFF']; 
		$fancyTableFontStyleHeader = ['size' => 10,'name' => 'Helvetica', 'color' => '#000000']; 
		$fancyTableFontStyleAssumtion = ['size' => 7,'name' => 'Verdana', 'color' => '#FFFFFF']; 

		//Add cashFlow data in table
		$rows = count($objectDataArr['InputLabel']);
		$cols = 7;
		$t=0; 
		$wordTable = new \PhpOffice\PhpWord\Element\Table();
		for ($r = 1; $r <= $rows; ++$r) {
			$wordTable->addRow();
			$row_arr = array();
			$cashFlow_name = $objectDataArr['InputLabel'][$t];
			$InflowOutflow = ($objectDataArr['InflowOutflow'][$t] == '0')? 'Inflow' : 'Outflow';
			$CashFlowArr = '£'.$objectDataArr['CashFlowArr'][$t];
			//$cashFlow_pot_name = $objectDataArr['PotOptions'][$t];
			$TypePot = $objectDataArr['TypePot'];

			if($TypePot != ''){
				$tr = str_replace("[","", $TypePot);
				$h = str_replace("]","", $tr);
				$hh = explode(",", $h);		
				$cashFlow_pot_name = $objectDataArr['PotOptions'][$hh[$t]];
			}
			//die;
			$cashFlow_type = $objectDataArr['Type'][$t];
			$cashFlow_type_val = '';

			$typebeginlists = DefaulTypeBeginData();
			$typevalue=0; 
			foreach($typebeginlists as $startKey=> $title ){  
				if($typevalue == $cashFlow_type ){ $cashFlow_type_val = $startKey;  }
				$typevalue++;
			}	
			 
			$cashFlow_start = $objectDataArr['Start'][$t];
			$cashFlow_start_val = '';

			$cashFlow_end = $objectDataArr['TypeEnd'][$t];
			$cashFlow_end_val = '';

			$startbeginlists = goalseekprojectionAtTime();
			foreach($startbeginlists as $startKey=> $title ){  
				if($startKey == $cashFlow_start){ $cashFlow_start_val = $title;  }
				if($startKey == $cashFlow_end){ $cashFlow_end_val = $title;  }
			}
			array_push($row_arr, $cashFlow_name, $InflowOutflow, $CashFlowArr, $cashFlow_type_val, $cashFlow_start_val, $cashFlow_end_val, $cashFlow_pot_name);
			
			
			$col=0;
			for ($c = 1; $c <= $cols; ++$c) {
				$wordTable->addCell(1800, ['bgColor' => '#6f99be'])->addText($row_arr[$col], $fancyTableFontStyle);
				$col++;
			}
			$t++;
		}				
		$templateProcessor->setComplexBlock('CashFlowTableData', $wordTable);


		//Add Fee Modal data in table
		$rows = count($objectDataArr['PotOptions']);
		$cols = 5;
		$t=0; 
		$wordTable = new \PhpOffice\PhpWord\Element\Table();
		for ($r = 1; $r <= $rows; ++$r) {
			$wordTable->addRow();
			$row_arr = array();
			$FundExpenses = $objectDataArr['FundExpenses'][$t] *100;
			$FundTax = $objectDataArr['FundTax'][$t];
			$cashFlow_pot_name = $objectDataArr['PotOptions'][$t];
			$FeeModelPot = $objectDataArr['FeeModelPot'][$t];
			$FeeModelPot_val = '';
			if($FeeModelPot == 1){
				$FeeModelPot_val =  "Standard";
			}else if($FeeModelPot == 2){
				$FeeModelPot_val =  "Wealth";
			}else if($FeeModelPot == 3){
				$FeeModelPot_val =  "Bespoke";
			}
			
			array_push($row_arr, $cashFlow_pot_name, 'Normal markets', $FeeModelPot_val, $FundExpenses.'%', $FundTax.'%');
			$col=0;
			for ($c = 1; $c <= $cols; ++$c) {
				$wordTable->addCell(1800, ['bgColor' => '#6f99be'])->addText($row_arr[$col], $fancyTableFontStyle);
				$col++;
			}
			$t++;
		}				
		$templateProcessor->setComplexBlock('FeeModalTableData', $wordTable);

        //print_r($objectDataArr['TypeOverallStrategy']);
		//Add Investment strategy data in table
		$rows = count($objectDataArr['TypeOverallStrategy'])+1;
		$cols = count($objectDataArr['TypeOverallStrategy'])+1;
		//$colss = $cols;
		$colss = 0;
		$t=0;  $t1=0; 
		$wordTable = new \PhpOffice\PhpWord\Element\Table();
		for ($r = 1; $r <= $rows; ++$r) {
			$wordTable->addRow();
			$row_arr = array();
			if($r ==1){
				$cashFlow_pot_name = 'Pot';
				$now_age = 'Now: at age '.$objectDataArr['Age'];
				
				array_push($row_arr, $cashFlow_pot_name, $now_age);
				for($y=0;  $y < count($objectDataArr['TypeYearStrategy'][$t]); $y++ ){
					if($y > 0){
						$typeyeardata = goalseekprojectionAtTime();
						foreach($typeyeardata as $key => $value){
							if($key == $objectDataArr['TypeYearStrategy'][$t][$y]){
								array_push($row_arr, "At age ".$value);
								$colss = $colss +1;
							}
						}						
					}					
				}
				$end_age = 'End: at age '.$objectDataArr['RetirementAge'];
				array_push($row_arr, $end_age);
				$colss = $colss +3;
				//print_r($row_arr); die;
			}else{
				$cashFlow_pot_name = $objectDataArr['PotOptions'][$t];
				array_push($row_arr, $cashFlow_pot_name );
				$DropdownDatalists = DefaultStrategyDropdownData();				
				for($y=0;  $y < count($objectDataArr['TypeOverallStrategy'][$t]); $y++ ){
					foreach($DropdownDatalists as $key => $value){
						if($key == $objectDataArr['TypeOverallStrategy'][$t][$y]){
							array_push($row_arr, $value.", continue with →");
						}
					}						
										
				}
				$t1++;
	
				$end_age = '→|';				
				array_push($row_arr, $end_age);
				$t++;
			}
			
			
			$col=0;  //secho 'col>> '.$colss; die;
			for ($c = 1; $c <= $colss; ++$c) {
				//if($r == 1 && $c == 1 || $r == 1 && $c == 2 || $r == 1 && $c == 3){
				if($r == 1 && $colss-1){
					//echo "z val:: ".$colss.' --'. $z++;
					$wordTable->addCell(1800)->addText($row_arr[$col], $fancyTableFontStyleHeader);
				}else{
					$wordTable->addCell(1800, ['bgColor' => '#6f99be'])->addText($row_arr[$col], $fancyTableFontStyle);
				}				
				$col++;
			}
			
		}				
		$templateProcessor->setComplexBlock('StrategyModalTableData', $wordTable);

		//Assumptions data
		$assumptionlists = $this->assumptions->getunique_modalsByOrganistion($this->organisation);
		$datainfo = $this->assumptions->getassumptionInfo($this->organisation, $assumptionlists[0]->autoid);
		$asset_data = json_decode($datainfo->assets_data);
		//print_r($asset_data); die;
		$templateProcessor->setValue('assumption_name', $datainfo->assumption_name);
		$templateProcessor->setValue('referred_date', $datainfo->referred_date);		
		
		//get peroperty array -cash debt
		$property_arr= array();
		foreach($asset_data->asset_class as $key => $asset_name){
			array_push($property_arr, $key);
		}
		//get portfolio array - cash defensive
		$portfolio_arr= array();
		foreach($asset_data->portfolios as $key => $portfolio_name){
			array_push($portfolio_arr, ucwords(strtolower($key)) );
		}
		//print_r($property_arr); 
		//print_r($portfolio_arr); 
	
		$color_arr= array("#77bd8a", "#437340", "#4bbcd2", "#1b5d75", "#1e2447", "#303080", "#5c3288", "#ef8496", "#fe1d43", "#f6a651", "#fed300");
		//$portfolio_arr= DefaultStrategyDropdownData();
		$rows = count($portfolio_arr)+1;
		$cols = count($property_arr)+1;
		$t=0; 
		$wordTable = new \PhpOffice\PhpWord\Element\Table();
		for ($r = 0; $r <= $rows; ++$r) {
			$wordTable->addRow();
			$row_arr = array();
			
			if($r == 0){
				$_name =   "Asset Class";
				$_name1 =   "Asset Return 5 years";
				array_push($row_arr, $_name, $_name1);
				for($m=0; $m< count($portfolio_arr); $m++){

					//$_name1= strtoupper($portfolio_arr[$m]);
					$_name= $portfolio_arr[$m];
					//$_val = $asset_data->portfolios->{$_name1}[$t]->{$_name};
				
					array_push($row_arr, $_name);
				}	
				//print_r($row_arr); die;
				$col=0;
				for ($c = 1; $c <= $cols; ++$c) {
					//echo "<br>Row>> ".$row_arr[$col];
					$wordTable->addCell(900)->addText($row_arr[$col], $fancyTableFontStyleHeader);
					$col++;
				}
				$t=0; 
			}else{
				
			
				$_name =   $property_arr[$t];
				$_name1= strtoupper($_name);
				$val_asset = $asset_data->asset_class->{$_name}->asset_fiveyear;
				array_push($row_arr, $_name, $val_asset);
				for($m=0; $m< count($portfolio_arr); $m++){

					$_name1= strtoupper($portfolio_arr[$m]);
					$_name= $property_arr[$t];
					$_val = $asset_data->portfolios->{$_name1}[$t]->{$_name};
				
					array_push($row_arr, $_val);
				}			
			
				$col=0;
				for ($c = 1; $c <= $cols; ++$c) {
					//echo "<br>Row>> ".$row_arr[$col];
					$wordTable->addCell(1000, ['bgColor' => $color_arr[$t] ])->addText($row_arr[$col], $fancyTableFontStyleAssumtion);
					$col++;
				}
				$t++;
			}
			
		}				
		$templateProcessor->setComplexBlock('AssumptionModalTableData', $wordTable);
		

		$filename = "cashflow_reportModal_".date("ddmmyyhis").'.docx';
		$templateProcessor->saveAs($filename);
		header("Content-disposition: attachment;filename=" . $filename . " ; charset=iso-8859-1");
		echo file_get_contents($filename);	
		unlink($filename);	
		exit;		
	}

	public function get_assumption_info () {
		$assumption_id = $this->input->get("assumption_id");	
		$datainfo = $this->assumptions->getassumptionInfo($this->organisation, $assumption_id);
		
		$assets_data = json_decode($datainfo->assets_data,true);
		
		$color_arr= [119, 190, 139] ;
		foreach( $assets_data['asset_class'] as $classkey=>$assets ) {
			$asset_class[] = array(
				'Name' =>$classkey,
				'Colour' => $color_arr
			);	
			settype($assets['asset_fiveyear'], "double");
			settype($assets['asset_sixyear'], "double");
			$AssetReturnFive[] = $assets['asset_fiveyear'];
			$AssetReturnSix[] = $assets['asset_sixyear'];
		}
		// \"DrawdownSequence\":[[0.11],[-15.75,18.7],[-14.21,15.63],[-18.86,-1.66,22.33,3.58],[-20.7,-2.24,24.2,4.19],[-22.69,-3.15,26.04,6.07],[-24.89,-3.85,28.19,11.51],[-15.2,-14.13,-7.2,17.96,7.01,18.57],[-16.67,-15.16,-7.79,18.36,7.29,18.96,4.39],[-22.39,-18.1,-11.28,20.22,7.93,22.33,14.22]]
		$AssetAllocationsArray = array();$AssetAllocations = array();$AssetClassMix = array(); $AssetClassMixName = array();
		foreach( $assets_data['portfolios'] as $AssetClassName=>$portfolio_value ) {
			$AssetAllocationsArray[] = call_user_func_array('array_merge', $portfolio_value);
			$AssetClassMix[] = $AssetClassName;
			$AssetClassMixName[] = $AssetClassName;
			
		}
		foreach( $AssetAllocationsArray as $fields=> $AssetAllocationsValue ) {
			foreach( $AssetAllocationsValue as $key=> $AssetAllocationsValues ) {
				$AssetAllocationsValues = NumberFormat( $AssetAllocationsValues, 2);
				settype( $AssetAllocationsValues, 'double');
				$AssetAllocations[$fields][] = $AssetAllocationsValues;
			}
		}
		//echo '<pre/>';
		//echo 'asset_class:: '; print_r($AssetReturnFive);

		
		foreach( $assets_data['portfolioitrs'] as $classkey=>$assets ) {
			settype($assets['portfolioitr_riskname'], "double");
			settype($assets['portfolioitr_fiveyear'], "double");
			settype($assets['portfolioitr_sixyear'], "double");
			$PortfolioRisk[] = $assets['portfolioitr_riskname'];
			$ReturnActiveFive[] = $assets['portfolioitr_fiveyear'];
			$ReturnActiveSix[] = $assets['portfolioitr_sixyear'];
			$DrawdownSequenceFive[] = $assets['portfolioitr_yearone'];
			$DrawdownSequenceSix[] = $assets['portfolioitr_yeartwo'];
			$DrawdownSequences[] = $assets['drawanyears'];
		}
		
		$InflationsFive = !empty($assets_data['portfolioitrs']['Inflation']['portfolioitr_fiveyear']) ? $assets_data['portfolioitrs']['Inflation']['portfolioitr_fiveyear']: 3.9;
		$InflationsSix = !empty($assets_data['portfolioitrs']['Inflation']['portfolioitr_sixyear']) ? $assets_data['portfolioitrs']['Inflation']['portfolioitr_sixyear']: 2;

		array_shift($PortfolioRisk);
		array_shift($ReturnActiveFive);
		array_shift($ReturnActiveSix);
		array_shift($DrawdownSequenceFive);
		array_shift($DrawdownSequenceSix);
		array_shift($DrawdownSequences);

		settype($InflationsFive, "double");
		settype($InflationsSix, "double");
		$portfolioObj05yrs = array(
			'ModelDate'=> $datainfo->referred_date,
			'ForecastYearStart'=>array(0),
			'PortReturn'=>$ReturnActiveFive,
			'AssetReturn'=>$AssetReturnFive,
			'PortfolioRisk'=>$PortfolioRisk,
			'Inflation'=> array($InflationsFive),
			'AssetAllocation'=>$AssetAllocations,
			'CalculateReturns'=>false
		);
		$portfolioObj06yrs = array(
			'ModelDate'=> $datainfo->referred_date,
			'ForecastYearStart'=>array(6),
			'PortReturn'=>$ReturnActiveSix,
			'AssetReturn'=>$AssetReturnSix,
			'PortfolioRisk'=>$PortfolioRisk,
			'Inflation'=> array($InflationsSix),
			'AssetAllocation'=>$AssetAllocations,
			'CalculateReturns'=>false
		);
		//print_r($DrawdownSequenceSix);
		
		//echo 'FivportfolioObj05yrse arr:: '; print_r($portfolioObj05yrs); 
		//echo 'Six arr:: '; print_r($DrawdownSequenceSix);
		//echo 'DrawdownSequences arr:: '; print_r($DrawdownSequences);

		
		$out = array();

        for ($i=0; $i <count($DrawdownSequenceFive); $i++) { 
			$arr = array();
			if($DrawdownSequenceSix[$i] == 'recovery' || $DrawdownSequenceSix[$i] == ''){
				settype($DrawdownSequenceFive[$i], "double");
				array_push($arr, $DrawdownSequenceFive[$i]);
			}else{
				settype($DrawdownSequenceFive[$i], "double");
				settype($DrawdownSequenceSix[$i], "double");
				array_push($arr, $DrawdownSequenceFive[$i], $DrawdownSequenceSix[$i]);
			}			
			for ($j=0; $j< count($DrawdownSequences[$i]); $j++) { 
				if($DrawdownSequences[$i][$j] == 'recovery' || $DrawdownSequences[$i][$j] == ''){
					//nothing...
				}else{
					settype($DrawdownSequences[$i][$j], "double");
					array_push($arr, $DrawdownSequences[$i][$j]);
				}		
			}
			array_push($out, $arr);
		}			

		$returnArray = array(
			'UseObject' => 'true',
			'Title' => $datainfo->assumption_name,
			'AssetInfo' => $asset_class,
			'Assumptions' => array($portfolioObj05yrs,$portfolioObj06yrs),
			//'AssetClassMix' => $AssetClassMix,
			'AssetClassMix' => $AssetAllocations,
			'AssetClassMixName' => $AssetClassMixName,
			'DrawdownSequence' => $out,
		);
		// $returnArray = array(
		// 	json_encode('UseObject') => 'true',
		// 	json_encode('Title') => json_encode($datainfo->assumption_name),
		// 	json_encode('AssetInfo') => json_encode($asset_class),
		// 	json_encode('Assumptions') => json_encode(array($portfolioObj05yrs,$portfolioObj06yrs)),
		// 	json_encode('AssetClassMix') => json_encode($AssetClassMix),
		// 	json_encode('DrawdownSequence') => json_encode($out),
		// );
		//print_r($returnArray);
		echo json_encode($returnArray); die;
	}

	public function collection_alltype_data( $selected = NULL){
		$Risk  = array(0.6,5.9,6.5,8.6,9.9,11.2,12.4,14.7,15.5,18.7);
		$ReturnPassive  = array(0,4.65,4.68,4.98,5.02,5.05,5.13,5.04,5.07,4.94);
		$ReturnActive  = array(0,6.95,6.98,7.28,7.32,7.35,7.43,7.34,7.37,7.24);
		$objectData = self::encodeURIComponent($this->input->post('obj'));
		$SettingsObjectData = self::encodeURIComponent($this->input->post('settingObj'));
	    $tokenkey =  $objectData['solnRow'];	
	    $objectType = $this->input->post('type');	
		$objectothersData = self::encodeURIComponent($this->input->post('others'));
		//print_r($objectothersData ); die('>>>>>>>');
		$objectData["timestamp"] = date('d F Y, h:i:s A');
		$Return = ($objectData['AssumptionsSet2Use'] == 0 ? $ReturnPassive : $ReturnActive);
		if(is_array($objectothersData['	'])){
			$GoalSeekPotValue= $objectothersData['GoalSeekPotValue'];
		} else {
			$GoalSeekPotValue= (int)$objectothersData['GoalSeekPotValue'];
		}	

		$GoalSeekPotValue = ($objectothersData['GoalSeekPotValue'] != 0 )? $objectothersData['GoalSeekPotValue'] : [];

		$objectothersData['GoalSeekTime'] = ($objectothersData['GoalSeekTime'] != null)? $objectothersData['GoalSeekTime'] : [];
		$objectothersData['GoalSeekPercentile'] = ($objectothersData['GoalSeekPercentile'] != null)? $objectothersData['GoalSeekPercentile'] : [];
		$objectothersData['GoalSeekRealNominal'] = ($objectothersData['GoalSeekRealNominal'] != null)? $objectothersData['GoalSeekRealNominal'] : [];
		$objectothersData['sclrSolveInput'] = ($objectothersData['sclrSolveInput'] != null)? $objectothersData['sclrSolveInput'] : 0;


		//$objectDataSaved = $this->cashflows->Updated_solutionsparams($tokenkey, array( 'Parameters' => urlencode(json_encode($objectData) )  ) );					

		//check info exits or not in DB
		$checkExits = $this->cashflows->check_solutionsparams($tokenkey);
		if($checkExits === true){
			if($objectType == 'update')	{ 
				$objectDataSaved = $this->cashflows->Updated_solutionsparams($tokenkey, array( 'Parameters' => urlencode(json_encode($objectData) ), "DateTime_Last_Accessed" => date('Y-m-d, h:i:s ')  ) );				
					
			}
			if($objectType == 'setting_update')	{ 				
				$SettingsobjectDataSaved = $this->cashflows->Updated_solutionsparams($tokenkey, array( 'Solution_Parameters' => urlencode(json_encode($SettingsObjectData) ), "DateTime_Last_Accessed" => date('Y-m-d, h:i:s ')  ) );				
			}
			$objectDataa = $this->cashflows->get_solutionsparams($tokenkey);	
			//print_r($objectDataa); 

			$objectDataaa = urldecode($objectDataa['Parameters']);
			$objectDataArr = json_decode($objectDataaa, true);
			//echo '--------------';
		    //print_r($objectDataaa); die;
		
			$SolutionObjectData =  json_decode(urldecode($objectDataa['Solution_Parameters']), true);
			//get type Data

			$typebeginlists = DefaulTypeBeginData();
			if( isset($typebeginlists) && !empty($typebeginlists)){
				$str_type = [];
				for ($i=0; $i <count($objectDataArr['Type']); $i++) { 
					$typevalue=0;
					foreach($typebeginlists as $text=> $title ){ 
						if( $typevalue == $objectDataArr['Type'][$i]){
							array_push($str_type, $text);
						}
						$typevalue++;
					}
				}
			};	
			$others['Type'] = $str_type;	

			//print_r($objectDataArr); die;

			$this->sendResponse_db($objectDataArr, $objectothersData, $GoalSeekPotValue, $Risk, $Return, $others['Type'], $SolutionObjectData);
		}else{			
			$this->sendResponse($objectData, $objectothersData, $GoalSeekPotValue, $Risk, $Return, $SolutionObjectData);
		}			
	}
	static function sendResponse_db($objectData,$objectothersData, $GoalSeekPotValue, $Risk, $Return, $type, $SolutionObjectData){
        // settype($objectData['Start'], 'integer');

		$objectparams = array(
			"sclrSolveStrategy",0,"StrategyOptimisationMax",json_encode($objectData['StrategyOptimisationMax']),"sclrSolveInput",$objectothersData['sclrSolveInput'],"GoalSeekPotValue",$GoalSeekPotValue,"GoalSeekTime",$objectothersData['GoalSeekTime'],"GoalSeekPercentile",$objectothersData['GoalSeekPercentile'],"GoalSeekRealNominal",$objectothersData['GoalSeekRealNominal'],"Age",json_encode($objectData['Age']),"RetirementAge",json_encode($objectData['RetirementAge']),"ProjectionHorizon",json_encode($objectData['ProjectionHorizon']),"InputLabel",json_encode($objectData['InputLabel']),"InflowOutflow",json_encode($objectData['InflowOutflow']),"InputValue",json_encode($objectData['CashFlowArr']),"Type",json_encode($type),"InputSymbol",json_encode($objectData['vecInputSymbol']),"Start",json_encode($objectData['Start']),"TypeEnd",json_encode($objectData['TypeEnd']),"TypeAsset",json_encode($objectData['TypeAsset']),"TypeYearStrategy",json_encode($objectData['TypeYearStrategy']),"TypeOverallStrategy",json_encode($objectData['TypeOverallStrategy']),"TypeGlideOrFixedStrategy",json_encode($objectData['TypeGlideOrFixedStrategy']),"Risk",json_encode($Risk),"Return",json_encode($Return),"PotType",json_encode($objectData['TypePot']),"Organisation",json_encode($objectothersData['Organisation']),"LiveColourOptions", json_encode($objectData['LiveColourOptions']),"PotOptions",json_encode($objectData['PotOptions']),"ReturnsPot",json_encode($objectData['ReturnsPot']),"DrawdownSequence",json_encode($objectothersData['DrawdownSequence']),"FundExpenses",json_encode($objectData['FundExpenses']),"FundTax",json_encode($objectData['FundTax']),"FeeModelPot",json_encode($objectData['FeeModelPot']),"DrawdownStart",json_encode($objectData['DrawdownStart']),"AssetCollectionObject",json_encode($objectothersData['objAssetCollectionStore']),"RealNominalSelection",json_encode($objectData['RealNominalSelection']),"MeanReversion",json_encode($objectData['MeanReversion']),"RiskArrestation",json_encode($objectData['RiskArrestation']),"ChartPos_Neg",json_encode($objectData['ChartPos_Neg'])
		);
		$extraParams = array( "Type_val",json_encode($objectData['Type']), "Pot_type", json_encode(array_count_values( json_decode( $objectData['TypePot'])) ), "LiveColourOptions", json_encode($objectData['LiveColourOptions']) );
		$datalist = array(
			'goalseekprojectionAtTimelist' =>goalseekprojectionAtTime($objectData['Age']),
			'typeendpptions' =>DefaultTypeEndOptionsData($objectData['Age']),
			'assetselection2' =>DefaultStrategyDropdownData(),
			'withsecuritylists' =>DefaultTypePercentileslData(),
		);
		echo json_encode(array('status'=>true, 'params' =>$objectparams,'datalist'=>$datalist,'extraParams'=> $extraParams, 'settingParams' => $SolutionObjectData));
	}
	static function sendResponse($objectData,$objectothersData, $GoalSeekPotValue, $Risk, $Return, $SolutionObjectData){ 
		$objectparams = array(
			"sclrSolveStrategy",0,"StrategyOptimisationMax",json_encode($objectData['StrategyOptimisationMax']),"sclrSolveInput",$objectothersData['sclrSolveInput'],"GoalSeekPotValue",$GoalSeekPotValue,"GoalSeekTime",$objectothersData['GoalSeekTime'],"GoalSeekPercentile",$objectothersData['GoalSeekPercentile'],"GoalSeekRealNominal",$objectothersData['GoalSeekRealNominal'],"Age",json_encode($objectData['Age']),"RetirementAge",json_encode($objectData['RetirementAge']),"ProjectionHorizon",json_encode($objectData['ProjectionHorizon']),"InputLabel",json_encode($objectData['InputLabel']),"InflowOutflow",json_encode($objectData['InflowOutflow']),"InputValue",json_encode($objectData['CashFlowArr']),"Type",json_encode($objectothersData['Type']),"InputSymbol",json_encode($objectData['vecInputSymbol']),"Start",json_encode($objectothersData['Start']),"TypeEnd",json_encode($objectothersData['TypeEnd']),"TypeAsset",json_encode($objectData['TypeAsset']),"TypeYearStrategy",json_encode($objectData['TypeYearStrategy']),"TypeOverallStrategy",json_encode($objectData['TypeOverallStrategy']),"TypeGlideOrFixedStrategy",json_encode($objectData['TypeGlideOrFixedStrategy']),"Risk",json_encode($Risk),"Return",json_encode($Return),"PotType",json_encode($objectData['TypePot']),"Organisation",json_encode($objectothersData['Organisation']),"LiveColourOptions", json_encode($objectData['LiveColourOptions']),"PotOptions",json_encode($objectData['PotOptions']),"ReturnsPot",json_encode($objectData['ReturnsPot']),"DrawdownSequence",json_encode($objectothersData['DrawdownSequence']),"FundExpenses",json_encode($objectData['FundExpenses']),"FundTax",json_encode($objectData['FundTax']),"FeeModelPot",json_encode($objectData['FeeModelPot']),"DrawdownStart",json_encode($objectData['DrawdownStart']),"AssetCollectionObject",json_encode($objectothersData['objAssetCollectionStore']),"RealNominalSelection",json_encode($objectData['RealNominalSelection']),"MeanReversion",json_encode($objectData['MeanReversion']),"RiskArrestation",json_encode($objectData['RiskArrestation']),"ChartPos_Neg",json_encode($objectData['ChartPos_Neg'])
		);
		$extraParams = array( "Type_val",json_encode($objectothersData['Type']), "Pot_type", json_encode(array_count_values( json_decode( $objectData['TypePot'])) ), "LiveColourOptions", json_encode($objectData['LiveColourOptions']) );
		$datalist = array(
			'goalseekprojectionAtTimelist' =>goalseekprojectionAtTime($objectData['Age']),
			'typeendpptions' =>DefaultTypeEndOptionsData($objectData['Age']),
			'assetselection2' =>DefaultStrategyDropdownData(),
			'withsecuritylists' =>DefaultTypePercentileslData(),
		);
		echo json_encode(array('status'=>true, 'params' =>$objectparams,'datalist'=>$datalist,'extraParams'=> $extraParams, 'settingParams' => $SolutionObjectData));
	}
	public function getDataOnLoad(){
		//check info exits or not in DB
		$tokenkey = $this->input->post('tokenkey');
		$checkExits = $this->cashflows->check_solutionsparams($tokenkey);
		if($checkExits === true){ 	
			$objectDataa = $this->cashflows->get_solutionsparams($tokenkey);	
			$objectDataaa = urldecode($objectDataa['Parameters']);
			$objectDataArr = json_decode($objectDataaa, true);
			$datalist = array(
				'goalseekprojectionAtTimelist' =>goalseekprojectionAtTime($objectDataArr['Age']),
				'typeendpptions' =>DefaultTypeEndOptionsData($objectDataArr['Age']),
				'assetselection2' =>DefaultStrategyDropdownData(),
				'withsecuritylists' =>DefaultTypePercentileslData(),
			);

			echo json_encode(array('status'=>true, 'params' =>$objectDataaa, 'datalist'=>$datalist ) );
			//echo $objectDataaa;
			 die;
		}
		echo json_encode(array('status'=>false ) ); die;
	}

	static public function __getApiData($method, $data) {
		$curl = curl_init(self::API_URL.$method);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		$result = curl_exec($curl);
		curl_close($curl);
		return $result;
	}
	public function request_graphparameters_json(){
		$parameters = $this->input->post('parameters');
		$apiresponse = self::__getApiData('runCashFlowAnalysisModel1_24g', $parameters);
		echo $apiresponse;
	}
	public function testapi(){
		$data = array();
		$curl = curl_init("https://catfact.ninja/fact");
		//curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		$result = curl_exec($curl);
		print_r($result);
		curl_close($curl);
		return $result;
	}
	public function rebuilddropdown(){
		$agevalue = $this->input->get('agevalue');
		$params = array(
			'agedropdown'=>goalseekprojectionAtTime($agevalue)
		);
		echo json_encode(array('status'=>true, 'params' =>$params));
	}
	static public function getDefaultData1(){
		$UnitTestSample =	'{"Model":"CashflowModel","ClientName":"undefined","DrawdownStart":[0],"Age":"50","RetirementAge":"65","GlobalNCashFlowBars":2,"NStrategyYears":1,"ProjectionHorizon":"90","FundExpenses":[0,0],"FundTax":[0,0],"InputLabel":["Initial investment","Cashflow 2"],"InflowOutflow":["0","1"],"CashFlowArr":["1000","0"],"Type":["1","1"],"Start":["1","4"],"TypeEnd":["0","0"],"TypeAsset":["0","0"],"TypePot":["0","0"],"TypeYearStrategy":[["0","0"],["0","0"]],"TypeOverallStrategy":[["3","3"],["3","3"]],"ReturnsPot":["0","0"],"RealNominalSelection":"Nominal","LiveColourOptions":["#82d9ff","#22a8e2"],"PotOptions":["Objective 1","Objective 2"]}';
		return json_decode($UnitTestSample);
	}
	static public function getDefaultData(){
		$userid = $this->userid;
		$timestamp = date('d F Y, h:i:s A');

		$UnitTestSample =	'{"solnRow":"'.$userid.'","Model":"CashflowModel","ClientName":"My pictures solutions","DrawdownStart":[0],"Age":"50","RetirementAge":"65","GlobalNCashFlowBars":0,"NStrategyYears":1,"ProjectionHorizon":"100","FundExpenses":[0.015],"FundTax":[0],"InputLabel":["Cashflow name"],"InflowOutflow":["0"],"CashFlowArr":["22000"],"Type":[0],"Start":[0],"TypeEnd":[-3],"TypeAsset":["0"],"TypePot":"[0]","TypeYearStrategy":[[0]],"TypeOverallStrategy":[["3"]],"TypeGlideOrFixedStrategy":[[0]],"StrategyOptimisationMax":[10],"vecInputSymbol":[0],"vecSolverInputFinalAmount":[[0]],"vecGoalSeekPotValue":[0],"vecGoalSeekTime":[2],"vecGoalSeekPercentile":[2],"WasLastRunGoalSeek":false,"LastSclrSolveInput":[],"ReturnsPot":["0"],"FeeModelPot":[1],"RealNominalSelection":"Real","ChartPos_Neg":"PositiveOnly_Y","TimeSelection":"Age","NumberOfDrawdowns":1,"AssumptionsSet2Use":1,"LiveColourOptions":["#697d8a"],"PotOptions":["Investment pot 1"],"timestamp":"'.$timestamp.'","vecGoalSeekRealNominal":["Real"],"MeanReversion":false,"RiskArrestation":false}';
		return json_decode($UnitTestSample);
	}
	public function getgraph_json(){
		
		// echo json_encode(array(
		// 	'graphdata' =>'',
		// 	'defaultparams' =>self::getDefaultData(),
		// ));
	}
	
	
	public function incomesource() {
		$data['title']  = 'Income Source | '.$this->title;
		$view = $this->template.'/cashflowmodel/incomesourcehtml';
		$this->load->view($this->template.'/layouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function investmentpots() {
		$data['title']  = 'Investment pots | '.$this->title;
		$view = $this->template.'/cashflowmodel/investmentpotshtml';
		$this->load->view($this->template.'/layouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function goalseek() {
		$data['title']  = 'Goal Seek | '.$this->title;
		$view = $this->template.'/cashflowmodel/goalseekhtml';
		$this->load->view($this->template.'/layouthtml',  array('data'=>$data,'views'=> $view));
	}
	
	public function getLabelArraydata( $selected = NULL){
		$labelType = $this->input->get('labelType');
		$Agevalue =  (!empty($this->input->get('Agevalue')) ? $this->input->get('Agevalue') : 50);
		$result = array(
			'Agevalue' => $Agevalue,
			'typestart' =>DefaultTypeStartData($selected),
			'typebegin' =>DefaulTypeBeginData($selected),
			'typeendpptions' =>DefaultTypeEndOptionsData($selected),
			'arrinoutflow' =>DefaultarrFlowData($selected),
			'returnpath' =>DefaultReturnPathData($selected),
			'FeeModelData' =>DefaultFeeModelData($selected),
			'TypePercentileslData' =>DefaultTypePercentileslData($selected),
			'datalabel'=>array(
				'objHelpIndicator' =>DefaultIndicatorinfo(),
				'objInOutFlowIndicator' =>DefaultIndicatorinfo('inoutflow'),
				'RiskRatings' =>DefaultRatingDropdownData()
			)
		);
		echo json_encode($result);
	}
	
	public function collection_alltype_data_old( $selected = NULL){
		$agevalue =  (!empty($this->input->get('agevalue')) ? $this->input->get('agevalue') : 50);
		$solnid =  $this->input->get('solnid');
		$projectionage =  (!empty($this->input->get('projectionage')) ? $this->input->get('projectionage') : 65);
		$retirementage =  (!empty($this->input->get('retirementage')) ? $this->input->get('retirementage') : 100);
		$result = array(
			'datalabel'=>array(
				'objHelpIndicator' =>DefaultIndicatorinfo(),
				'objInOutFlowIndicator' =>DefaultIndicatorinfo('inoutflow'),
				'RiskRatings' =>DefaultRatingDropdownData()
			),
			'datalist'=>array(
				'Agevalue' => $agevalue,
				// 'currencies' => $this->cashflows->getcurrencies(),
				'typestart' =>DefaultTypeStartData($selected),
				'typebegin' =>DefaulTypeBeginData($selected),
				'typeendpptions' =>DefaultTypeEndOptionsData($agevalue),
				'arrinoutflow' =>DefaultarrFlowData($selected),
				'returnpath' =>DefaultReturnPathData($selected),
				'FeeModelData' =>DefaultFeeModelData($selected),
				'TypePercentileslData' =>DefaultTypePercentileslData($selected),
				'goalseekprojectionAtTimelist' =>goalseekprojectionAtTime($agevalue),
				'strategydropdownlist' =>DefaultStrategyDropdownData($selected),
				'solnParameters' =>$this->LoadSolnParameters($solnid)
			),
				
		);
		echo json_encode($result);
	}

	
	public function get_uptoprojectionage(){
		$result = array('Retirement','Now');
		$Agevalue = $this->input->get('Agevalue');
		for( $inc = $Agevalue; $inc<=105; $inc++) {
			$returndata[] = 'At '.$inc;
		}
		$resasdsult = array_merge($result, $returndata);
		echo json_encode(array(
			'firstrowcolm'=>'Market downturn',
			'projectioninfo'=>$resasdsult
		));
	}

	/**** Get casfFlow types data *****/
	public function getCashflowTypesData(){
		$value = $this->input->post('value');
		$age = $this->input->post('age');
		$typebeginlists = DefaulTypeBeginData($age);
		if( isset($typebeginlists) && !empty($typebeginlists)){
			$typevalue=0; $optionsStr='';
			foreach($typebeginlists as $text=> $title ){ 
				$selected='';
				if( $typevalue == $value){
					$selected='selected';
				}
				$optionsStr .= '<option title="'. $title.'" value="'.$typevalue++.'" '.$selected.'>'.$text.'</option>';
			}
		};
		echo $optionsStr; die;	
	}
	/**** Get cashFlow start data *****/
	public function getCashflowStartData(){
		$value = $this->input->post('value');
		if($value  == 0){ $value++; }
		$age = $this->input->post('age');
		$measureTime = $this->input->post('measureTime');  
		if($measureTime == 'Age'){
			$startbeginlists = goalseekprojectionAtTime($age);
		}else if($measureTime == 'CalendarYears'){
			$startbeginlists = DefaultTypeStartYearData();
		}else if( $measureTime == 'Time'){
			$startbeginlists = DefaultTypeStartTodayData();
		}
		$optionsStr='';
		if( isset($startbeginlists) && !empty($startbeginlists)){
			$typevalue=0; 
			foreach($startbeginlists as $text=> $title ){ 
				$selected='';
				if( $typevalue == $value){
					$selected='selected';
				}
				$optionsStr .= '<option title="'. $title.'" value="'.$typevalue++.'" '.$selected.'>'.$title.'</option>';
			}
		};
		echo $optionsStr; die;	
	}
	/**** Get cashFlow end data *****/
	public function getCashflowEndData(){
		$value = $this->input->post('value');
	    $age = $this->input->post('age');
		$endbeginlists = DefaultTypeEndOptionsData($age);
		if( isset($endbeginlists) && !empty($endbeginlists)){
			$typevalue=0; $optionsStr='';
			foreach($endbeginlists as $text=> $title ){ 
				$selected='';
				if( $typevalue == $value){
					$selected='selected';
				}
				$optionsStr .= '<option title="'. $title.'" value="'.$typevalue++.'" '.$selected.'>'.$title.'</option>';
			}
		};
		echo $optionsStr; die;	
	}
	//getinvestmentstrategyData
public function getinvestmentstrategyData (){
		$value = json_decode($this->input->post('val'));
		$count_val = count($value);
		$inc = $this->input->post('inc');
		$color = $this->input->post('color');
		$Str=''; $t=0;  $v=1;
		$class1= 'CloneInvestmentStrategyColumn'; $class2='plus_symbol'; $cls_count=0;
		$DropdownDatalists = DefaultStrategyDropdownData();
		if( isset($DropdownDatalists) && !empty($DropdownDatalists)){
			if($count_val >0){ 
				for($i=0; $i<$count_val; $i++){ 
					$td_html = ''; 
					$typevalue=0; $selected=''; $hoverClass=''; $optionsStr='<div uk-dropdown="mode: click;" class="investmentstrategy_lists">
					<div class="uk-dropdown-grid uk-child-width-1-1@m uk-grid uk-grid-stack projectionrating" >
						<div>
							<div class="uk-nav uk-dropdown-nav"><p class="uk-nav-header" data-item='.$inc.' data-color='.$color.'>STRATEGY</p>';
							
					foreach($DropdownDatalists as $text=> $title ){ 
						if( $typevalue == $value[$i]){
							$t1 = $v = ++$t;						

							
							if($i ==0){ 
								$td_html .= '<td class="colsIndex'.$t1.' '.$class1.'  typeyear_strategycolmn" >';
							}else{
								$td_html .= '<td class="colsIndex'.$t1.' '.$class2.'  typeyear_strategycolmn" >';
							}
							$selected .='<a class="selectedRating" onclick="addhoverclass('.$inc.', '.$t1.')" data-potnumber="1" aria-expanded="false" name="'.$title.'" data-value="'.$typevalue.'" style="background:'.$color.'">'.$title.'</a>';

							$optionsStr .= '<p onclick="unselectItem(this, '.$t1.')"><a style="background:'.$color.'" class="chooseinvestmentstrategy selected"  data-value="'.$typevalue.'" data-list="'.$inc.'">'.$title.'</a></p>';	
						}else{
							$optionsStr .= '<p onclick="unselectItem(this, '.($i+1).')"><a class="chooseinvestmentstrategy"  data-value="'.$typevalue.'" data-list="'.$inc.'">'.$title.'</a></p>';	
						}	
								
						$typevalue++;
					}
					$Str .=$td_html.''.$selected.' '.$optionsStr.'</div></div></div></div></td>';
					$optionsStr ='';
				}
			}
		};
		echo $Str.'<td class="addothercolsbefore"><span class="shiftArrow1" style="color: '.$color.'">➤</span></td>'; die;
	}

	public function getinvestmentstrategyData11 (){
		$value = json_decode($this->input->post('val'));
		$count_val = count($value);
		$inc = $this->input->post('inc');
		$color = $this->input->post('color');
		$Str=''; $t=0;  $v=1;
		$class1= 'CloneInvestmentStrategyColumn'; $class2='plus_symbol'; $cls_count=0;
		$DropdownDatalists = DefaultStrategyDropdownData();
		if( isset($DropdownDatalists) && !empty($DropdownDatalists)){
			if($count_val >0){ 
				for($i=0; $i<$count_val; $i++){ 
					$td_html = ''; 
					$typevalue=0; $selected=''; $hoverClass=''; $optionsStr='<div uk-dropdown="mode: click;" class="investmentstrategy_lists">
					<div class="uk-dropdown-grid uk-child-width-1-1@m uk-grid uk-grid-stack projectionrating" >
						<div>
							<ul class="uk-nav uk-dropdown-nav"><li class="uk-nav-header" data-item='.$inc.' data-color='.$color.'>STRATEGY</li>';
							
					foreach($DropdownDatalists as $text=> $title ){ 
						if( $typevalue == $value[$i]){
							$t1 = $v = ++$t;						

							
							if($i ==0){ 
								$td_html .= '<td class="colsIndex'.$t1.' '.$class1.'  typeyear_strategycolmn" >';
							}else{
								$td_html .= '<td class="colsIndex'.$t1.' '.$class2.'  typeyear_strategycolmn" >';
							}
							$selected .='<a class="selectedRating" onclick="addhoverclass('.$inc.', '.$t.')" data-potnumber="1" aria-expanded="false" name="'.$title.'" data-value="'.$typevalue.'" style="background:'.$color.'">'.$title.'</a>';

							$optionsStr .= '<li onclick="unselectItem(this, '.$t1.')"><a style="background:'.$color.'" class="chooseinvestmentstrategy selected"  data-value="'.$typevalue.'" data-list="'.$inc.'">'.$title.'</a></li>';	
						}else{
							$optionsStr .= '<li onclick="unselectItem(this, '.$v.')"><a class="chooseinvestmentstrategy"  data-value="'.$typevalue.'" data-list="'.$inc.'">'.$title.'</a></li>';	
						}	
								
						$typevalue++;
					}
					$Str .=$td_html.''.$selected.' '.$optionsStr.'</ul></div></div></div></td>';
					$optionsStr ='';
				}
			}
		};
		echo $Str.'<td class="addothercolsbefore"><span class="shiftArrow1" style="color: '.$color.'">➤</span></td>'; die;
	}
}