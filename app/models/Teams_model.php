<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Teams_model extends MY_Model {
    public function __construct(){
        parent::__construct();
    }
	public function myteam_json( $data = array() , $mode = NULL ) {
		$TotalRows = 0;
		$aColumns = array( 'id','firstname','surname','username', 'created_at' ,'active' ,'created_at','created_at');
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
		$returnRow = array();
		$this->db->select('count(*) as total');
		$this->db->from("{$this->userstable} a");
		$this->db->join("{$this->organisationtable} b","b.idOrganisations = a.organisation");
		$this->db->join("{$this->rolestable} c","c.roleid = a.roleid AND c.panel='app'","LEFT");
		$this->db->where('a.organisation', $this->organisation );
		$this->db->where_not_in('a.id', $this->userid )->where("a.isorganisation","no");
		$this->db->where('a.isDeleted', 0 );
		if( !empty($sWhere) ){
			$this->db->where($sWhere);
		}
		$CountSQL = $this->db->get();
		$this->db->last_query();
		if($CountSQL->num_rows() >0 ){
			$info = $CountSQL->row();
			$TotalRows = $info->total;			
		}
		
		$this->db->select('a.*,c.rolename');
		$this->db->from("{$this->userstable} a");
		$this->db->join("{$this->organisationtable} b","b.idOrganisations = a.organisation");
		$this->db->join("{$this->rolestable} c","c.roleid = a.roleid AND c.panel='app'","LEFT");
		$this->db->where('a.organisation', $this->organisation );
		$this->db->where('a.isDeleted', 0 );
		$this->db->where_not_in('a.id', $this->userid )->where("a.isorganisation","no");
		if( !empty($sWhere) ){
			$this->db->where($sWhere);
		}
		if( !empty($sOrder) && !empty($OrderPattern) ){
			$this->db->order_by($sOrder,$OrderPattern);
		} else {
			$this->db->order_by("id","desc");
		}
		$this->db->limit( $offset,$limit );
		$query = $this->db->get();
		$this->db->last_query();
		if($query -> num_rows() >0 ){
			$lists = $query->result();
			foreach( $lists as $jsonRow  ):
				$encuserid = encryptKey($jsonRow->id);
				$userprofilepic = getprofile_image((isset($jsonRow->userprofilepic) ? 'profile/'.$jsonRow->userprofilepic : ''));
				if( $jsonRow->active == 1 ) {
					$ActiveStatus = '<span class="uk-form-success" uk-tooltip="Approved User">Approved</span>';
				} else if( $jsonRow->active == 2 ) {
					$ActiveStatus = '<span class="uk-form-success" uk-tooltip="Archived User">Archived</span>';
				} else {
					$ActiveStatus = '<span class="uk-form-success" uk-tooltip="Not Approved User">Pending</span>';
				} 
			
				$EditAction = '<a href="javascript:void(0)" class="uk-icon '.HasAppMenuAccess('myteams','canedit').'" uk-icon="pencil" data-autoid="'.$encuserid.'" onclick="team_view_modal(\''.$this->controller.'/editteam\',this)"></a> ';
				$DeleteAction = '<a href="javascript:void(0)" class="uk-icon-link '.HasAppMenuAccess('myteams','candelete').'" uk-icon="trash" data-autoid="'.$encuserid.'" onclick="team_view_modal(\''.$this->controller.'/trashteamuser\',this)"></a> ';
				$BellAction = '<a href="javascript:void(0)" uk-tooltip="Click to Delete User" data-autoid="'.$encuserid.'" onclick="team_view_modal(\''.$this->controller.'/confirmdeleteuser\',this)"><span class="uk-icon-b uk-form uk-form-danger" uk-icon="bell"></span></a>';
				$EditActionExpired = '<a href="#expiredsubscription" uk-toggle style="cursor: pointer" class="uk-icon" uk-icon="pencil" data-autoid="'.$encuserid.'"></a> ';
				$DeleteActionExpired = '<a href="#expiredsubscription" uk-toggle style="cursor: pointer" class="uk-icon-link" uk-icon="trash" data-autoid="'.$encuserid.'"></a> ';
				$BellActionExpired = '<a href="#expiredsubscription" uk-toggle style="cursor: pointer" uk-tooltip="Click to Delete User" data-autoid="'.$encuserid.'" ><span class="uk-icon-b uk-form uk-form-danger" uk-icon="bell"></span></a>';
				
				if( $mode == 'teamwithsolutions') {
					$totalsolution = $this->CountTeamSolution($jsonRow->id);
					$returnRow[] = array(
						'<span class="uk-badge">'.$totalsolution.'</span> '.$jsonRow->username,
						getLastLoginInfo($jsonRow->id),	
						'<div style="cursor: pointer;" onClick="window.location.href=\''.website_url('teams/teamsolutions?secretidkey='.$encuserid).'\'" uk-tooltip="Click to view solutions"><span class="uk-icon" uk-icon="search"></span> view</div>'	
							
					);
				} else {
					$returnRow[] = array(
						'<img class="uk-border-circle" width="36" height="36" style="object-fit: cover;" src="'.$userprofilepic.'">',
						ucwords($jsonRow->firstname.' '.$jsonRow->surname),
						$jsonRow->username,			
						getLastLoginInfo($jsonRow->id),	
						$ActiveStatus,	
						($jsonRow->twofa ==1 ? 'Enabled' : 'Disabled'),
						($jsonRow->rolename == '' ? 'User' : $jsonRow->rolename),
						$EditAction. $DeleteAction,	
						$BellAction	
					);
				}
			endforeach;
		}
		return array(
			'TotalRows' => $TotalRows,
			'returndata' => $returnRow,
		);

	}
	public function ShowMenuAspeRrole( $roleid, $menuname, $actionlabel = NULL ) {
		$return = array();
		$this->db->select('a.actionlabel,b.*');
		$this->db->from("{$this->permissiontable} a");
		$this->db->join("{$this->menutable} b","a.menuid = b.menuid");
		$this->db->where("a.roleid",$roleid);
		$this->db->where("b.menuname",$menuname);
		$this->db->where("a.panel","app");
		$this->db->where("b.panel","app");
		if( !empty($actionlabel) ) {
			$this->db->where("FIND_IN_SET('$actionlabel', a.actionlabel)");
		}
		$query = $this->db->get();
		$this->db->last_query();
		if($query -> num_rows() >0 ){
			$return = $query->row();
		}
		return $return;
	}
	public function getroleinfo($roleid) {
		$return = array();
		$lists = $this->db->get_where("{$this->rolestable}",array('roleid'=>$roleid,'panel'=>'app'))->row();
		if( isset($lists) && !empty($lists) ) {
			$return = $lists;
		}
		return $return;	
	}
	public function getroles_json( $data = array() ) {
		$TotalRows = 0;$returnRow = array();
		$aColumns = array( 'rolename','description');
		$limit = ""; $sWhere = "";$offset = '';
		if ( isset( $data['start'] ) && $data['length'] != '-1' ) {
			$limit = $data['start'];
			$offset = $data['length'];
		}
		$sOrder = ""; $sWhere = "";
		if ( isset($data['search']['value']) && $data['search']['value'] != "" ) {
			$sWhere = "  (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
				$sWhere .= $aColumns[$i]." LIKE '%". $data['search']['value'] ."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ") ";
		}
		$this->db->select('count(*) as total')->from("{$this->rolestable}")->where("panel",'app')->where('organisationid',$this->organisation);
		if( !empty($sWhere) ) {
			$this->db->where($sWhere);
		}	
		$CountRows = $this->db->get()->row();
		
		$this->db->select('*')->from("{$this->rolestable}")->where("panel",'app')->where('organisationid',$this->organisation);
		if( !empty($sWhere) ) {
			$this->db->where($sWhere);
		}
		$lists = $this->db->limit( $offset,$limit )->get()->result();
		$this->db->last_query();
		foreach( $lists as $list  ):
			$enroleid = encryptKey($list->roleid);
			$EditAction = ($list->rolename == OWNERROLENAME ? 'no access': '<a href="javascript:void(0)" class="uk-icon '.HasAppMenuAccess('organisation_role','canedit').'" uk-icon="pencil" data-autoid="'.$enroleid.'" onclick="common_view_modal(\''.$this->controller.'/editrole\',this)"></a> ');
			$returnRow[] = array(
				$list->rolename,
				(empty($list->description) ? 'NA' : $list->description),
				($list->isactive == 1 ? '<span class="uk-form-success">Active</span>' : '<span class="uk-form-danger">Inactive</span>'),
				defaultdate($list->createdon,true),
				($list->rolename == OWNERROLENAME ? 'no access': '<a href="javascript:void(0)" class="uk-icon '.HasAppMenuAccess('organisation_role','canedit').'" uk-icon="settings" data-autoid="'.$enroleid.'" data-modalwith="true" onclick="common_view_modal(\''.$this->controller.'/permissions\',this)"></a>'),
				$EditAction				
			);
		endforeach;
		return array(
			'TotalRows' => $CountRows->total,
			'returndata' => $returnRow,
		);
	}
	public function updaterole($roleid,$parameters = array()) {
		$countRow = $this->db->select("rolename")->from("{$this->rolestable}")->where('panel','app')->where('rolename',$parameters['rolename'])->where('organisationid',$parameters['organisationid'])->where_not_in('roleid',$roleid)->get()->row();
		$this->db->last_query();
		if( !empty($countRow->rolename)) {
			$return = false;
		} else {
			$this->db->update("{$this->rolestable}", $parameters, array('roleid' => $roleid,'organisationid' => $parameters['organisationid']));
			$this->db->last_query();
			$return = true;
		}
		return $return;	
	}
	public function saveroles($parameters = array()) {
		$countRow = $this->db->get_where("{$this->rolestable}",array('rolename'=>$parameters['rolename'],'panel'=>'app','organisationid'=>$this->organisation))->num_rows();
		if( $countRow >0 ) {
			return false;
		} else {
			$this->db->insert("{$this->rolestable}",$parameters);
			$this->db->last_query();
			return $this->db->insert_id();
		}		
	}
	public function getmenuname( $roleid ) {
		$return = array();
		$this->db->select('a.*,b.actionlabel');
		$this->db->from("{$this->menutable} a");
		$this->db->join("{$this->permissiontable} b","a.menuid=b.menuid AND b.roleid=$roleid","LEFT");
		$this->db->where("a.panel","app");
		$this->db->where("a.isactive",1);
		$this->db->order_by("a.sortorder","ASC");
		$query = $this->db->get();
		$this->db->last_query();
		if($query -> num_rows() >0 ){
			$return = $query->result();
		}
		return $return;
	}
	public function savepermissions( $roleid, $params ) {
		if( !empty($roleid) ) {
			$this->db->where("roleid",$roleid);
			$query = $this->db->delete("{$this->permissiontable}");
		}
		$this->db->insert_batch("{$this->permissiontable}", $params);
		$this->db->last_query();
		return true;
	}
	public function getroles_dropdown(){
		$data = array();
		$this->db->select('*');
		$this->db->from("{$this->rolestable}")->where("isactive","1")->where("organisationid",$this->organisation)->where("panel","app")->where_not_in("rolename",OWNERROLENAME);
		$query = $this->db->get();
		$this->db->last_query();
		if($query -> num_rows() >0 ){
			$lists = $query->result();
			foreach( $lists as $list  ):
				$data[$list->roleid] = $list->rolename;
			endforeach;
		}
		return $data;
	}
	public function InsertTeamUsers($parameters = array()) {
		$this->db->insert("{$this->userstable}",$parameters);
		$this->db->last_query();
		return $this->db->insert_id();		
	}
	public function UpdateTeamUser($userid,$parameters = array()) {
		$this->db->where('id', $userid);
		$this->db->update("{$this->userstable}",$parameters);
		$this->db->last_query();
		return true;	
	}
	public function updateorganisation($idOrganisations,$parameters = array()) {
		$this->db->where('idOrganisations', $idOrganisations);
		$this->db->update("{$this->organisationtable}",$parameters);
		$this->db->last_query();
		return true;	
	}
	public function getOrganisationUsers($PowerUser = 1){
		$lists = array();
		$this->db->select('id,firstname,surname');
		$this->db->from("{$this->userstable}")->where('PowerUser', $PowerUser )->where('isDeleted',0)->where('active',1)->where('organisation', $this->organisation )->where_not_in('id', $this->userid)->order_by("firstname","ASC");
		$Query = $this->db->get();
		$this->db->last_query();
		if($Query -> num_rows() >0 ){
			$lists = $Query->result();
		}
		return $lists;
	}
	
	public function CountUsername( $username = NULL, $email = NULL,$mobile = NULL, $editid = NULL ){
		$return = false;
		$this->db->select('id');
		$this->db->from("{$this->userstable}");
		$this->db->where('isDeleted', 0);
		if( !empty($username) ) {
			$this->db->where('username', $username);
		} else if( !empty($mobile) ) {
			$this->db->where('mobile', $mobile);
		} else {
			$this->db->where('email', $email);
		}
		if( !empty($editid) ) {
			$this->db->where_not_in('id', $editid);
		}
		$query = $this->db->get();
		$this->db->last_query();
		if($query -> num_rows() >0 ){
			$rows = $query->row();
			$return = true;
		}
		return $return;
	}
}