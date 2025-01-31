<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Login_model extends MY_Model {
    public function __construct(){
        parent::__construct();
    }
	public function getuserinfo($userid) {
		$return = array();
		if( !empty($userid) ) {
			$this->db->select('*');
			$this->db->from("{$this->userstable}");
			$this->db->where('id', $userid);
			$this->db->where('isDeleted', 0);
			//$this->db->where('b.iscancelled', 0);
			$query = $this->db->get();
			$this->db->last_query();
			if($query -> num_rows() >0 ){
				$return = $query->row();
			}
		}
		return $return;
	}
	public function CountUsername( $username = NULL, $email = NULL ){
		$return = false;
		$this->db->select('id');
		$this->db->from("{$this->userstable}");
		$this->db->where('isDeleted', 0);
		//$this->db->where('b.iscancelled', 0);
		if( !empty($username) ) {
			$this->db->where('username', $username);
		} else {
			$this->db->where('email', $email);
		}
		$query = $this->db->get();
		$this->db->last_query();
		if($query -> num_rows() >0 ){
			$rows = $query->row();
			$return = true;
		}
		return $return;
	}
	public function InsertOrgnisation($parameters = array()) {
		$this->db->insert("{$this->organisationtable}",$parameters);
		$this->db->last_query();
		return $this->db->insert_id();		
	}
	public function InsertUsers($parameters = array()) {
		$this->db->insert("{$this->userstable}",$parameters);
		$this->db->last_query();
		return $this->db->insert_id();		
	}
	public function UpdateUser($userid,$parameters = array()) {
		$this->db->where('id', $userid);
		$this->db->update("{$this->userstable}",$parameters);
		$this->db->last_query();
		return true;	
	}
	public function UpdateDFMUser($adminid,$parameters = array()) {
		$this->db->where('adminid', $adminid);
		$this->db->update("{$this->adminstable}",$parameters);
		$this->db->last_query();
		return true;	
	}
	public function UserMaxLastLogin($userid){
		$return = false;
		$this->db->select('max(autoid) as lastlogin');
		$this->db->from("{$this->userlastlogintable}");
		$this->db->where('userid', $userid);
		$query = $this->db->get();
		$this->db->last_query();
		if($query -> num_rows() >0 ){
			$rows = $query->row();
			$return = $rows->lastlogin;
		}
		return $return;
	}
	public function InsertLastLogin($parameters = array()) {
		$this->db->insert("{$this->userlastlogintable}",$parameters);
		$this->db->last_query();
		return $this->db->insert_id();		
	}
	public function InsertOtp($parameters = array()) {
		$this->db->insert("{$this->otptable}",$parameters);
		$this->db->last_query();
		return $this->db->insert_id();		
	}
	public function UpdateOtp($data = array()) {
		$this->db->where("(email='".$data['login_email']."' OR mobile='".$data['login_mobile']."')");
		$this->db->where('otp', $data['otpnumber']);
		$this->db->where('used', 0);
		$this->db->update("{$this->otptable}",array('used'=>$data['used']));
		$this->db->last_query();
		return true;	
	}
	public function verifyGeneratedHashLink( $userid, $verification_code ) {
		$return = false;
		$this->db->select('username,email,verification_expirelink');
		$this->db->from("{$this->userstable}");
		$this->db->where('id', decryptKey($userid) );
		$this->db->where('verification_code', $verification_code);
		$query = $this->db->get();
		$this->db->last_query();
		if($query -> num_rows() >0 ){
			$getdata = $query->row();
			if( $getdata->verification_expirelink >= date("Y-m-d H:i:s") ) {
				$return = $getdata;
			}	
		}
		return $return;
	}
	public function CheckHashKey($userid, $verification_code, $confirm_password) {
		$getdata = array();
		$this->db->select('a.firstname,a.isorganisation,a.surname,a.email,a.PowerUser, a.verification_expirelink,b.idOrganisations');
		$this->db->from("{$this->userstable} a");
		$this->db->join("{$this->organisationtable} b","a.organisation = b.idOrganisations");
		$this->db->where('id', $userid );
		$this->db->where('verification_code', $verification_code);
		$query = $this->db->get();
		$this->db->last_query();
		if($query -> num_rows() >0 ){
			$info = $query->row();
			if( $info->verification_expirelink >= date("Y-m-d H:i:s") ) {
				$getdata = $info;
			}			
		}
		return $getdata;	
	}
	public function VerifyUsername($username) {
		$return = array();
		if( !empty($username) ) {
			$this->db->select('a.id,a.username,a.twofa,b.isshowdashboard,b.OrganisationApiName,b.OrganisationName,a.organisation, a.password,a.email,a.mobile');
			$this->db->from("{$this->userstable} a");
			$this->db->join("{$this->organisationtable} b","a.organisation = b.idOrganisations");
			$this->db->where('a.username', $username);
			$this->db->where('a.active', 1);
			$this->db->where('a.isDeleted', 0);
			$this->db->where('b.iscancelled', 0);
			$query = $this->db->get();
			$this->db->last_query();
			if($query -> num_rows() >0 ){
				$return = $query->row();
			}
		}
		return $return;
	}	
	public function VerifyOTP($login_email,$login_mobile,$otpnumber) {
		$return = array();
		if( !empty($otpnumber) ) {
			$this->db->select('email,mobile,otp');
			$this->db->from("{$this->otptable}");
			$this->db->where(" (email='".$login_email."' OR mobile='".$login_mobile."') ");
			$this->db->where('otp', $otpnumber);
			$this->db->where('used', 0);
			$query = $this->db->get();
			$this->db->last_query();
			if($query -> num_rows() >0 ){
				$return = $query->row();
			}
		}
		return $return;
	}
	
	/********DFM*********/
	public function verifyDFMGeneratedHashLink( $adminid, $verification_code ) {
		$return = false;
		$this->db->select('username,email,verification_expirelink');
		$this->db->from("{$this->adminstable}");
		$this->db->where('adminid', decryptKey($adminid) );
		$this->db->where('verification_code', $verification_code);
		$query = $this->db->get();
		$this->db->last_query();
		if($query -> num_rows() >0 ){
			$getdata = $query->row();
			if( $getdata->verification_expirelink >= date("Y-m-d H:i:s") ) {
				$return = $getdata;
			}	
		}
		return $return;
	}
	public function CheckDFMHashKey($adminid, $verification_code, $confirm_password) {
		$getdata = array();
		$this->db->select('firstname,surname,email,verification_expirelink');
		$this->db->from("{$this->adminstable} a");
		$this->db->where('adminid', $adminid );
		$this->db->where('verification_code', $verification_code);
		$query = $this->db->get();
		$this->db->last_query();
		if($query -> num_rows() >0 ){
			$info = $query->row();
			if( $info->verification_expirelink >= date("Y-m-d H:i:s") ) {
				$getdata = $info;
			}			
		}
		return $getdata;	
	}
	public function saveopencontactformdata($parameters = array()) {
		$this->db->insert("{$this->contacttable}",$parameters);
		$this->db->last_query();
		return $this->db->insert_id();		
	}
	public function SetDefaultRole($roleparams) {
		$this->db->insert("{$this->rolestable}",$roleparams);
		$this->db->last_query();
		$roleid = $this->db->insert_id();
		
		$this->db->select('menuid');
		$this->db->from("{$this->menutable}");
		$this->db->where('panel', 'app' );
		$this->db->where('isactive', 1 );
		$query = $this->db->get();
		$this->db->last_query();
		if($query -> num_rows() >0 ){
			$lists = $query->result();
			foreach( $lists as $list  ):
				$params[] =array(
					'menuid' =>$list->menuid,
					'roleid' =>$roleid,
					'actionlabel' =>'canview,canadd,canedit,candelete',
					'panel' =>'app',
				); 
			endforeach;
			$this->db->insert_batch("{$this->permissiontable}",$params);
			$this->db->last_query();			
		}
		return $roleid;
	}
}