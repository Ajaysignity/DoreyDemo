
<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Auth_model extends MY_Model {
    public function __construct(){
        parent::__construct();
    }
    public function getuserinfo($userid) {
		$return = array();
		if( !empty($userid) ) {
			$this->db->select('a.*,b.OrganisationName,b.OrganisationApiName,c.rolename');
			$this->db->from("{$this->userstable} a");
			$this->db->join("{$this->organisationtable} b","a.organisation = b.idOrganisations");
			$this->db->join("{$this->rolestable} c","a.roleid = c.roleid");
			$this->db->where('a.id', $userid);
			$this->db->where('a.isDeleted', 0);
			$query = $this->db->get();
			$this->db->last_query();
			if($query -> num_rows() >0 ){
				$return = $query->row();
			}
		}
		return $return;
	}
    public function getorganisationinfo($idOrganisations) {
		$return = array();
		$this->db->select("a.Logo,a.idOrganisations,a.OrganisationName,a.extension,a.emailroot,a.registered_on,a.planid");
		$this->db->from("{$this->organisationtable} a");
		$this->db->where('a.idOrganisations', $idOrganisations);
		$query = $this->db->get();
		$this->db->last_query();
		if($query -> num_rows() >0 ){
			$return = $query->row();
		}
		return $return;
	}
    public function getappaccessinfo($idOrganisations) {
		$return = array();
		$this->db->from("{$this->appaccesstable} ");
		$this->db->where('organisationid', $idOrganisations);
		$this->db->where('isactive', 1);
		$this->db->order_by('sortorder', 'ASC');
		$query = $this->db->get();
		$this->db->last_query();
		if($query -> num_rows() >0 ){
			$return = $query->result_array();
		}
		return $return;
	}
	public function getLastLoginInfo($userid) {
		$return = 'NA';
		if( !empty($userid) ) {
			$this->db->select('createdDtm');
			$this->db->from("{$this->userlastlogintable}");
			$this->db->where('userid', $userid);
			$this->db->order_by("autoid","DESC");
			$this->db->limit(1);
			$query = $this->db->get();
			$this->db->last_query();
			if($query -> num_rows() >0 ){
				$getdata = $query->row();
				$return = date('d M, Y H:i A',strtotime($getdata->createdDtm));
			}
		}
		return $return;
	}
	public function CountUsername( $userid, $username = NULL, $mobile = NULL ){
		$return = false;
		$this->db->select('id');
		$this->db->from("{$this->userstable}");
		$this->db->where('isDeleted', 0);
		if( !empty($mobile) ) {
			$this->db->where('mobile', $mobile);
		} else if( !empty($username) ) {
			$this->db->where('email', $username);
			$this->db->where_not_in('id', $userid);
		}
		$query = $this->db->get();
		$this->db->last_query();
		if($query -> num_rows() >0 ){
			$rows = $query->row();
			$return = true;
		}
		return $return;
	}
	public function UpdateUserInfo($userid,$parameters = array()) {
		if( !empty($parameters) ){
			$this->db->where('id', $userid);
			$this->db->update("{$this->userstable}",$parameters);
			$this->db->last_query();
		}
		return true;	
	}
	public function InsertOtp($parameters = array()) {
		$this->db->insert("{$this->otptable}",$parameters);
		$this->db->last_query();
		return $this->db->insert_id();		
	}
	public function VerifyOTP($login_mobile,$otpnumber) {
		$return = array();
		if( !empty($otpnumber) ) {
			$this->db->select('email,mobile,otp');
			$this->db->from("{$this->otptable}");
			$this->db->where("mobile",$login_mobile);
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
	public function UpdateOrganisation($idOrganisations,$parameters = array()){
		$this->db->where('idOrganisations', $idOrganisations);
		$this->db->update("{$this->organisationtable}",$parameters);
		$this->db->last_query();
		return true;
	}
}