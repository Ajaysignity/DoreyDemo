<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Cashflow_model extends MY_Model {
    public function __construct(){
        parent::__construct();
		$this->draggedSolutionClass= 'connectedSortableSolution_drag';
		$this->droppedSolutionClass= 'droppedSolutionArea';
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
	public function check_solutionsparams($idusersolutions) {		
		$this->db->where('idusersolutions', $idusersolutions);
		$data = $this->db->get("{$this->solutionstable}");
		if($data->num_rows() >0 ){ 
			return true;	
		}else{
			return false;	
		}
	}
	public function get_solutionsparams($idusersolutions) {	
		$return = array();	
		$this->db->where('idusersolutions', $idusersolutions);
		$query = $this->db->get("{$this->solutionstable}");
		$this->db->last_query();		
		if($query -> num_rows() >0 ){
			$return = $query->row_array();
			return $return;
		}
		return $return;
	}
	public function Updated_solutionsparams($idusersolutions,$parameters = array()) {
		if( !empty($parameters) ){
			$this->db->where('idusersolutions', $idusersolutions);
			//$this->db->where('User', $this->userid);
			$this->db->update("{$this->solutionstable}",$parameters);
			$this->db->last_query();
		}
		return true;	
	}
}