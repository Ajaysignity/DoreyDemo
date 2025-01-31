<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/FrontEndController.php';

class Lucio extends FrontEndController {
	public function __construct() {
		parent::__construct();
		$this->load->model('Lucio_model','lucios');
		$this->folder = $this->template.'/lucios';
	}
	public function index(){
		$data['title']  = 'Drag & Drop | '.$this->title;
		$view = $this->folder.'/basehtml';
		$this->load->view('authlayouthtml',  array('data'=>$data,'views'=> $view));
	} 
	

	public function dropzoneImagesStore(){
		$count = count($_FILES['file']['name']); 
		$getAllFiles = [];
		$this->load->library('upload');
		$userid = $this->session->userdata('userid'); 
		$organisation = $this->session->userdata('organisation');

		for ($i = 0; $i < $count; $i++) {
			$_FILES['single_file']['name'] = $_FILES['file']['name'][$i];
			$_FILES['single_file']['type'] = $_FILES['file']['type'][$i];
			$_FILES['single_file']['tmp_name'] = $_FILES['file']['tmp_name'][$i];
			$_FILES['single_file']['error'] = $_FILES['file']['error'][$i];
			$_FILES['single_file']['size'] = $_FILES['file']['size'][$i];

			$config['upload_path'] = './assets/uploads/lucios/'; 
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|doc|docx|xlsx'; 
			$config['max_size'] = '1024'; 
			$this->upload->initialize($config); 

			if ($this->upload->do_upload('single_file')) {
				$fileData = $this->upload->data();
				$fileEntry = [
					'file_name' => $fileData['file_name'],
					'id_organisation' => $organisation,
					'user_id' => $userid,
				];
				$this->lucios->saveDocument($fileEntry);
				$getAllFiles[] = $fileData;
			} else {
				echo "Error uploading file: " . $_FILES['single_file']['name'] . "<br>";
				echo $this->upload->display_errors() . "<br>";
			}
		}
	}

	public function doccumentslist_json() {
		$idOrganisations = $idusersolutions = decryptKey($this->input->get('string'));
		$getsolns = $this->lucios->getdoccumentslist_json($_POST);
		$output = array(
			"recordsTotal" =>$getsolns['TotalRows'] ,
			"recordsFiltered" => $getsolns['TotalRows'],
			"data" => $getsolns['returndata'],
		);
		echo json_encode( $output );
	}
}