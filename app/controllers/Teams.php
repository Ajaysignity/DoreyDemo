<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/FrontEndController.php';
class Teams extends FrontEndController {
	public function __construct() {
		parent::__construct();
		$this->isUserLoggedIn();
		$this->Solnlimit = 10;
		$this->folder = 'apps/';
	}
	public function index(){
		redirect(base_url($this->controller.'/settings'));
	}
	public function myteam() {
		$data['title']  = 'My team | '.$this->title;
		$data['info'] = $this->auth->getorganisationinfo($this->organisation);
		$view = $this->folder.'myteamshtml';
		$this->load->view('authlayouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function myteam_json() {
		$mode = $this->input->get('mode');
		$getsolns = $this->teams->myteam_json($_POST, $mode);
		$output = array(
			"recordsTotal" =>$getsolns['TotalRows'] ,
			"recordsFiltered" => $getsolns['TotalRows'],
			"data" => $getsolns['returndata'],
		);
		echo json_encode( $output );
	}
	public function roles() {
		$data['title']  = 'Roles | '.$this->title;
		$view = $this->folder.'/roleshtml';
		$this->load->view('authlayouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function roles_json() {
		$getsolns = $this->teams->getroles_json($_POST);
		$output = array(
			"recordsTotal" =>$getsolns['TotalRows'] ,
			"recordsFiltered" => $getsolns['TotalRows'],
			"data" => $getsolns['returndata'],
		);
		echo json_encode( $output );
	} 
	public function saveroles() {
		$this->form_validation->set_rules('rolename', 'rolename', 'required|xss_clean|max_length[30]');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array(
				'status' => false,
				'message' =>validation_errors()
			));
		} else {
			$parameters = array(
				'rolename' => $this->input->post('rolename'),
				'isactive' => $this->input->post('isactive'),
				'organisationid' => $this->organisation,
				'panel' => 'app',
				'description' => $this->input->post('description')
			);
			if( !empty($this->input->post('editroleid')) ) {
				$editroleid = decryptKey($this->input->post('editroleid'));
				$getsolns = $this->teams->updaterole($editroleid,$parameters);
				$message = 'updated';
			} else {
				$getsolns = $this->teams->saveroles($parameters);
				$message = 'saved';
			}
			if($getsolns) {
				echo json_encode(array(
					'status' => true,
					'refreshtable' => true,
					'message' =>'Role name has been '.$message.' successfully'
				));
			} else {
				echo json_encode(array(
					'status' => false,
					'message' =>' Role name already exists'
				));
			}
		}
	}
	public function editrole() {
		$data['title'] = 'Edit Role | '.$this->title;
		$autoid = decryptKey($this->input->get('autoid'));
		$data['info'] = $this->teams->getroleinfo($autoid);
		$this->loadAjaxViews("editroleshtml", $data);	
    }
	public function permissions() {
		$data['title'] = 'Permission | '.$this->title;
		$autoid = decryptKey($this->input->get('autoid'));
		$data['info'] = $this->teams->getroleinfo($autoid);
		$data['roleid'] = $this->input->get('autoid');
		$data['lists'] = $this->teams->getmenuname($autoid);
		$AppArrayList = [];
		foreach (applists() as $applist ) {
			$AppArrayList[] =  $applist['methods'];
		}
		$data['AppArrayLists'] = $AppArrayList;
		$this->loadAjaxViews("permissionshtml", $data);	
	}
	public function savepermissions() {
		$actionmenus = $this->input->post('actionid');
		$roleid = decryptKey($this->input->post('roleid'));
		$listmenu = array();
		foreach($actionmenus as $menuid => $actionid ):
			$listmenu[] = array(
				'menuid' => $menuid,
				'actionlabel' => implode(',',$actionid),
				'roleid' => $roleid,
				'panel' => 'app'
			);
		endforeach;
		$this->teams->savepermissions($roleid,$listmenu);
		echo json_encode(array(
			'status' => true,
			'refreshtable' => true,
			'message' =>'Permission has been saved successfully'
		));
	}
	public function settings() {
		$data['title']  = 'Settings | '.$this->title;
		$view = $this->folder.'/settingshtml';
		$this->load->view('authlayouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function add() {
		$data['title']  = 'Add team | '.$this->title;
		$this->loadAjaxViews("addteamuserinfohtml", $data);	
	}
	public function savenewteam() {
		$this->form_validation->set_rules('firstname', 'First name', 'required|xss_clean');
		$this->form_validation->set_rules('surname', 'Surname', 'required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|xss_clean');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|xss_clean|max_length[15]');
		$this->form_validation->set_rules('authorisation', 'Authorisation', 'required|xss_clean');
		$this->form_validation->set_rules('useraccountlevel', 'Role', 'required|xss_clean');
		//if(  $this->input->post('useraccountlevel') == 'yes' ) {
			$this->form_validation->set_rules('roleid', 'role name', 'required|xss_clean');
		//}
		$this->form_validation->set_rules('termcheck', 'I agree to the Financial Projector Terms & Conditions', 'required|xss_clean');
		$this->form_validation->set_rules('nodeaccess', 'Somthing went wrong', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array(
				'status' => false,
				'otpscreen' => false,
				'message' =>validation_errors()
			));
		} else {
			$nodeaccess = decryptKey($this->input->post('nodeaccess'));
			$username = $this->input->post('email');
			$checkusername = $this->teams->CountUsername($username);
			$checkuseremail = $this->teams->CountUsername(false,$this->input->post('email'));
			$checkuserMobile = $this->teams->CountUsername(false,false,$this->input->post('mobile'));
			if($checkusername >0 ) {
				echo json_encode(array(
					'status' => false,
					'otpscreen' => false,
					'message' =>'Email already exists, please try other'
				));
			} else if($checkuseremail >0 ) {
				echo json_encode(array(
					'status' => false,
					'otpscreen' => false,
					'message' =>'Email already exists, please try other'
				));
			} else if($checkuserMobile >0 ) {
				echo json_encode(array(
					'status' => false,
					'otpscreen' => false,
					'message' =>'Mobile number already exists, please try other'
				));
			} else {
				$uploadError = false;
				$verification_code = md5($username).rand(10,9999);
				$expFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
				$verification_expirelink = date("Y-m-d H:i:s",$expFormat);
				$parameters =array(
					'username'=> $username,
					'email'=> $this->input->post('email'),
					//'roleid'=> ($this->input->post('useraccountlevel') == 'yes' ? $this->input->post('roleid') : 0),
					'roleid'=> $this->input->post('roleid'),
					'firstname'=> $this->input->post('firstname'),
					'surname'=> $this->input->post('surname'),
					'twofa'=> $this->input->post('twofa'),
					'mobile'=> $this->input->post('mobile'),
					'organisation'=> $this->organisation,
					'PowerUser'=> ($this->input->post('useraccountlevel')== 'yes' ? 1 : 0),
					'active'=> ($this->input->post('authorisation')== 'approved' ? 1 : 0),
					'verification_expirelink'=> $verification_expirelink,
					'verification_code'=> $verification_code,
					'createdby'=> $this->userid,
					'created_at'=> date('Y-m-d H:i:s'),
					'isorganisation'=> 'no'
				);
				if( !empty($_FILES['userprofilepic']['name']) ) {
					$getimage = $this->upload_image('userprofilepic',$_FILES['userprofilepic']['name'],'profile');
					if($getimage['status'] == FALSE ) {
						$uploadError = true;
					} else {
						$parameters['userprofilepic'] = $getimage['filename'];
					}
				}
				if( !empty($uploadError) ) {
					echo json_encode(array( 'status' => false,'message' => 'Please upload jpg/png/gif image only and size must be less than 2MB' ));
					exit;
				} else {
					$TeamID = $this->teams->InsertTeamUsers($parameters);
					$EmailLink = website_url("generate-password?key=".encryptKey($TeamID)."&token=".$verification_code);
					$message = "
					<p>Dear ".ucwords($this->input->post('firstname').' '.$this->input->post('surname')).", </p>
					<p>Welcome to Financial Projector. </p>
					<p>Your organisation account name is ".$this->input->post('OrganisationName')."</p>
					<p>Your username is: ".$username."</p>
					<p>To complete your set up, click <a href='".$EmailLink."'>here</a> or copy and paste ".$EmailLink." into your browser (Internet Explorer is not supported).</p>";
					
					$subject = "Finish setting up your ".$this->input->post('OrganisationName')." account";
					sendemail($this->input->post('email'), $subject, $message);
					if( $nodeaccess == 'create' ) {
						echo json_encode(array(
							'status' => true,
							'successpopup' => true,
							'message' => '<h3 style="font-size: 20px;margin: 20px 0px 0px 0px;">Welcome to Financial Projector</h3><p>We’ve sent an email link to complete account set up</p>'
						));
					} else if( $nodeaccess == 'upgrade' ) {
						echo json_encode(array(
							'status' => true,
							'successpopup' => false,
							'http_redirect' => website_url('teams/processing'),
							'message' => '<h3 style="font-size: 20px;margin: 20px 0px 0px 0px;">Welcome to Financial Projector</h3><p>We’ve sent an email link to complete account set up</p>'
						));
					} else {
						echo json_encode(array(
							'status' => true,
							'successpopup' => true,
							'message' => '<h3 style="font-size: 20px;margin: 20px 0px 0px 0px;">Access denied, something went wrong with fields data</p>'
						));
					}
				}
			}
		}
	}
	public function updateteam() {
		$this->form_validation->set_rules('edit_teamuser_id', 'Somthing wrong with user', 'required|xss_clean');
		$this->form_validation->set_rules('firstname', 'First name', 'required|xss_clean');
		$this->form_validation->set_rules('surname', 'Surname', 'required|xss_clean');
		//$this->form_validation->set_rules('username', 'Username', 'required|xss_clean');
		//$this->form_validation->set_rules('username', 'Username', 'xss_clean|required|trim|min_length[6]|max_length[25]');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|xss_clean');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|xss_clean|max_length[15]');
		$this->form_validation->set_rules('authorisation', 'Authorisation', 'required|xss_clean');
		$this->form_validation->set_rules('useraccountlevel', 'Role', 'required|xss_clean');
		
		if(  $this->input->post('useraccountlevel') == 'yes' ) {
			$this->form_validation->set_rules('roleid', 'role name', 'required|xss_clean');
		}
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array(
				'status' => false,
				'otpscreen' => false,
				'message' =>validation_errors()
			));
		} else {
			$edit_teamuser_id = decryptKey($this->input->post('edit_teamuser_id'));
			$username = $this->input->post('email');
			$checkusername=$this->teams->CountUsername($username,false,false,$edit_teamuser_id);
			$checkuseremail = $this->teams->CountUsername(false,$this->input->post('email'),false,$edit_teamuser_id);
			$checkuserMobile = $this->teams->CountUsername(false,false,$this->input->post('mobile'),$edit_teamuser_id);
			if($checkusername >0 ) {
				echo json_encode(array(
					'status' => false,
					'otpscreen' => false,
					'message' =>'Email already exists, please try other'
				));
			} else if($checkuseremail >0 ) {
				echo json_encode(array(
					'status' => false,
					'otpscreen' => false,
					'message' =>'Email already exists, please try other'
				));
			} else if($checkuserMobile >0 ) {
				echo json_encode(array(
					'status' => false,
					'otpscreen' => false,
					'message' =>'Mobile number already exists, please try other'
				));
			} else {
				$uploadError = false;$authorisation = 0;
				if( $this->input->post('authorisation') == 'approved' ) {
					$authorisation = 1;
				} else if( $this->input->post('authorisation') == 'archive' ) {
					$authorisation = 2;
				}
				$parameters =array(
					'username'=> $username,
					'roleid'=> ($this->input->post('useraccountlevel') == 'yes' ? $this->input->post('roleid') : 0),
					'email'=> $this->input->post('email'),
					'firstname'=> $this->input->post('firstname'),
					'surname'=> $this->input->post('surname'),
					'twofa'=> $this->input->post('twofa'),
					'mobile'=> $this->input->post('mobile'),
					'PowerUser'=> ($this->input->post('useraccountlevel')== 'yes' ? 1 : 0),
					'active'=> $authorisation,
					'updatedby'=> $this->userid,
				);
				if( !empty($_FILES['userprofilepic']['name']) ) {
					$getimage = $this->upload_image('userprofilepic',$_FILES['userprofilepic']['name'],'profile');
					if($getimage['status'] == FALSE ) {
						$uploadError = true;
					} else {
						$parameters['userprofilepic'] = $getimage['filename'];
					}
				}
				if( !empty($uploadError) ) {
					echo json_encode(array( 'status' => false,'message' => 'Please upload jpg/png/gif image only and size must be less than 2MB' ));
					exit;
				} else {
					$this->auth->UpdateUserInfo($edit_teamuser_id,$parameters);
					echo json_encode(array(
						'status' => true,
						'refreshtable' => true,
						'message' => 'Profile has been updated successfully'
					));
				}
			}
		}
	}
	public function editteam() {
		$data['title']  = 'Edit team | '.$this->title;
		$autoid = decryptKey($this->input->get('autoid'));
		$data['info']  = $this->auth->getuserinfo($autoid);
		$this->loadAjaxViews("editteamuserinfohtml", $data);		
	}
	public function trashteamuser() {
		$data['title']  = 'Trash user | '.$this->title;
		$autoid = decryptKey($this->input->get('autoid'));
		$data['info']  = $this->auth->getuserinfo($autoid);
		$this->loadAjaxViews("trashteamuserhtml", $data);		
	}
	public function removeteamusers() {
		$userid = decryptKey($this->input->post('userid'));
		$actiontype = decryptKey($this->input->post('actiontype'));
		$info  = $this->auth->getuserinfo($userid);
		if( empty($userid) ) {
			echo json_encode(array(
				'status' => false,
				'message' => 'Some issue occur please refersh and try again'
			));
		} else {
			if( $actiontype == 'delete') {
				$parameters = array(
					'isDeleted' =>1,
					'username' =>$info->username.'_DEL_'.date('Y-m-d:H:i:s').'::'.rand(1931,7979),
					'email' =>$info->email.'_ID_'.$this->userid.'::'.rand(1231,7879),
					'mobile' =>$info->mobile.'_IP_'.$_SERVER['REMOTE_ADDR'].'::'.rand(6231,9879),
				);
				$this->auth->UpdateUserInfo($userid,$parameters);
				echo json_encode(array(
					'status' => true,
					'refreshtable' => true,
					'message' => 'User has been deleted successfully'
				));
			} else if( $actiontype == 'archive') {
				$parameters = array(
					'active' =>2
				);
				$this->auth->UpdateUserInfo($userid,$parameters);
				echo json_encode(array(
					'status' => true,
					'refreshtable' => true,
					'message' => 'User has been archived successfully'
				));
			} else {
				echo json_encode(array(
					'status' => false,
					'message' => 'Acces denied, please refersh the page'
				));
			}
		}
	}
	public function updateorganisation(){
		$this->form_validation->set_rules('OrganisationName', 'account name', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array(
				'status' => false,
				'otpscreen' => false,
				'message' =>validation_errors()
			));
		} else {
			$parameters = array(
				'OrganisationName' => $this->input->post('OrganisationName'),
				'SubFileLocation' => $this->input->post('OrganisationName'),
				'UpdatedBy' => $this->userid.'-DTIME-'.date('Y-m-d H:i:s').'-IP-'.$_SERVER['REMOTE_ADDR'],
			);
			$this->teams->updateorganisation($this->organisation,$parameters);
			echo json_encode(array(
				'status' => true,
				'successpopup' => true,
				'message' => 'Account name has been updated successfully'
			));
		}
	}



























	
	
}