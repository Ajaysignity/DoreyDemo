<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Assumptions_model extends MY_Model {
    public function __construct(){
        parent::__construct();
    }

	public function CheckAssumtionName($assumption_name,$organisation,$referred_date,$assetsdata = false ) {
		$return = false;
		if( !empty($assetsdata) ) { 
			$this->db->select('assets_data');
		} else {
			$this->db->select('count(assumption_name) as assets_data');
		}
		$this->db->from("{$this->assumptionstable}");
		$this->db->where('assumption_name', $assumption_name );
		$this->db->where('organisation', $organisation );
		$this->db->where("status != 'pending'");
		if( !empty($assetsdata) ) { 
			$this->db->order_by("autoid","DESC");
			$this->db->limit(1);
		} else {
			$this->db->where('referred_date', $referred_date );
		}
		$CountSQL = $this->db->get();
		$this->db->last_query();
		if($CountSQL->num_rows() >0 ){
			$info = $CountSQL->row();
			$return = $info->assets_data;			
		}
		return $return;
	}
	public function save_assumptions($parameters = array()) {
		$this->db->insert("{$this->assumptionstable}",$parameters);
		$this->db->last_query();
		return $this->db->insert_id();		
	}
	public function checkunique_modals( $organisation ) {
		$data = array();
		$this->db->distinct();
		$this->db->select('b.assumption_name, b.autoid');
		$this->db->from("{$this->userstable} a");
		$this->db->join("{$this->assumptionstable} b","a.id = b.userid");
		$this->db->where('a.organisation', $organisation );
		$this->db->where("b.status != 'pending' " );
		$CountSQL = $this->db->get();
		$this->db->last_query();
		if($CountSQL->num_rows() >0 ){
			return true;				
		}else{
			return false;
		}
	}
	public function insertunique_modals($parameters){
		$this->db->insert("{$this->assumptionstable}",$parameters);
		$this->db->last_query();
		return $this->db->insert_id();
	}
	public function SavedeleteRequest($parameters = array()) {
		$this->db->insert_batch("{$this->userrequestdeletetable}",$parameters);
		$this->db->last_query();
		return true;		
	}
	public function UpdateAssumptions($autoid, $userid, $parameters = array()) {
		$this->db->where('autoid', $autoid);
		$this->db->where('userid', $userid );
		$this->db->update("{$this->assumptionstable}",$parameters);
		$this->db->last_query();
		return true;	
	}
	public function getassumptionInfo($organisation,$autoid) {
		$return = array();
		$this->db->select('b.*');
		$this->db->from("{$this->userstable} a");
		$this->db->join("{$this->assumptionstable} b","a.id = b.userid");
		$this->db->where('a.organisation', $organisation );
		$this->db->where('b.autoid', $autoid );
		$CountSQL = $this->db->get();
		$this->db->last_query();
		if($CountSQL->num_rows() >0 ){
			$return= $CountSQL->row();		
		}
		return $return;
	}
	public function getallUsers($organisation, $PowerUser = true) {
		$return = array();
		$this->db->select('*');
		$this->db->from("{$this->userstable}");
		$this->db->where('organisation', $organisation );
		if( !empty($PowerUser) ) { 
			$this->db->where("PowerUser",1);
		}
		$CountSQL = $this->db->get();
		$this->db->last_query();
		if($CountSQL->num_rows() >0 ){
			$return= $CountSQL->result();		
		}
		return $return;
	}
	public function getunique_modals( $organisation ) {
		$data = array();
		$this->db->distinct();
		$this->db->select('b.assumption_name, b.autoid');
		$this->db->from("{$this->userstable} a");
		$this->db->join("{$this->assumptionstable} b","a.id = b.userid");
		$this->db->where('a.organisation', $organisation );
		$this->db->where("b.status != 'pending' " );
		$CountSQL = $this->db->get();
		$this->db->last_query();
		if($CountSQL->num_rows() >0 ){
			$lists= $CountSQL->result();
			foreach( $lists as $list  ):
					//$data[$list->assumption_name] = $list->assumption_name;
				$data[$list->autoid] = $list->assumption_name;
			endforeach;			
		}
		return $data;
	}
	public function getunique_modalsByOrganistion( $organisation ) {
		$data = array();
		$this->db->distinct();
		$this->db->select('b.assumption_name, b.autoid, b.referred_date');
		$this->db->from("{$this->userstable} a");
		$this->db->join("{$this->assumptionstable} b","a.id = b.userid");
		$this->db->where('a.organisation', $organisation );
		$this->db->where("b.status != 'pending' " );
		$CountSQL = $this->db->get();
		$this->db->last_query();
		if($CountSQL->num_rows() >0 ){
			$lists= $CountSQL->result();
			$data = $lists;		
		}
		return $data;
	}
	public function getReferredDates($organisation, $assumption_name ) {
		$data = array();
		$this->db->distinct();
		$this->db->select('b.referred_date,b.autoid');
		$this->db->from("{$this->userstable} a");
		$this->db->join("{$this->assumptionstable} b","a.id = b.userid","RIGHT");
		$this->db->where('a.organisation', $organisation );
		$this->db->where("b.status != 'pending' " );
		$this->db->where(" LOWER(b.assumption_name)",$assumption_name );
		$CountSQL = $this->db->get();
		$this->db->last_query();
		if($CountSQL->num_rows() >0 ){
			$lists= $CountSQL->result();
			foreach( $lists as $list  ):
				$autoid = encryptKey($list->autoid);
				$data[$autoid] = $list->referred_date;
			endforeach;			
		}
		return $data;
	}
	public function getassumptions_json( $organisation, $data = array() ) {
		$TotalRows = 0;$returnRow = array();
		$aColumns = array( 'assumption_name','referred_date','username','status','assumption_name');
		$limit = ""; $sWhere = "";$offset = '';
		if ( isset( $data['start'] ) && $data['length'] != '-1' ) {
			$limit = $data['start'];
			$offset = $data['length'];
		}
		$sOrder = ""; $sWhere = "";$OrderPattern='desc';
		if ( isset($data['search']['value']) && $data['search']['value'] != "" ) {
			$sWhere = "  (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
				$sWhere .= $aColumns[$i]." LIKE '%". $data['search']['value'] ."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ") ";
		}
		if ( isset( $data['order'] ) ) {
			for ( $i=0 ; $i<intval( $data['order'] ) ; $i++ ){
				$sOrder .= $aColumns[ intval( $data['order'][$i]['column'] ) ];
				$OrderPattern = $data['order'][$i]['dir'];
			}
		}
		$this->db->select('count(distinct b.autoid) as total')->from("{$this->userstable} a")->join("{$this->assumptionstable} b","a.id = b.userid","RIGHT")->where('a.organisation',$organisation)->where("b.status != 'pending' ");
		if( !empty($sWhere) ) {
			$this->db->where($sWhere);
		}	
		$CountRows = $this->db->get()->row();
		
		$this->db->select('b.*,a.firstname,a.surname,a.username')->from("{$this->userstable} a")->join("{$this->assumptionstable} b","a.id = b.userid","RIGHT")->where('a.organisation',$organisation)->where("b.status != 'pending' ");
		if( !empty($sWhere) ) {
			$this->db->where($sWhere);
		}
		if( !empty($sOrder) && !empty($OrderPattern) ){
			$this->db->order_by($sOrder,$OrderPattern);
		} else {
			$this->db->order_by("autoid","desc");
		}
		$lists = $this->db->limit( $offset,$limit )->get()->result();
		foreach( $lists as $list  ){
			$autoid = encryptKey($list->autoid);
			$spanClass = '';
			if( $list->status == 'live' ) {
				$spanClass = '<span class="uk-form-success"> Live</span>';
			} if( $list->status == 'archive' ) {
				$spanClass = '<span class="uk-form-warning"> Archive</span>';
			} if( $list->status == 'review' ) {
				$spanClass = '<span class="uk-form-danger"> Awaiting review</span>';
			}
			$returnRow[] = array(
				'<span uk-icon="nut"></span> '.$list->assumption_name,
				$list->referred_date,
				$list->username,
				$spanClass,
				'<p onClick="window.location.href=\''.website_url($this->controller.'/view?tokenid='.$autoid).'\'" uk-tooltip="Click to view team" style="cursor: pointer"><span class="uk-icon" uk-icon="search"></span>View</p>'	
			);	
		}
		return array(
			'TotalRows' => $CountRows->total,
			'returndata' => $returnRow,
		);
		echo json_encode( $output );
	}
	public function updateassumption($autoid, $parameters = array(), $params = array() ) {
		$CountRows = $this->db->select('COUNT(b.autoid) AS totalrows')->from("{$this->assumptionstable} a")->join("{$this->userrequestdeletetable} b","a.autoid = b.request_userid")->join("{$this->userstable} c","c.id = b.request_by")->where("a.autoid",$autoid)->where("b.request_type","assumption")->where("actiontaken","no")->where("c.Poweruser",1)->get()->row();
		$this->db->last_query();
		
		if( isset($CountRows) && !empty($CountRows) ) {
			$this->db->update("{$this->userrequestdeletetable}", $parameters, array('request_userid' => $autoid,'actiontaken' => 'no','request_type' => 'assumption'));
			$this->db->last_query();
			
			$this->db->update("{$this->assumptionstable}", $params, array('autoid'=>$autoid,'status !='=>'pending'));
			$this->db->last_query();
		}
		return true;
	}
}