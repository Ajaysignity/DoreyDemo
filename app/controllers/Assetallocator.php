<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/FrontEndController.php';

class Assetallocator extends FrontEndController {
	public function __construct() {
		parent::__construct();
		$this->load->model('Assetallocator_model','assetallocators');
		$this->folder = $this->template.'/assetallocators/';
	}
	public function index(){
		$data['title']  = 'Drag & Drop | '.$this->title;
		$data['lists'] = $this->assetallocators->get_allocatorsData();
		$view = $this->folder.'listinghtml';
		$this->load->view('authlayouthtml',  array('data'=>$data,'views'=> $view));
	}

	public function SaveAllocatorDataInfo() {	
		$getOrganisatioinfo = $this->auth->getuserinfo($this->userid);
		$objectModel = array(
			'nargout'=>1,
			'rhs' => array('txtAction','GetModelsForOrganisationAndUser','txtOrganisationID',$getOrganisatioinfo->OrganisationApiName,'txtUserID','1')
		);
		$apiresponsesModel = self::__getApiAssetData(json_encode($objectModel));
		$CheckIfExist = $this->assetallocators->get_Single_AllocatorDataInfo();
		$PortfolioNames = array();
		$currencies = array();
		$apiresponsesModel =json_decode($apiresponsesModel);
		$inputy = $apiresponsesModel->lhs[0]->mwdata->AvailableModels2Load[0];
		$mxOutputs = self::convertMWArray($inputy);
		$OrganisationModelsData =  self::getDisplayNameKeys($mxOutputs);
		
		$txtDateSelected = '18/07/2023';
		if(  !empty($OrganisationModelsData) ) {
			$AssumptionDateSet = ($getOrganisatioinfo->OrganisationApiName == 'MKCWealth1' ? $OrganisationModelsData[1] : $OrganisationModelsData[0]);
			$txtDateSelecteds = explode('|',$AssumptionDateSet);
			$txtDateSelected = $txtDateSelecteds[0];
		}
		$OrganisationModelsDatas = array(
			'OrganisationID' => $getOrganisatioinfo->OrganisationName,
			'UserID' => $this->userid,
			'AssumptionsName' => 'QuarterlyUpdate',
			'DisplayName' => $OrganisationModelsData,
		);
		$object = array(
			'nargout'=>1,
			'rhs' => array('txtAction','Initialise','txtOrganisationID',$getOrganisatioinfo->OrganisationApiName,'txtDateSelected',$txtDateSelected,'txtCurrencySelected','£','txtSessionID',$this->organisation,'txtUserID',$this->userid,'txtDataSetName',$txtDateSelecteds[1]),
		);
		$apiresponses = self::__getApiAssetData(json_encode($object));
		$apiresponse =json_decode($apiresponses);
		if( property_exists($apiresponse->lhs[0]->mwdata,'DistinctCurrencies')) {
			$DistinctCurrencies = $apiresponse->lhs[0]->mwdata->DistinctCurrencies[0]->mwdata;
			foreach( $DistinctCurrencies as $DistinctCurrency ){
				$currencies[] = $DistinctCurrency->mwdata[0];
			}
		}
		if( property_exists($apiresponse->lhs[0]->mwdata,'PortfolioNames')) {
			$PortfolioNamelists = $apiresponse->lhs[0]->mwdata->PortfolioNames[0]->mwdata;
			foreach( $PortfolioNamelists as $PortfolioNamelist ){
				$PortfolioNames[] = $PortfolioNamelist->mwdata[0];
			}
		}
		if ( empty($PortfolioNames) ) {
			echo json_encode(array(
				'status' => false,
				'message' =>$apiresponse->lhs[0]->mwdata->Message[0]->mwdata[0]
			));	
		} else {
			$parameters = array(
				'organisation'=>$this->organisation,
				'DistinctCurrencies'=>json_encode($currencies),
				'PortfolioNames'=>json_encode($PortfolioNames),
				'OrganisationModelsData'=>json_encode($OrganisationModelsDatas),
			);
			if( empty($CheckIfExist) ) {
				$this->assetallocators->Insert_AllocatorDataInfo($parameters);
			} else {
				$this->assetallocators->Update_AllocatorDataInfo($parameters, $this->organisation);
			}
			echo json_encode(array(
				'status' => true,
				'http_redirect'=> website_url($this->controller.'/assetallocator'),
				'message' =>'Saved successfully'
			));	
		}
	}
	static function convertMWArray($mxArrayIn){
		$vecSize = $mxArrayIn->mwsize;
		$mxOutput = array();
		$nRow = $vecSize[0];
		$nCol = $vecSize[1];
		for ($iRow=0;$iRow<$nRow;$iRow++){
			$mxOutput[$iRow] = [];
		}
		for ($iCol=0;$iCol<$nCol;$iCol++){
			for ($iRow=0;$iRow<$nRow;$iRow++){
				$mxOutput[$iRow][$iCol]=($mxArrayIn->mwdata[$iCol*($nRow)+$iRow]);
			}
		}
		return $mxOutput;
	}
	static function getDisplayNameKeys($lists ){
		$returnKey = '';
		foreach($lists[0] as $key=>$pair) {
			if( $pair->mwdata[0] == 'DisplayName') {
				$returnKey = $key;
			}
		}
		unset($lists[0]);
		$sd = array();
		$dfd = array();
		if( !empty($returnKey) ) {
			foreach($lists as $key=>$pair) {
				$sd[$key] = (array)$pair[$returnKey]->mwdata;
			}
			$dfd = call_user_func_array('array_merge',$sd);
		}
		return $dfd;
	}
	public function addnewassetallocator() {
		$data['title']  = 'Asset Allocator | '.$this->title;
		$data['UserInfo'] = $this->auth->getuserinfo($this->userid);
		$dataportfolioinfo = $this->assetallocators->get_Single_AllocatorDataInfo();
		$Currencies = array();
		$PortfolioNames = array();
		$DisplayNames = array();
		if( !empty($dataportfolioinfo) ) {
			$DistinctCurrencies = json_decode($dataportfolioinfo->DistinctCurrencies);
			foreach( $DistinctCurrencies as $key=>$pair ) {
				$Currencies[$pair] = $pair;
			}
			$PortfolioNamelists = json_decode($dataportfolioinfo->PortfolioNames);
			foreach( $PortfolioNamelists as $key=>$pair ) {
				$PortfolioNames[$pair] = $pair;
			}
			$DisplayNameLists = json_decode($dataportfolioinfo->OrganisationModelsData);
			foreach( $DisplayNameLists as $key=>$pairLists ) {
				if( $key == 'DisplayName') {
					foreach( $pairLists as $keypair=>$pairList ) {
						$DisplayNames[$pairList] = $pairList;
					}
				}
			}
		}
		$data['Currencies'] = ($Currencies);
		$data['PortfolioNames'] = $PortfolioNames;
		$data['DisplayNames'] = $DisplayNames;
		$this->loadAjaxViews("assetAllocator/addnewassetallocatorhtml", $data);		
	}
	public function saveallocatorbasicinfo(){	
		$this->form_validation->set_rules('clientname', 'Client Name', 'required|xss_clean');
		$this->form_validation->set_rules('reportdate', 'Report Date', 'required|xss_clean');
		$this->form_validation->set_rules('introducer', 'Introducer', 'xss_clean');
		$this->form_validation->set_rules('referencecurrency', 'Reference currency', 'required|xss_clean');
		$this->form_validation->set_rules('portfoliostrategy', 'Proposed portfolio strategy', 'required|xss_clean');
		$this->form_validation->set_rules('minimumhorizon', 'Minimum time horizon, years', 'xss_clean');
		$this->form_validation->set_rules('annualreturn', 'Target annualised return CPI +x%', 'xss_clean');
		$this->form_validation->set_rules('avoiddrawdown', 'Avoid 12 month drawdown of x%', 'xss_clean');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array(
				'status' => false,
				'otpscreen' => false,
				'message' =>validation_errors()
			));
		} else {
			$reportdate = $this->input->post('reportdate');
			$referencecurrency = $this->input->post('referencecurrency');
			$portfoliostrategy = $this->input->post('portfoliostrategy');
			$iduserallocator = decryptKey($this->input->post('iduserallocator'));
			$objData = array(
				'clientname'=>$this->input->post('clientname'),
				'reportdate'=>$reportdate,
				'introducer'=>$this->input->post('introducer'),
				'displayname'=>$this->input->post('displayname'),
				'referencecurrency'=>$referencecurrency,
				'portfoliostrategy'=>$portfoliostrategy,
				'minimumhorizon'=>$this->input->post('minimumhorizon'),
				'annualreturn'=>$this->input->post('annualreturn'),
				'avoiddrawdown'=>$this->input->post('avoiddrawdown')
			);
			$parameters = array(
				'BasicInfo'=>urlencode(json_encode($objData)),
				'User'=>$this->userid,
				'ClientName'=>$this->input->post('clientname'),
				'InitialiseApidata'=>$this->input->post('InitialiseApidata'),
				'created_at'=>date('Y-m-d h:i:s')
			);
			$getOrganisatioinfo = $this->auth->getuserinfo($this->userid);
			$txtDateSelecteds  = explode('|', $reportdate);
			$ObjectInitialise = array(
				'nargout'=>1,
				'rhs' => array('txtAction','Initialise','txtOrganisationID',$getOrganisatioinfo->OrganisationApiName,'txtDateSelected',$txtDateSelecteds[0],'txtCurrencySelected',$referencecurrency,'txtSessionID',$this->organisation,'txtUserID',$this->userid,'txtDataSetName',$txtDateSelecteds[1])
			);
			self::__getApiAssetData(json_encode($ObjectInitialise));
			$apiresponse = $this->runAssetAllocator($portfoliostrategy,$referencecurrency,$reportdate);
			$parameters['apidata'] = $apiresponse;
			if( !empty($iduserallocator) ) {
				$parameters['modifieddate'] = date('Y-m-d h:i:s');
				$iduserallocator = $this->assetallocators->Updated_allocatorparams($parameters, $iduserallocator);
			} else {
				$iduserallocator = $this->assetallocators->Insert_allocatorparams($parameters);
			}
			echo json_encode(array(
				'status' => true,
				'apiresponse' => $apiresponse,
				'iduserallocator' => $iduserallocator,
				'http_redirect'=> website_url($this->controller.'/clientinformation?tokenkey='.encryptKey($iduserallocator)),
				'message' =>'Saved successfully'
			));
		}
	}
	private function runAssetAllocator( $portfoliostrategy, $txtCurrency2Set, $txtDataSetName ) {
		$setCurrencyObject = array('nargout'=>1,'rhs' => array('txtSessionID',$this->organisation,'txtAction','setCurrency','txtCurrency2Set',$txtCurrency2Set));
		self::__getApiAssetData(json_encode($setCurrencyObject));
		$getOrganisatioinfo = $this->auth->getuserinfo($this->userid);
		$FullObject = array('nargout'=>1,'rhs' => array('txtAction','getFullPage1Call','txtSessionID',$this->organisation,'txtOrganisationID',$getOrganisatioinfo->OrganisationApiName,'txtUserID','1','txtDataSetName',$txtDataSetName,'txtCurrencySelected',$txtCurrency2Set,'txtPortfolioName2Set',$portfoliostrategy));
		$apiresponse = self::__getApiAssetData(json_encode($FullObject));
		return $apiresponse;	
	}
	public function PortfoliosSelectContainerByAssumption(){
		$PortfolioNames = array();
		$DataNames = $this->input->post('key');
		$organisation = $this->input->post('token');
		$DataName = explode('|', $DataNames);
		$object = array(
			'nargout'=>1,
			'rhs' => array('txtAction','Initialise','txtOrganisationID',$organisation,'txtDateSelected',$DataName[0],'txtCurrencySelected','£','txtSessionID',$this->organisation,'txtUserID',$this->userid,'txtDataSetName',$DataName[1]),
		);
		$apiresponses = self::__getApiAssetData(json_encode($object));
		$apiresponse =json_decode($apiresponses);
		if( property_exists($apiresponse->lhs[0]->mwdata,'PortfolioNames')) {
			$PortfolioNamelists = $apiresponse->lhs[0]->mwdata->PortfolioNames[0]->mwdata;
			$counter=1;foreach( $PortfolioNamelists as $PortfolioNamelist ){
				$PortfolioNames[] = array(
					'key'=>$counter++,
					'pair'=>$PortfolioNamelist->mwdata[0]
				);
			}	
		}
		$parameters = array(
			'PortfolioNames' => $PortfolioNames,
		);
		echo json_encode($parameters);
	}
	public function clientinformation(){
		$tokenkey = decryptKey($this->input->get('tokenkey'));		
		$allocatorData = $this->assetallocators->get_SingleallocatorsData($tokenkey);
		$BasicInfo = (object)self::decodeparams($allocatorData->BasicInfo);
		$InitialiseApidata = (!empty($allocatorData->InitialiseApidata) ? (object)self::decodeparams($allocatorData->InitialiseApidata) : '');
		$dataportfolioinfo = $this->assetallocators->get_Single_AllocatorDataInfo();
		$Currencies = array();
		$PortfolioNames = array();
		if( !empty($dataportfolioinfo) ) {
			$DistinctCurrencies = json_decode($dataportfolioinfo->DistinctCurrencies);
			foreach( $DistinctCurrencies as $key=>$pair ) {
				$Currencies[$pair] = $pair;
			}
			$PortfolioNamelists = json_decode($dataportfolioinfo->PortfolioNames);
			foreach( $PortfolioNamelists as $key=>$pair ) {
				$PortfolioNames[$pair] = $pair;
			}
		}

		$data = array(
			'tokenkey' => encryptKey($tokenkey),
			'title' => 'Client Information | '.$this->title,
			'iduserallocator' => $tokenkey,
			'Currencylists' => $Currencies,
			'portfoliolists' => $PortfolioNames,
			'BasicInfo' => $BasicInfo,
			'InitialiseApidata' => $InitialiseApidata,
			'ClientName' => $allocatorData->ClientName
		);
		$view = $this->folder.'clientinformationhtml';
		$this->load->view('authlayouthtml',  array('data'=>$data,'views'=> $view));
	}
	static function decodeparams( $parameters ){
		$liveVariables= urldecode($parameters);
		$returndata = json_decode($liveVariables,true);
		return $returndata;
	}
	public function viewclientinformation(){
		$iduserallocator = decryptKey($this->input->post('iduserallocator'));	
		$allocatorData = $this->assetallocators->get_SingleallocatorsData($iduserallocator);
		$data = array(
			'tokenkey' => encryptKey($iduserallocator),
			'title' => 'Client Information | '.$this->title,
			'allocatorData' => $allocatorData
		);
		$apidata = $allocatorData->apidata;

		if( empty($allocatorData->apidata) ) {
			$BasicInfo = (object)self::decodeparams($allocatorData->BasicInfo);
			$getOrganisatioinfo = $this->auth->getuserinfo($this->userid);
			$txtDateSelecteds  = explode('|', $BasicInfo->reportdate);
			$ObjectInitialise = array(
				'nargout'=>1,
				'rhs' => array('txtAction','Initialise','txtOrganisationID',$getOrganisatioinfo->OrganisationApiName,'txtDateSelected',$txtDateSelecteds[0],'txtCurrencySelected',$BasicInfo->portfoliostrategy,'txtSessionID',$this->organisation,'txtUserID',$this->userid,'txtDataSetName',$txtDateSelecteds[1])
			);
			$apidata = self::__getApiAssetData(json_encode($ObjectInitialise));
			if( empty($allocatorData->apidata) ) {
				$parameters['apidata'] = $apidata;
				$iduserallocator = $this->assetallocators->Updated_allocatorparams($parameters, $iduserallocator);
			}
		}
		echo json_encode(array(
			'status' => true,
			'iduserallocator' => $iduserallocator,
			'http_redirect'=> website_url($this->controller.'/clientinformation?tokenkey='.encryptKey($iduserallocator)),
			'apidata' => $apidata,
		));
	}
	public function renameassetcollator() {
		$data['title']  = 'Asset Allocator | '.$this->title;
		$iduserallocator = decryptKey($this->input->get('iduserallocator'));
		$allocatorData = $this->assetallocators->get_SingleallocatorsData($iduserallocator);
		$data['ClientName'] = $allocatorData->ClientName;
		$data['type'] = $this->input->get('type');
		$data['iduserallocator'] = $this->input->get('iduserallocator');
		$this->loadAjaxViews("assetAllocator/renameassetcollatorhtml", $data);		
	}
	public function updateuserallocator(){
		$this->form_validation->set_rules('ClientName', 'Client Name', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array(
				'status' => false,
				'otpscreen' => false,
				'message' =>validation_errors()
			));
		} else {
			$ClientName = $this->input->post('ClientName');
			$type = decryptKey($this->input->post('type'));
			$iduserallocator = decryptKey($this->input->post('iduserallocator'));
			if( $type == 'duplicate') {
				$this->assetallocators->duplicateassetallocator($ClientName,$iduserallocator);
			} else {
				$this->assetallocators->Updated_allocatorparams(array('ClientName'=>$ClientName), $iduserallocator);
			}
			echo json_encode(array(
				'status' => true,
				'http_redirect'=> website_url($this->controller),
				'message' =>'Saved successfully'
			));
		}
	}
	public function editassetallocator() {
		$data['title']  = 'Asset Allocator | '.$this->title;
		$iduserallocator = decryptKey($this->input->get('iduserallocator'));
		$dataportfolioinfo = $this->assetallocators->get_Single_AllocatorDataInfo();
		$allocatorData = $this->assetallocators->get_SingleallocatorsData($iduserallocator);
		$Currencies = array();
		$PortfolioNames = array();
		$DisplayNames = array();
		if( !empty($dataportfolioinfo) ) {
			$DistinctCurrencies = json_decode($dataportfolioinfo->DistinctCurrencies);
			foreach( $DistinctCurrencies as $key=>$pair ) {
				$Currencies[$pair] = $pair;
			}
			$PortfolioNamelists = json_decode($dataportfolioinfo->PortfolioNames);
			foreach( $PortfolioNamelists as $key=>$pair ) {
				$PortfolioNames[$pair] = $pair;
			}
			$DisplayNameLists = json_decode($dataportfolioinfo->OrganisationModelsData);
			foreach( $DisplayNameLists as $key=>$pairLists ) {
				if( $key == 'DisplayName') {
					foreach( $pairLists as $keypair=>$pairList ) {
						$dateselected = explode('|', $pairList);
						$DisplayNames[$pairList] = $pairList;
					}
				}
			}
		}
		$InitialiseApidata = (!empty($allocatorData->InitialiseApidata) ? (object)self::decodeparams($allocatorData->InitialiseApidata) : '');
		if( !empty($InitialiseApidata->PortfolioNames) ) {
			foreach( $InitialiseApidata->PortfolioNames as $key=>$datainfo ) {
				$PortfolioLists[$datainfo['pair']] = $datainfo['pair']; 
			}
		} else { 
			$PortfolioLists = $PortfolioNames ;
		}
		$data['info'] = (object)self::decodeparams($allocatorData->BasicInfo);
		$data['Currencies'] = array_reverse($Currencies);
		$data['ClientName'] = $allocatorData->ClientName;
		$data['PortfolioNames'] = $PortfolioLists;
		$data['DisplayNames'] = $DisplayNames;
		$data['InitialiseApidata'] = $allocatorData->InitialiseApidata;
		$data['iduserallocator'] = $this->input->get('iduserallocator');
		$this->loadAjaxViews("assetAllocator/editassetallocatorhtml", $data);		
	}
	public function getCurrentTailoredData_json(){
		$iduserallocator = decryptKey($this->input->get('tokenkey'));
		$RevealiTemStatus = $this->input->get('RevealiTemStatus');
		$allocatorData = $this->assetallocators->get_SingleallocatorsData($iduserallocator);
		$BasicInfo = (object)self::decodeparams($allocatorData->BasicInfo);
		$getOrganisatioinfo = $this->auth->getuserinfo($this->userid);
		$txtDateSelecteds  = explode('|', $BasicInfo->reportdate);
		$ObjectInitialise = array(
			'nargout'=>1,
			'rhs' => array('txtAction','Initialise','txtOrganisationID',$getOrganisatioinfo->OrganisationApiName,'txtDateSelected',$txtDateSelecteds[0],'txtCurrencySelected',$BasicInfo->referencecurrency,'txtSessionID',$this->organisation,'txtUserID',$getOrganisatioinfo->id,'txtDataSetName',$txtDateSelecteds[1])
		);
		self::__getApiAssetData(json_encode($ObjectInitialise));
		echo json_encode(array(
			'txtSessionID' => $this->organisation,
			'txtUserID' => $getOrganisatioinfo->id,
			'txtDataSetName' => $BasicInfo->reportdate,
			'txtCurrencySelected' => $BasicInfo->referencecurrency,
			'RevealiTemStatus' => $RevealiTemStatus,
			'txtPortfolioName2Set' => $BasicInfo->portfoliostrategy,
			'txtOrganisationID' => $getOrganisatioinfo->OrganisationApiName,
		));		
	}
	public function request_graphparameters_json(){
		$iduserallocator = decryptKey($this->input->post('tokenkey'));
		$idallocator = $this->input->post('idallocator');
		$type = decryptKey($this->input->post('type'));
		$parameters = $this->input->post('parameters');
		if( $type == 'reInitialise' ) {
			$allocatorData = $this->assetallocators->get_SingleallocatorsData($idallocator);
			$BasicInfo = (object)self::decodeparams($allocatorData->BasicInfo);
			$getOrganisatioinfo = $this->auth->getuserinfo($this->userid);
			$txtDateSelecteds  = explode('|', $BasicInfo->reportdate);
			$ObjectInitialise = array(
				'nargout'=>1,
				'rhs' => array('txtAction','Initialise','txtOrganisationID',$getOrganisatioinfo->OrganisationName,'txtDateSelected',$txtDateSelecteds[0],'txtCurrencySelected',$BasicInfo->referencecurrency,'txtSessionID',$this->organisation,'txtUserID',$this->userid,'txtDataSetName',$txtDateSelecteds[1])
			);
			$parameters = json_encode($ObjectInitialise);
		}
		$apiresponse = self::__getApiAssetData($parameters);
		if( !empty($iduserallocator) ) {
			$this->assetallocators->Updated_allocatorparams(array('apidata'=>$apiresponse), $iduserallocator);
		}
		echo $apiresponse;
	} 
	public function Updateallocatorbasicinfo_Ajax(){	
		$iduserallocator = decryptKey($this->input->post('tokenkey'));
		$allocatorData = $this->assetallocators->get_SingleallocatorsData($iduserallocator);
		$BasicInfo = (object)self::decodeparams($allocatorData->BasicInfo);
		$getOrganisatioinfo = $this->auth->getuserinfo($this->userid);
		
		if( $this->input->post('type') == 'portfolio') {
			$portfoliostrategy = $this->input->post('key');
			$referencecurrency = $BasicInfo->referencecurrency;
		} else if( $this->input->post('type') == 'currency') {
			$referencecurrency = $this->input->post('key');
			$portfoliostrategy = $BasicInfo->portfoliostrategy;
		}
		$minimumhorizon = decryptKey($this->input->post('minimumhorizon'));
		$objData = array(
			'clientname'=>$allocatorData->ClientName,
			'reportdate'=>$BasicInfo->reportdate,
			'introducer'=>$BasicInfo->introducer,
			'displayname'=>'18/07/2023',
			'referencecurrency'=>$referencecurrency,
			'portfoliostrategy'=>$portfoliostrategy,
			'minimumhorizon'=>$minimumhorizon,
			'annualreturn'=>0,
			'avoiddrawdown'=>0
		);
		$parameters = array(
			'BasicInfo'=>urlencode(json_encode($objData)),
			'User'=>$this->userid,
			'ClientName'=>$allocatorData->ClientName,
			'created_at'=>date('Y-m-d h:i:s')
		);
		$getOrganisatioinfo = $this->auth->getuserinfo($this->userid);
		$txtDateSelecteds  = explode('|', $BasicInfo->reportdate);
		$ObjectInitialise = array(
			'nargout'=>1,
			'rhs' => array('txtAction','Initialise','txtOrganisationID',$getOrganisatioinfo->OrganisationName,'txtDateSelected',$txtDateSelecteds[0],'txtCurrencySelected',$referencecurrency,'txtSessionID',$this->organisation,'txtUserID',$this->userid,'txtDataSetName',$txtDateSelecteds[1])
		);
		if( $this->input->post('type') == 'currency') {
			self::__getApiAssetData(json_encode($ObjectInitialise));
		}
		$apiresponse = $this->runAssetAllocator($portfoliostrategy,$referencecurrency,$BasicInfo->reportdate);
		
		if( !empty($iduserallocator) ) {
			$parameters['apidata'] = $apiresponse;
			$parameters['modifieddate'] = date('Y-m-d h:i:s');
			$iduserallocator = $this->assetallocators->Updated_allocatorparams($parameters, $iduserallocator);
		}
		echo json_encode(array(
			'status' => false,
			'apiresponse' => $apiresponse,
			'type' => $this->input->post('type'),
			'iduserallocator' => $iduserallocator,
			'message' =>'Saved successfully'
		));
	}
	public function confirmdeteleassetcollator() {
		$data['title']  = 'Asset Allocator | '.$this->title;
		$iduserallocator = decryptKey($this->input->get('iduserallocator'));
		$allocatorData = $this->assetallocators->get_SingleallocatorsData($iduserallocator);
		$data['ClientName'] = $allocatorData->ClientName;
		$data['type'] = $this->input->get('type');
		$data['iduserallocator'] = $this->input->get('iduserallocator');
		$this->loadAjaxViews("assetAllocator/confirmdeteleassetcollatorhtml", $data);		
	}
	public function confirmdeteleassetcollatoraction() {
		$iduserallocator = decryptKey($this->input->post('iduserallocator'));	
		$isdeleted = decryptKey($this->input->post('type'));
		$deletedinfo = array(
			'User ID'=>$this->userid,
			'OnDate'=>date('Y-m-d H:i:s'),
			'Machine IP'=>$_SERVER ['REMOTE_ADDR'],
			'Browser '=>$_SERVER ['HTTP_USER_AGENT']
		);
		$this->assetallocators->Updated_allocatorparams(array('deletedinfo'=>json_encode($deletedinfo),'isdeleted'=>$isdeleted), $iduserallocator);
		echo json_encode(array(
			'status' => true,
			'iduserallocator' => $iduserallocator,
			'http_redirect'=> website_url($this->controller)
		));
	}
}