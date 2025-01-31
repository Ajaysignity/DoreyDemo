<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' ); 
class FrontEndController extends CI_Controller {

	const ASSETAPI_URL = "https://api.financialprojector.com/AssetAllocator_2/runAssetAllocator";
	const ASSETAPI_LIVEURL = "https://dev.financialprojector.com/ATRProject/";
	protected $role = '';
	protected $vendorId = '';
	protected $name = '';
	protected $roleText = '';
	protected $global = array ();
	protected $lastLogin = '';
	public function __construct() {
		parent::__construct();
		$this->title = 'Financial Projector by Dorey Financial Modelling';
		$this->template = 'apps';
		if( $this->session->userdata('UserLoggedin') != TRUE || $this->session->userdata('userid') == '' ) {
			redirect(base_url(''),'refresh');
		}
		$this->controller = $this->router->fetch_class();
		$this->method = $this->router->fetch_method();
		
		$this->userid = $this->session->userdata('userid');
		$this->username = $this->session->userdata('username' );
		$this->organisation = $this->session->userdata ('organisation');
		$this->OrganisationName = $this->session->userdata('OrganisationName');
		$this->isshowdashboard = $this->session->userdata('isshowdashboard');
		$this->OrganisationApiName = $this->session->userdata ('OrganisationApiName');
		$this->UserLastLogin = $this->session->userdata ('UserLastLogin');

		$this->load->model('Auth_model','auth');
		$this->load->model('Teams_model','teams');
		$this->userinfo = userinfo($this->userid);

		$this->headerLabel = "I am saving for flexible income when I retire";
		$this->DefaultPortValue = ($this->session->userdata('DefaultPortValue') != '' ? $this->session->userdata('DefaultPortValue') : "100000");
		$this->DefaultCurrentAge = ($this->session->userdata('DefaultCurrentAge') != '' ? $this->session->userdata('DefaultCurrentAge') : 40);
		$this->DefaultRetirementAge = 65;
		$this->DefaultRetirementIncomeGoal = 20000;

		$this->RiskCheckLabel = "Your survey responses indicate you are in this risk zone for this section of the survey.";
		$this->RiskDangerLabel = "Your answers in this section do not match your overall risk profile. You may need to adjust your expectations to give yourself the best chance of achieving your investment goals. We recommend reviewing your results with a financial advisor.";

	}
	function loadAjaxViews($viewName = "", $pageInfo = NULL ){
		$this->load->view($this->template."/popup/".$viewName.'',$pageInfo);
    }
	public  function upload_image( $keyname, $filename, $directoryName) {
    	if (!is_dir("assets/uploads/$directoryName/")) {
		    mkdir("./assets/uploads/$directoryName/", 0777, TRUE);
		}
    	$config['upload_path']   = "assets/uploads/".$directoryName;
		$config['allowed_types'] = "gif|jpg|jpeg|png|svg";
		$config['max_size']      = "2048";
		$config['remove_spaces'] = true;
		$config['encrypt_name']  = true;
		$new_name = time().'_'.$filename;
		$config['file_name'] = $new_name;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ($this->upload->do_upload($keyname)) {
			$finfo = $this->upload->data();
			$return = array(
				'filename' => $finfo['file_name'],
				'status' =>true
			);
		} else {
			$return = array(
				'filename' => $this->upload->display_errors(),
				'status' =>false
			);
		}
		return $return;
    }
    public  function uploadFile( $directoryName, $filename ,$width = 0, $height = 0) {
    	if (!is_dir("assets/uploads/$directoryName/")) {
		    mkdir("./assets/uploads/$directoryName/", 0777, TRUE);
		}
		$keyname = $directoryName;
    	$config['upload_path']   = "assets/uploads/".$directoryName;
		$config['allowed_types'] = "pdf|doc|docx";
		$config['max_size']      = "2048";
		$config['min_width']     = $width;
		$config['min_height']    = $height;
		$config['remove_spaces'] = true;
		$config['encrypt_name']  = true;
		$new_name = time().'_'.$filename;
		$config['file_name'] = $new_name;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ($this->upload->do_upload($keyname)) {
			$finfo = $this->upload->data();
			$return = array(
				'filename' => $finfo['file_name'],
				'status' =>true
			);
		} else {
			$return = array(
				'filename' => $this->upload->display_errors(),
				'status' =>false
			);
		}
		return $return;
    }
	function isUserLoggedIn() {
		if ( $this->userinfo->PowerUser != 1 ) {
			redirect(base_url('apps/accessdenied'),'refresh');
		}
	}
	function paginationCompress($link, $count) {

		$config ['base_url'] = $link;
		$config ['total_rows'] = $count;
		$config ['uri_segment'] = $this->segment; 
		$config ['per_page'] = $this->limit;
		$config ['num_links'] = 2;
		$config['suffix']     = '?' . http_build_query($_GET, '', "&");  
		$config['first_url']  = $config['base_url'] . '?' . http_build_query($_GET);				
		$config['full_tag_open'] = '<ul class="tsc_pagination tsc_paginationA tsc_paginationA01">';
		$config['full_tag_close'] = '</ul>';
		$config['prev_link'] = 'Previous';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li>';  
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="current"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$this->pagination->initialize ( $config );
		$page = $config ['per_page'];
		$segment = $this->uri->segment ( $this->segment );
		return array (
			"page" => $page,
			"segment" => $segment
		);
	}
	static public function __getJTCApiAssetData($data, $method ) {
		$instance =& get_instance();
		$API_URL = self::ASSETAPI_LIVEURL.$method;	
		$curl = curl_init($API_URL);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_TIMEOUT, 300);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		$result = curl_exec($curl);
		curl_close($curl);
		return $result;
	}
	static public function __getApiAssetData($data) {
		$curl = curl_init(self::ASSETAPI_URL);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		$result = curl_exec($curl);
		curl_close($curl);
		return $result;
	}
	public function PingAssetServer_ApiCall() {
		$object = array('nargout'=>1,'rhs' => array('ping'));
		$instance = & get_instance();
		$API_URL = self::ASSETAPI_URL;	
		$curl = curl_init($API_URL);
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($object));
		curl_setopt($curl, CURLOPT_TIMEOUT, 300);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		$result = curl_exec($curl);
		curl_close($curl);
		echo $result;
	}
}
?>