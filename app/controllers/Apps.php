<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/FrontEndController.php';
class Apps extends FrontEndController {
	public function __construct() {
		parent::__construct();
		$this->folder = 'apps/';
		$this->title = 'Financial Projector by Dorey Financial Modelling';
	}

	public function index() {

		$files = glob('./assets/captchaimages/*');
		array_walk($files, function($file) {
			unlink($file);
		});

		$data['title']  = $this->title;
		$view = 'appshtml';
		$this->load->view('authlayouthtml',  array('data'=>$data,'views'=> $view));
	}

	public function myprofile() {
		$data['title']  = 'My Profile | '.$this->title;
		$allusers = array();//$this->teams->getOrganisationUsers();
		$userlist = array();
		foreach( $allusers as $alluser ) {
			$userlist[encryptKey($alluser->id)] = ($alluser->firstname.' '.$alluser->surname);
		}
		$data['userlist'] = $userlist;
		$view = $this->folder.'myprofilehtml';
		$this->load->view('authlayouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function updatecurrentprofile() { 
		if( $this->input->post("action") == 'profile') {
			$this->form_validation->set_rules('username', 'Email', 'required|trim|valid_email|xss_clean');
		}
		if( $this->input->post("action") == 'verifiedOTPmobile') {
			$this->form_validation->set_rules('mobileotpnumber','OTP', 'xss_clean|required');
		}
		if( $this->input->post("action") == 'verifymobile') {
			$this->form_validation->set_rules('currentmobile','current mobile', 'xss_clean|required');
			$this->form_validation->set_rules('newmobile','new mobile', 'xss_clean|required|is_numeric');
		}
		if( $this->input->post("action") == 'password') {
			$this->form_validation->set_rules('currentpassword','current password', 'xss_clean|required');
			$this->form_validation->set_rules('newpassword', 'new password', 'xss_clean|required');
			$this->form_validation->set_rules('confirmpassword', 'confirm  password', 'xss_clean|required|matches[newpassword]');
		}
		if( $this->input->post("action") == 'twofaupdate') {
			$this->form_validation->set_rules('twofa','Two-Factor Authentication', 'xss_clean|required');
		}

		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array(
				'status' => false,
				'otpscreen' => false,
				'message' =>validation_errors()
			));
		} else {
			if( $this->input->post("action") == 'profile') {
				$username = $this->input->post("username");
				$checkusername = $this->auth->CountUsername($this->userid,$username);
				if($checkusername >0 ) {
					echo json_encode(array(
						'status' => false,
						'otpscreen' => false,
						'message' =>'Username already exists, please try other'
					));
				}  else {
					$parameters = array('email' =>$username,'username' =>$username);
					$this->auth->UpdateUserInfo($this->userid,$parameters);
					$UserInfo = $this->auth->getuserinfo($this->userid);
					$message = "
					<p>Dear ".ucwords($UserInfo->firstname.' '.$UserInfo->surname).", </p>
					<p>Your username has been changed to <b>".$username."</b> </p>";
					sendemail($UserInfo->email,'Confirmation of change to settings', $message);
					echo json_encode(array(
						'status' => true,
						'successpopup' => true,
						'message' => "Profile has been updated successfully"
					));
				}
			} else if( $this->input->post("action") == 'password') {
				$currentpassword = $this->input->post("currentpassword");
				$confirmpassword = $this->input->post("confirmpassword");
				$UserInfo = $this->auth->getuserinfo($this->userid);
				if( isset($UserInfo->password) && password_verify($currentpassword, $UserInfo->password) ){
					$encytpassword = password_hash($confirmpassword, PASSWORD_DEFAULT);
					$parameters = array('password' =>$encytpassword);
					$this->auth->UpdateUserInfo($this->userid,$parameters);
					$message = "
					<p>Dear ".ucwords($UserInfo->firstname.' '.$UserInfo->surname).", </p>
					<p>Your password has been changed. </p>";
					sendemail($UserInfo->email,'Confirmation of change to settings', $message);
					echo json_encode(array(
						'status' => true,
						'successpopup' => true,
						'message' => "Password has been updated successfully"
					));
				} else {
					echo json_encode(array(
						'status' => false,
						'successpopup' => true,
						'message' => 'Current password is incorrect, Please contact with admin'
					));
				}
			} else if( $this->input->post("action") == 'twofaupdate') {
				$twofa = $this->input->post("twofa");
				$parameters = array('twofa' =>$twofa);
				$this->auth->UpdateUserInfo($this->userid,$parameters);
				echo json_encode(array(
					'status' => true,
					'successpopup' => true,
					'message' => "Two-Factor Authentication has been updated successfully"
				));
			}
		}
	}
	public function updateuserprofilepic() {
		if( !empty($_FILES['userprofilepicfile']['name']) ) {
			$getimage = $this->upload_image('userprofilepicfile',$_FILES['userprofilepicfile']['name'],'profile');
			$userprofilepicfile = $getimage['filename'];
			if($getimage['status'] == FALSE ) {
				echo json_encode(array( 'status' => false,'message' => 'Please upload jpg/png/gif image only and size must be less than 2MB' ));
				exit;
			} else {
				$parameters = array(
					'userprofilepic' =>$getimage['filename']
				);
				$this->auth->UpdateUserInfo($this->userid,$parameters);
				echo json_encode(array(
					'status' => true,
					'message' => "Profile photo has been updated"
				));
			}
		}
	}
	public function styling() {
		$data['title']  = 'Branding | '.$this->title;
		$view = $this->folder.'/stylingshtml';
		$this->load->view('authlayouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function updateorganisation() {
		if( !empty($_FILES['organisationlogo']['name']) ) {
			$getimage = $this->upload_image('organisationlogo',$_FILES['organisationlogo']['name'],'organisation');
			$userprofilepicfile = $getimage['filename'];
			if($getimage['status'] == FALSE ) {
				echo json_encode(array( 'status' => false,'message' => 'Please upload jpg/png/gif image only and size must be less than 2MB' ));
				exit;
			} else {
				$parameters = array(
					'Logo' =>$getimage['filename']
				);
				$this->auth->UpdateOrganisation($this->organisation,$parameters);
				echo json_encode(array(
					'status' => true,
					'message' => "Company logo has been updated"
				));
			}
		}
	}
	public function accessdenied() {
		$data['title']  = 'Access denied | '.$this->title;
		$view = $this->template.'/accessdeniedhtml';
		$this->load->view('authlayouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function termandconditions(){
		$data['title']  = 'Term and conditions | '.$this->title;
		$view = $this->folder.'/cms/termandconditionshtml';
		$this->load->view('authlayouthtml',  array('data'=>$data,'views'=> $view));
	}
	

}
?>