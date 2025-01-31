<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/FrontEndController.php';

class Marketupdate extends FrontEndController {
	public function __construct() {
		parent::__construct();
		$this->load->model('Lucio_model','lucios');
		$this->folder = $this->template.'/mrketupdate/';
	}
	public function index(){
		$data['title']  = 'Drag & Drop | '.$this->title;
		$view = $this->folder.'mrketupdatehtml';
		$this->load->view('authlayouthtml',  array('data'=>$data,'views'=> $view));
	}
}