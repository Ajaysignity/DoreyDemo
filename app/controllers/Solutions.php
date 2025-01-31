<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/FrontEndController.php';

class Solutions extends FrontEndController {
	public function __construct() {
		parent::__construct();
		$this->load->model('Solution_model','solutions');
		$this->load->helper('solutions');
		$this->folder = $this->template.'/solutions/';
	}
	public function index(){
		redirect(base_url($this->controller.'/mysolutions'));
	}
	public function myfolders_json() {
		$isarchived = $this->input->get('isarchived');
		$FoldersData = $this->solutions->getallfolders(1,$isarchived); 
		$output = array(
			"recordsTotal" =>'',
			"recordsFiltered" =>'',
			"data" => $FoldersData,
		);
		echo ($FoldersData);
	}
	public function mysolutions() {
		$data['title']  = 'My solutions | '.$this->title;
		$datasearch = $this->input->get('search');
		$data['search'] = $datasearch; 
		$view = $this->folder.'mysolutionshtml';
		$this->load->view('authlayouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function mysolutions_json() {
		$Parentfolderid = $this->input->get('folder');
		$isarchived = $this->input->get('isarchived');
		$getsolns = $this->solutions->getmysolutions($_POST, $Parentfolderid,$isarchived);
		$output = array(
			"recordsTotal" =>$getsolns['TotalRows'] ,
			"recordsFiltered" => $getsolns['TotalRows'],
			"data" => $getsolns['returndata'],
		);
		echo json_encode($output);
	}
	public function searchsolutionlist_json() {
        $searchkey = $this->input->get('searchkey');
		$getsolns = $this->solutions->_SearchedSolutions($_POST, $searchkey);
		$output = array(
			"recordsTotal" =>$getsolns['TotalRows'] ,
			"recordsFiltered" => $getsolns['TotalRows'],
			"data" => $getsolns['returndata'],
		);
		echo json_encode($output);
	}
	public function savenewsolutionfolder() {
		$ModelType = $this->input->post('ModelType');
		$this->form_validation->set_rules('ModelType', 'Type', 'required|xss_clean');
		$this->form_validation->set_rules('solutiontype', $ModelType, 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array(
				'status' => false,
				'otpscreen' => false,
				'message' =>validation_errors()
			));
		} else {
			$nextboxnumer = ( !empty($this->input->post('nextboxnumer')) ?  $this->input->post('nextboxnumer') : 1);
			$ModelTypeLabel = ($ModelType == 'Folder' ? 'Folder ' : 'Solution ');
			$foldertype = $this->input->post('foldertype');
			$actiontakenid = $this->input->post('actiontakenid');
			$solutiontype = $this->input->post('solutiontype');
			$results = SolutionDefaulValues($ModelType);
			if( !empty($actiontakenid) ) {
				$idusersolutions = decryptKey($actiontakenid);
				$parameters = array('Solution' =>$solutiontype);
				$this->solutions->UpdateSolutions($this->userid,$idusersolutions, $parameters);
				echo json_encode(array(
					'status' => true,
					'ModelType' => $ModelType,
					'nextboxnumer' =>$nextboxnumer,
					'foldertype' => $foldertype,
					'foldrunique' =>$this->input->post('FolderUniQIDS'),
					'foldrprntid' =>$this->input->post('FolderPrntQIDS'),
					'message' => $ModelTypeLabel." has been created successfully"
				));
			} else {
				$parameters = array(
					'User' =>$this->userid,
					'Type' =>$ModelType,
					'Parameters' =>$results['value'],
					'Solution' =>$solutiontype,
				);
				if( $ModelType == 'Folder') {
					$parameters['UniqueFolderID'] = $this->solutions->NextUniqueFolderID();
				}
				if( !empty($this->input->post('FolderUniQIDS')) ) {
					$parameters['ParentFolderID'] = $this->input->post('FolderUniQIDS');
				}
				$InsertedSolnID = $this->solutions->SaveSolutionFolder($parameters);
				echo json_encode(array(
					'status' => true,
					'ModelType' => $ModelType,
					'foldertype' => $foldertype,
					'nextboxnumer' =>$nextboxnumer,
					'foldrunique' =>$this->input->post('FolderUniQIDS'),
					'foldrprntid' =>$this->input->post('FolderPrntQIDS'),
					'http_redirect'=> (strpos($_SERVER["HTTP_REFERER"], 'mysolutions') !== false ? false : website_url('solutions/mysolutions') ),
					'message' => $ModelTypeLabel." has been created successfully"
				));
			}
		}
	}
	public function addsubfolder() {
		$data['title']  = 'My solutions | '.$this->title;
		$dataautoid = decryptKey($this->input->get('autoid'));
		$data['autoid'] = $dataautoid;
		$data['info']  = $this->solutions->getsolutionInfo($this->userid,$dataautoid);
		$data['FolderUniQIDS'] = $this->input->get('FolderUniQIDS');
		$data['nextboxnumer'] = $this->input->get('nextboxnumer');
		$this->loadAjaxViews("solutions/addsubfolderhtml", $data);		
	}
	public function addfoldersolution() {
		$data['title']  = 'My solutions | '.$this->title;
		$dataautoid = decryptKey($this->input->get('autoid'));
		$data['autoid'] = $dataautoid;
		$data['info']  = $this->solutions->getsolutionInfo($this->userid,$dataautoid);
		$data['FolderUniQIDS'] = $this->input->get('FolderUniQIDS');
		$data['nextboxnumer'] = $this->input->get('nextboxnumer');
		$this->loadAjaxViews("solutions/addfoldersolutionhtml", $data);		
	}
	public function savenewsubsolutionfolder() {
		$ModelType = 'CashflowModel';
		$this->form_validation->set_rules('ModelType', 'Type', 'required|xss_clean');
		$this->form_validation->set_rules('solutiontype', $ModelType, 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array(
				'status' => false,
				'otpscreen' => false,
				'message' =>validation_errors()
			));
		} else {
			$nextboxnumer = ( !empty($this->input->post('nextboxnumer')) ?  $this->input->post('nextboxnumer') : 1);
			$foldertype = $this->input->post('foldertype');
			$solutiontype = $this->input->post('solutiontype');
			$results = SolutionDefaulValues($ModelType);
			$parameters = array(
				'User' =>$this->userid,
				'Type' =>$ModelType,
				'Parameters' =>$results['value'],
				'Solution' =>$solutiontype,
			);
			if( !empty($this->input->post('FolderUniQIDS')) ) {
				$parameters['ParentFolderID'] = $this->input->post('FolderUniQIDS');
			}
			$this->solutions->SaveSolutionFolder($parameters);
			echo json_encode(array(
				'status' => true,
				'ModelType' => 'CashflowModel',
				'foldertype' => $foldertype,
				'nextboxnumer' =>$nextboxnumer,
				'foldrunique' =>$this->input->post('FolderUniQIDS'),
				'foldrprntid' =>$this->input->post('FolderPrntQIDS'),
				'http_redirect'=> (strpos($_SERVER["HTTP_REFERER"], 'mysolutions') !== false ? false : website_url('solutions/mysolutions') ),
				'message' => "Solution has been created successfully"
			));
		}
	}
	public function mysubfolders_json() {
		$nextboxnumer = $this->input->get('nextboxnumer');
		$solnid = $this->input->get('solnid');
		$isarchived = $this->input->get('isarchived');
		$Parentfolderid = $this->input->get('Parentfolderid');
		$FoldersData = $this->solutions->getsubfolderslist($nextboxnumer, $solnid, $Parentfolderid,$isarchived);
		 
		$output = array(
			"recordsTotal" =>'',
			"recordsFiltered" =>'',
			"data" => $FoldersData,
		);
		echo ($FoldersData);
	}
	public function renamesolutionfolder() {
		$data['title']  = 'My solutions | '.$this->title;
		$autoid = decryptKey($this->input->get('autoid'));
		$data['nextboxnumer'] = $this->input->get('nextboxnumer');
		$data['FolderPrntQIDS'] = $this->input->get('FolderPrntQIDS');
		$data['info']  = $this->solutions->getsolutionInfo($this->userid,$autoid);
		$this->loadAjaxViews("solutions/renamesolutionfolderhtml", $data);		
	}
	public function makeduplicatesolution(){
		$userid = decryptKey($this->input->post('userid'));
		$FolderUniQIDS = $this->input->post('FolderUniQIDS');
		$FolderPrntQIDS = $this->input->post('FolderPrntQIDS');
		$nextboxnumer = $this->input->post('nextboxnumer');
		$solid = decryptKey($this->input->post('SolRow'));
		$info  = $this->solutions->getsolutionInfo($userid,$solid);
		$duplicate = $info->Solution.'-duplicate';
		$this->solutions->MakeDuplicateSolutions($userid,$solid,$duplicate,$info->Type,$nextboxnumer );
		echo json_encode(array(
			'status' => true,
			'successpopup' => false,
			'nextboxnumer' =>$nextboxnumer,
			'foldrunique' =>$this->input->post('FolderUniQIDS'),
			'foldrprntid' =>$this->input->post('FolderPrntQIDS'),
			'ModelType' => $info->Type,
			'message' => '<b>'.$info->Solution.'</b> has been copied successfully'
		));
	}
	public function removesolutions() {
		$data['title']  = 'My solutions | '.$this->title;
		$idusersolutions = decryptKey($this->input->post('SolRow'));
		if( !empty($idusersolutions)) {
			$SolutionName =$this->solutions->movetowastebasketsolutions($idusersolutions);
			echo json_encode(array(
				'status' => true,
				'message' => 'Folder <b>'.$SolutionName.'</b> has been moved to waste basket'
			));
		}
	}
	public function cashflow(){
		$tokenkey = $this->input->get('tokenkey');
		redirect(base_url('cashflow?tokenkey='.$tokenkey));
	}
}