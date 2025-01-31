<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Lucio_model extends MY_Model {
    public function __construct(){
        parent::__construct();
		
    }    
    public function saveDocument($data)
    {
        $this->db->insert("{$this->tbldocuments}" , $data);
        return $this->db->insert_id();
    }
    public function getdoccumentslist_json($data = array() ){
		$TotalRows = 0;
		$returnRow = array();
		$aColumns = array('id', 'file_name', 'created_at');
		$limit = "";
		$sWhere = "";
		$offset = '';
		if (isset($data['start']) && $data['length'] != '-1') {
			$limit = $data['start'];
			$offset = $data['length'];
		}
		$sOrder = "";
		$sWhere = "";
		if (isset($data['search']['value']) && $data['search']['value'] != "") {
			$sWhere = "  (";
			for ($i = 0; $i < count($aColumns); $i++) {
				$sWhere .= $aColumns[$i] . " LIKE '%" . $data['search']['value'] . "%' OR ";
			}
			$sWhere = substr_replace($sWhere, "", -3);
			$sWhere .= ") ";
		}
		$this->db->select('count(*) as total')->from("{$this->tbldocuments}")->where('id_organisation', $this->organisation);
		if (!empty($sWhere)) {
			$this->db->where($sWhere);
		}
		$CountRows = $this->db->get()->row();
		$this->db->select('*')->from("{$this->tbldocuments}")->where('id_organisation', $this->organisation);
		if (!empty($sWhere)) {
			$this->db->where($sWhere);
		}
		$lists = $this->db->limit($offset, $limit)->get()->result();
        $counter =1;
		foreach ($lists as $jsonRow) :
			$returnRow[] = array(
                $counter++,
				$jsonRow->file_name,
				'<a href="' . assets_url('uploads/lucios/' . $jsonRow->file_name) . '" target="_blank"><span uk-icon="search"></span></a>',
				defaultdate($jsonRow->created_at,true)
			);
		endforeach;
		return array(
			'TotalRows' => $CountRows->total,
			'returndata' => $returnRow,
		);
	}
}