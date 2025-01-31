<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Welcome extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->controller = $this->router->fetch_class();
		$this->load->model('Login_model','login');
		$this->load->helper('captcha');
		$this->title = 'Financial Projector by Dorey Financial Modelling';
	}

	public function index() {
		$data['title']  = $this->title;
		setcookie('selectedcurrencyvalue', '', time() - 3600, '/');
		unset($_COOKIE['selectedcurrencyvalue']);
		$config = array(
			'word' => substr(number_format(time() * rand(),0,'',''),0,4),
			'img_path'      => 'assets/captchaimages/',
			'img_url'       => assets_url('captchaimages'),
			'img_width'     => '180',
			'img_height'    => 40,
			'word_length'   => 4,
			'font_size'     => 8,
			'colors'        => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(51, 51, 51),
                'grid' => ''
        	)
		);
		$captcha = create_captcha($config);
		$this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode', $captcha['word']);
       
        // Pass captcha image to view
        $data['captchaImg'] = $captcha['image'];
		$view = 'homehtml';
		$this->load->view('layouthtml',  array('data'=>$data,'views'=> $view));
	}

	public function forgotpassword() {
		$data['title']  = $this->title;	
		$view = 'forgotpasswordhtml';
		$this->load->view('layouthtml',  array('data'=>$data,'views'=> $view));
	}
	
	public function forgotpasswordForm(){
		$this->form_validation->set_rules('email', 'Email', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array(
				'status' => false,
				'message' =>validation_errors()
			));
		}else{
			$username = $this->input->post("email");
			$getdata = $this->login->VerifyUsername($username);			
			if( isset($getdata->username) && $getdata->username == $username) {
				$userid = $getdata->id;
				$expFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
				$verification_expirelink = date("Y-m-d H:i:s",$expFormat);
				$verification_code = md5($getdata->username).rand(10,9999);
				$parameters = array(
					'verification_code'=>$verification_code,
					'verification_expirelink'=>$verification_expirelink
				);
				$this->login->UpdateUser($userid,$parameters);
				
			
				$resetLink = website_url("generate-password?key=".encryptKey($userid)."&token=".$verification_code);
				$message = "
				<p>Dear ".ucwords($getdata->firstname.' '.$getdata->surname).", </p>
				<p>For reset password, click <a href='".$resetLink."'>here</a> into your browser (Internet Explorer is not supported).</p>"; 				
				$subject = "Reset Password";
				sendemail($getdata->email, $subject, $message);
				echo json_encode(array(
					'status' => true,
					'successpopup' => true,
					'message' => '<h3 style="text-align: left;font-size: 20px;margin: 20px 0px 0px 0px;">Welcome to Financial Projector</h3><p>We’ve sent you an email link to reset your password</p>  '
				));
 			} else {
				echo json_encode(array(
					'status' => false,
					'message' => 'Email/Username you entered is incorrect'
				));
			}
		}
	}
	public function resetpassword() {
		$data['title']  = $this->title;	
		$this->load->view('resetpassword',  array('data'=>$data));
	}
	public function resetpasswordForm(){
		$this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
		$this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array(
				'status' => false,
				'message' =>validation_errors()
			));
		}else{
			$password = $this->input->post("password");
			$confirmpassword = $this->input->post("confirmpassword");
			$userid =  decryptKey($this->input->post("userid"));
			if($password == $confirmpassword){
				$encytpassword = password_hash($confirmpassword, PASSWORD_DEFAULT);
				$parameters = array('password' =>$encytpassword);
				$this->login->UpdateUser($userid, $parameters);
				echo json_encode(array(
					'status' => true,
					'successpopup' => true,
					'message' => "Password has been updated successfully"
				));
			}else{
				echo json_encode(array(
					'status' => false,
					'message' => "Password and confirm password does not match"
				));
			}
		}
	}
	public function authorganisation(){
		$this->form_validation->set_rules('firstname', 'First name', 'required|xss_clean');
		$this->form_validation->set_rules('surname', 'Surname', 'required|xss_clean');
		//$this->form_validation->set_rules('username', 'Username', 'required|xss_clean');
		//$this->form_validation->set_rules('username', 'Username', 'xss_clean|required|trim|min_length[6]|max_length[25]');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|xss_clean');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|xss_clean|max_length[15]');
		$this->form_validation->set_rules('company', 'Company name', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array(
				'status' => false,
				'otpscreen' => false,
				'message' =>validation_errors()
			));
		} else {
			$checkusername = $this->login->CountUsername($this->input->post('email'));
			$checkuseremail = $this->login->CountUsername(false,$this->input->post('email'));
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
			} else {
				$username = $this->input->post('email');
				$parameters =array(
					'OrganisationName'=> $this->input->post('company'),
					'emailroot'=> $this->input->post('email'),
					'registered_on'=> date('Y-m-d H:i:s'),
					'planid'=> TRIALPLAN
				);
				$OrganisationID = $this->login->InsertOrgnisation($parameters);
				if ( !empty($OrganisationID) ) {
					$verification_code = md5($username).rand(10,9999);
					$expFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
					$verification_expirelink = date("Y-m-d H:i:s",$expFormat);
					
					$UsersParams =array(
						'username'=> $username,
						'email'=> $this->input->post('email'),
						'firstname'=> $this->input->post('firstname'),
						'surname'=> $this->input->post('surname'),
						'mobile'=> $this->input->post('mobile'),
						'organisation'=> $OrganisationID,
						'verification_expirelink'=> $verification_expirelink,
						'active'=> 0,
						'PowerUser'=> 1,
						'created_at'=> date('Y-m-d H:i:s'),
						'isorganisation'=> 'yes'
					);
					$LastInsertedID = $this->login->InsertUsers($UsersParams);

					$this->SendVerificationPasswordGenerate($LastInsertedID,$this->input->post('company'));
				}
			}
		}
	}
	public function SendVerificationPasswordGenerate( $userid,$OrganisationName ) {
		$UserInfo = $this->login->getuserinfo($userid);
		$verification_code = md5($UserInfo->username).rand(10,9999);
		$expFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
		$verification_expirelink = date("Y-m-d H:i:s",$expFormat);
		$parameters = array(
			'verification_code'=>$verification_code,
			'verification_expirelink'=>$verification_expirelink
		);
		$this->login->UpdateUser($userid,$parameters);
		if ( !empty($userid) ) {
			$EmailLink = website_url("generate-password?key=".encryptKey($userid)."&token=".$verification_code);
			$message = "
			<p>Dear ".ucwords($UserInfo->firstname.' '.$UserInfo->surname).", </p>
			<p>Welcome to Financial Projector. </p>
			<p>Your organisation account name is $OrganisationName</p>
			<p>Your username is: ".$UserInfo->username."</p>
			<p>To complete your set up, click <a href='".$EmailLink."'>here</a> or copy and paste ".$EmailLink." into your browser (Internet Explorer is not supported).</p>"; 
			
			$subject = "Finish setting up your $OrganisationName account";
			sendemail($UserInfo->email, $subject, $message);
			echo json_encode(array(
				'status' => true,
				'successpopup' => true,
				'message' => '<h3 style="text-align: left;font-size: 20px;margin: 20px 0px 0px 0px;">Welcome to Financial Projector</h3><p>We’ve sent you an email link to complete your account set up</p>'
			));
		} else {
			echo json_encode(array(
				'status' => false,
				'message' => 'Issue occure, please refresh the page try again '
			));
		}			
	}
	public function generate_password(){
		$data['title']  = 'Generate Password | '.$this->title;
		$dataInfo = array();
		$data['info'] = array();
		$secretkey = $this->input->get("key");
		$token = $this->input->get("token");
		$access = decryptKey($this->input->get("access"));
		if ( empty($secretkey) || empty($token) ) {
			die('Link has been expired or invalid. Please contact with admin');exit();
		} else {
			if( $access == 'dfmsubadmins') {
				$dataInfo = $this->login->verifyDFMGeneratedHashLink($secretkey,$token);
			} else {
				$dataInfo = $this->login->verifyGeneratedHashLink($secretkey,$token);
			}
		}
		if( !empty($dataInfo) ) {
			$data['secretkey'] = $secretkey;
			$data['token'] = $token;
			$data['access'] = $this->input->get("access");
			$data['info'] = $dataInfo;
		} else {
			die('Link has been expired or invalid. Please contact with admin');exit();
		}
		$view = 'generatepasswordhtml';
		$this->load->view('layouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function savegeneratepassword() {
		$this->form_validation->set_rules('confirm_password', 'Confirm password', 'required|xss_clean');
		$this->form_validation->set_rules('new_password', 'New password', 'required|xss_clean');
		$this->form_validation->set_rules('secrettoken', 'Token', 'required|xss_clean');
		$this->form_validation->set_rules('secretkey', 'Key', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array(
				'status' => false,
				'otpscreen' => false,
				'message' =>validation_errors()
			));
		} else {
			$confirm_password = $this->input->post("confirm_password");
			$new_password = $this->input->post("new_password");
			$hashKey = $this->input->post("secrettoken");
			$username = $this->input->post("secretkey");
			
			$PasswordError = CheckPasswordStrength($confirm_password);
			if(!empty($PasswordError)){ 
				echo json_encode(array( 'status' => false,'message' => 'Password validation failure:'.$PasswordError ));
			} else if( $new_password != $confirm_password ){
				echo json_encode(array( 'status' => false,'message' => 'Password did not match' ));
			} else {
				$userid = decryptKey($username);
				$response = $this->login->CheckHashKey($userid, $hashKey,$confirm_password);
				if(! empty($response) ) {
					$password = password_hash($confirm_password, PASSWORD_DEFAULT);
					$parameters = array(
						'verification_code'=>NULL,
						'password'=>$password,
						'gerate_password'=>1,
						'active'=>1
					);
					if( $response->PowerUser == 1 && $response->isorganisation == 'yes') {
						$RoleParameters = array(
							'rolename'=>OWNERROLENAME,
							'description'=>'All permissions',
							'panel'=>'app',
							'organisationid'=>$response->idOrganisations
						);
						$roleid = $this->login->SetDefaultRole($RoleParameters);
						$parameters['roleid'] = $roleid;
						$parameters['PowerUser'] = 1;
					}
					
					$this->login->UpdateUser($userid,$parameters);
					echo json_encode(array(
						'status' => true,
						'successpopup' => true,
						'http_redirect' => website_url(),
						'message' => 'Your password has been set and you can now log in to Financial Projector'
					));
				} else {
					echo json_encode(array(
						'status' => false,
						'message' => 'There is an issue with link either expired/invalid'
					));
				}
			}
		}
	}
	public function saveDFMgeneratepassword() {
		$this->form_validation->set_rules('confirm_password', 'Confirm password', 'required|xss_clean');
		$this->form_validation->set_rules('new_password', 'New password', 'required|xss_clean');
		$this->form_validation->set_rules('secrettoken', 'Token', 'required|xss_clean');
		$this->form_validation->set_rules('secretkey', 'Key', 'required|xss_clean');
		$this->form_validation->set_rules('accesscode', 'accesscode', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array(
				'status' => false,
				'otpscreen' => false,
				'message' =>validation_errors()
			));
		} else {
			$accesscode = decryptKey($this->input->post("accesscode"));
			if( $accesscode == 'dfmsubadmins') {
				$confirm_password = $this->input->post("confirm_password");
				$new_password = $this->input->post("new_password");
				$hashKey = $this->input->post("secrettoken");
				$username = $this->input->post("secretkey");

				$PasswordError = CheckPasswordStrength($confirm_password);
				if(!empty($PasswordError)){ 
					echo json_encode(array( 'status' => false,'message' => 'Password validation failure:'.$PasswordError ));
				} else if( $new_password != $confirm_password ){
					echo json_encode(array( 'status' => false,'message' => 'Password did not match' ));
				} else {
					$adminid = decryptKey($username);
					$response = $this->login->CheckDFMHashKey($adminid, $hashKey,$confirm_password);
					if(! empty($response) ) {
						$password = password_hash($confirm_password, PASSWORD_DEFAULT);
						$parameters = array(
							'verification_code'=>NULL,
							'password'=>$password,
							'gerate_password'=>1,
							'PowerUser'=>1,
							'active'=>1
						);
						$this->login->UpdateDFMUser($adminid,$parameters);
						echo json_encode(array(
							'status' => true,
							'successpopup' => true,
							'http_redirect' => website_url(),
							'message' => 'Your password has been set and you can now log in to Financial Projector'
						));
					} else {
						echo json_encode(array(
							'status' => false,
							'message' => 'There is an issue with link either expired/invalid'
						));
					}
				}
			} else {
				echo json_encode(array(
					'status' => false,
					'message' => 'There is an issue with link either expired/invalid'
				));
			}
		}
	}
	// $inputCaptcha = $this->input->post('captchaimage');
    //         $sessCaptcha = $this->session->userdata('captchaCode');
    //         if($inputCaptcha === $sessCaptcha){}
	public function authlogin () {
		$this->form_validation->set_rules('username', 'Username', 'required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
		$this->form_validation->set_rules('captchaimage', 'Captcha code', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array(
				'status' => false,
				'otpscreen' => false,
				'message' =>validation_errors()
			));
		} else {
			$sessCaptcha = $this->session->userdata('captchaCode');
			$inputCaptcha = $this->input->post("captchaimage");
			if( $inputCaptcha === $sessCaptcha ) {
				$username = $this->input->post("username");
				$password = $this->input->post("password");
				$getdata = $this->login->VerifyUsername($username);
				if( isset($getdata->password) && password_verify($password, $getdata->password) ) {
					if( $getdata->twofa == 0 ) {
						$sessionData = array( 'userid' => $getdata->id, 'userInfo' => $getdata->username,'organisation' => $getdata->OrganisationName );
						$logsparams = array(
							'userid'=>$getdata->id,
							'sessionData'=>json_encode($sessionData),
							'machineIp'=>$_SERVER['REMOTE_ADDR'],
							'agentString'=> $_SERVER['HTTP_USER_AGENT'],
							'createdDtm'=>date('Y-m-d H:i:s')
						);
						$UserLastLogin = $this->login->InsertLastLogin($logsparams);
						$sessionparams = array(
							'userid'=> $getdata->id,
							'username'=> $getdata->username,
							'UserLastLogin'=> $UserLastLogin,
							'organisation'=> $getdata->organisation,
							'OrganisationName'=> $getdata->OrganisationName,
							'isshowdashboard'=> $getdata->isshowdashboard,
							'OrganisationApiName'=> $getdata->OrganisationApiName,
							'UserLoggedin'=> true
						);
						$this->session->set_userdata($sessionparams);
		
						echo json_encode(array(
							'status' => true,
							'successpopup' => false,
							'http_redirect' => website_url('apps'),
							'message' => 'login successfully'
						));
					} else {
						$otp_info = generate_otop();
						$parameters = array(
							'email'=>$getdata->email,
							'mobile'=>$getdata->mobile,
							'otp'=>$otp_info['otp_number'],
							'used'=>0,
							'expirydate'=>$otp_info['expiredatetime'],
						);
						$this->login->InsertOtp($parameters);
						$OTPBody = "<p>Please do not share this code with anyone for security reasons. Your OTP is <strong><font color='#df4726'> ".$otp_info['otp_number']."</font></strong><p>";
						$sessionparams = array(
							'login_email'=> $getdata->email,
							'login_username'=> $getdata->username,
							'login_mobile'=> $getdata->mobile,
							'login_organisation'=> $getdata->organisation
						);
						$this->session->set_userdata($sessionparams);
						$viewOrganisation_mobile = substr($getdata->mobile, -3);
						sendemail($getdata->email,'Your OTP for financial projector', $OTPBody);
						echo json_encode(array(
							'status' => true,
							'successpopup' => true,
							'otpscreen' => $viewOrganisation_mobile,
							'message' => "We've sent a verification code to mobile number ending ".$viewOrganisation_mobile.' is : '.$otp_info['otp_number']
						));
					}
				} else {
					echo json_encode(array(
						'status' => false,
						'message' => 'Username/password you entered is incorrect'
					));
				}
			} else {
				echo json_encode(array(
					'status' => false,
					'message' => 'Captcha code does not match, please try again'
				));
			}
		}
	}
	public function verifyloginotp() {
		$this->form_validation->set_rules('otpnumber', 'OTP', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array(
				'status' => false,
				'message' =>validation_errors()
			));
		} else {
			$otpnumber = $this->input->post("otpnumber");
			$login_email = $this->session->userdata ( 'login_email' );
			$login_username = $this->session->userdata ( 'login_username' );
			$login_mobile = $this->session->userdata ( 'login_mobile' );
			
			$getdata = $this->login->VerifyOTP($login_email,$login_mobile,$otpnumber);
			
			if( !empty($getdata) ) {
				$parameters = array(
					'login_email'=>$getdata->email,
					'login_mobile'=>$getdata->mobile,
					'otpnumber'=>$otpnumber,
					'used'=>1
				);
				
				$this->login->UpdateOtp($parameters);
				
				$userInfo = $this->login->VerifyUsername($login_username);
				$sessionData = array( 'userid' => $userInfo->id, 'userInfo' => $userInfo->username,'organisation' => $userInfo->OrganisationName );
				$logsparams = array(
					'userid'=>$userInfo->id,
					'sessionData'=>json_encode($sessionData),
					'machineIp'=>$_SERVER['REMOTE_ADDR'],
					'agentString'=> $_SERVER['HTTP_USER_AGENT'],
					'createdDtm'=>date('Y-m-d H:i:s')
				);
				$UserLastLogin = $this->login->InsertLastLogin($logsparams);
				$sessionparams = array(
					'userid'=> $userInfo->id,
					'username'=> $userInfo->username,
					'UserLastLogin'=> $UserLastLogin,
					'organisation'=> $userInfo->organisation,
					'OrganisationName'=> $userInfo->OrganisationName,
					'isshowdashboard'=> $userInfo->isshowdashboard,
					'OrganisationApiName'=> $userInfo->OrganisationApiName,
					'UserLoggedin'=> true
				);
				$this->session->set_userdata($sessionparams);

				echo json_encode(array(
					'status' => true,
					'successpopup' => false,
					'http_redirect' => website_url('apps'),
					'message' => 'login successfully'
				));
			} else {
				echo json_encode(array(
					'status' => false,
					'message' => 'Invalid/Expired OTP'
				));
			}
		}
	}
	public function resendotp() {
		$login_email = $this->session->userdata ( 'login_email' );
		$login_username = $this->session->userdata ( 'login_username' );
		$login_mobile = $this->session->userdata ( 'login_mobile' );
		if( isset($login_email) && isset($login_mobile) ) {
			$getdata = $this->login->VerifyUsername($login_username);
			$otp_info = generate_otop();
			$parameters = array(
				'email'=>$getdata->email,
				'mobile'=>$getdata->mobile,
				'otp'=>$otp_info['otp_number'],
				'used'=>0,
				'expirydate'=>$otp_info['expiredatetime'],
			);
			$this->login->InsertOtp($parameters);
			$OTPBody = "<p>Please do not share this code with anyone for security reasons. Your OTP is <strong><font color='#df4726'> ".$otp_info['otp_number']."</font></strong><p>";
			$viewOrganisation_mobile = substr($getdata->mobile, -3);
			sendemail($getdata->email,'Your OTP for financial projector', $OTPBody);
			echo json_encode(array(
				'status' => true,
				'successpopup' => true,
				'otpscreen' => $viewOrganisation_mobile,
				'message' => "We've sent a verification code to mobile number ending ".$viewOrganisation_mobile
			));
			
		} else {
			echo json_encode(array(
				'status' => false,
				'message' => 'There is some issue with username/password you entered, please try again'
			));
		}
	}
	public function logout() {
		$this->output->delete_cache();
		$session_parameters = array(
			'userid' => '',
			'username' => '',
			'organisation' => '',
			'UserLoggedin' => false
		);
		$this->session->unset_userdata($session_parameters);
		$this->session->sess_destroy();
		redirect(base_url('/'),'refresh');
	}
	public function saveopencontactformdata() {
		$this->form_validation->set_rules('contactname', 'name', 'required|xss_clean|max_length[20]');
		$this->form_validation->set_rules('contactemail', 'email', 'required|valid_email|xss_clean');
		$this->form_validation->set_rules('contactsubject', 'subject', 'required|xss_clean|max_length[250]');
		$this->form_validation->set_rules('contactmessage', 'message', 'required|xss_clean|min_length[10]|max_length[2500]');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array(
				'status' => false,
				'otpscreen' => false,
				'message' =>validation_errors()
			));
		} else { 
			$contactname = $this->input->post('contactname');
			$contactemail = $this->input->post('contactemail');
			$contactsubject = $this->input->post('contactsubject');
			$contactmessage = $this->input->post('contactmessage');
			$parameters = array(
				'contactname' => $this->input->post('contactname'),
				'contactemail' => $this->input->post('contactemail'),
				'contactsubject' => $this->input->post('contactsubject'),
				'contactmessage' => $this->input->post('contactmessage'),
				'createdon' => date('Y-m-d H:i:s'),
				'machineip' => $_SERVER["REMOTE_ADDR"]
			);
			$this->login->saveopencontactformdata($parameters);
			$usermessage = "
			<p>Dear ".ucwords($contactname).", </p>
			<p>Thank you for getting in touch. A (human) member of the Financial Projector support team will come back to you as soon as possible. During normal business hours we usually try to respond within a few hours. Evenings and weekends may take us a little bit longer.</p>
			<p>Your support request:<br/>".$contactmessage."</p>";
			sendemail($contactemail,$contactsubject.' | '.SITE_NAME,$usermessage);
			
			$adminmessage = "
			<p>Dear admin, </p>
			<p>Following user trying to connect with ".SITE_NAME.", below are the informations:<p> 
			<p><b>Name</b> : ".ucwords($contactname)."</p>
			<p><b>Email address</b>: ".$contactemail."</p>
			<p><b>Subject</b> : ".$contactsubject."</p>
			<p><b>Message</b> <br/> ".$contactmessage."</p>
			<p><b>IP address</b> <br/> ".$_SERVER["REMOTE_ADDR"]."</p>";
			$subject = 'Contact us '.SITE_NAME.' | '.substr(strip_tags($contactsubject),0,50).'..';
			sendemail(SUPPORT_EMAIL,$subject,$adminmessage);
			echo json_encode(array(
				'status' => true,
				'successpopup' => true,
				'message' => "Your feedback has been sent to the ".SITE_NAME." team. We'll be in touch soon."
			));
		}
	}
	
	public function faqs(){
		$data['title']  = 'Faqs | '.$this->title;
		$data['lists'] = $this->dashboard->getallfaqs();
		$view = 'openfaqshtml';
		$this->load->view('layouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function clearwebcache() {
		$this->output->delete_cache();
	}
	public function refreshCaptchaCode(){
		$files = glob('./assets/captchaimages/*');
		$expiration = time() - 60;
		foreach ($files as $file) {
			if (is_file($file) && filemtime($file) < $expiration) {
				unlink($file);
			}
		}
        $config = array(
			'word' => substr(number_format(time() * rand(),0,'',''),0,4),
			'img_path'      => 'assets/captchaimages/',
			'img_url'       => assets_url('captchaimages'),
			'img_width'     => '180',
			'img_height'    => 40,
			'word_length'   => 4,
			'font_size'     => 8,
			'colors'        => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(51, 51, 51),
                'grid' => ''
        	)
		);
        $captcha = create_captcha($config);
        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode',$captcha['word']);
        echo $captcha['image'];
    }
}