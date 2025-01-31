<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Assetallocator_model extends MY_Model {
    public function __construct(){
        parent::__construct();	
    }
	public function get_Single_AllocatorDataInfo() {	
		$return = array();	
		$this->db->where('organisation', $this->organisation);
		$query = $this->db->get("{$this->allocatorinfotable}");
		$this->db->last_query();		
		if($query -> num_rows() >0 ){
			$return = $query->row();
		}
		return $return;
	}
	public function Insert_AllocatorDataInfo($parameters = array()) {
		if( !empty($parameters) ){
			$this->db->insert("{$this->allocatorinfotable}",$parameters);
			$this->db->last_query();
		}
		return $this->db->insert_id();
	}
	public function Update_AllocatorDataInfo($parameters = array(), $organisation ) {
		if( !empty($parameters) && !empty($organisation) ){
            $this->db->where('organisation', $organisation);
			$this->db->update("{$this->allocatorinfotable}",$parameters);
			$this->db->last_query();
		}
		return true;
	}
	public function Insert_allocatorparams($parameters = array()) {
		if( !empty($parameters) ){
			$this->db->insert("{$this->allocatortable}",$parameters);
			$this->db->last_query();
		}
		return $this->db->insert_id();
	}
    public function Updated_allocatorparams($parameters = array(), $iduserallocator = NULL) {
		if( !empty($parameters) ){
			$this->db->where('iduserallocator', $iduserallocator);
            $this->db->where('User', $this->userid);
			$this->db->update("{$this->allocatortable}",$parameters);
			$this->db->last_query();
		}
		return $iduserallocator;	
	}
	public function get_SingleallocatorsData($iduserallocator) {	
		$return = array();	
		$this->db->where('iduserallocator', $iduserallocator);
		$this->db->where('isdeleted', 0);
		$this->db->where('User', $this->userid);
		$query = $this->db->get("{$this->allocatortable}");
		$this->db->last_query();		
		if($query -> num_rows() >0 ){
			$return = $query->row();
			return $return;
		}
		return $return;
	}
	public function get_allocatorsData() {	
		$return = array();	
		$this->db->where('User', $this->userid);
		$this->db->where('isdeleted', 0);
		$query = $this->db->get("{$this->allocatortable}");
		$this->db->last_query();		
		if($query -> num_rows() >0 ){
			$return = $query->result();
			return $return;
		}
		return $return;
	}
	public function duplicateassetallocator($ClientName,$iduserallocator) {	
		$SQL = "INSERT INTO {$this->allocatortable} (User,BasicInfo,ClientName,apidata) SELECT User,BasicInfo,'".$ClientName."',apidata FROM `{$this->allocatortable}` WHERE iduserallocator = $iduserallocator AND User = ".$this->userid;
		$this->db->query($SQL);
		return true;
	}
}