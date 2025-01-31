
<?php defined('BASEPATH') OR exit('No direct script access allowed');
class concerto_model extends MY_Model {
    public function __construct(){
        parent::__construct();
    }
    public function SaveJtcToolnfo($parameters = array()) {
		$this->db->insert("{$this->jtctoolstable}",$parameters);
		$this->db->last_query();
		return $this->db->insert_id();		
	}
    public function UpdateJtcToolnfo($parameters = array()) {
		if( !empty($parameters) ){
			$this->db->where('userid', $this->userid);
			$this->db->update("{$this->jtctoolstable}",$parameters);
			$this->db->last_query();
		}
		return true;	
	}
	public function getjtcinfo() {
		$return = array();
        $this->db->select('*');
        $this->db->from("{$this->jtctoolstable}");
        $this->db->where('userid', $this->userid);
        $query = $this->db->get();
        $this->db->last_query();
        if($query -> num_rows() >0 ){
            $return = $query->row();
        }
		return $return;
	}

	public function removejtcinfo( $userid) {
		if( !empty($userid) && is_numeric($userid) ){
        $this->db->where('userid', (int)$userid);
        $this->db->delete("{$this->jtctoolstable}");
		}
		return true;
	}

	public function getdoretsteps( $type = NULL, $ismobile = NULL ) {
		$return = array();
		$this->db->select('*');
		$this->db->from("{$this->jtctoolstepstable}");
		$this->db->where('isactive', 1);
		if( !empty($type) ) {
			$this->db->where('type', $type);
		}
		if( !empty($ismobile) ) {
			$this->db->where('ismobile', 0);
		}
		$this->db->order_by("step","ASC");
		$query = $this->db->get();
		$this->db->last_query();
		if($query -> num_rows() >0 ){
			$return = $query->result();
		}
		return $return;
	}

	public function getSingledoretstep( $type ) {
		$return = array();
		$this->db->select('name,urlname,type,step');
		$this->db->from("{$this->jtctoolstepstable}");
		$this->db->where('isactive', 1);
		$this->db->where('type', $type);
		$this->db->order_by("step","ASC");
		$query = $this->db->get();
		$this->db->last_query();
		if($query -> num_rows() >0 ){
			$return = $query->row();
		}
		return $return;
	}
	
	public function SaveJtcToolnfoHistory($parameters = array()) {
		$this->db->insert("{$this->jtctoolsHistorytable}",$parameters);
		$this->db->last_query();
		return $this->db->insert_id();		
	}
    public function UpdateJtcToolnfoHistory($parameters = array()) {
		if( !empty($parameters) ){
			$this->db->where('userid', $this->userid);
			$this->db->where('lastlogin', $this->UserLastLogin);
			$this->db->update("{$this->jtctoolsHistorytable}",$parameters);
			$this->db->last_query();
		}
		return true;	
	}

}