<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'core/CI_Table.php';
class MY_Model extends CI_Table {
	public function __construct(){
		parent::__construct();
	} 
	public function ConvertintoString($string) {
        if (is_null($string) || $string == '') {
            return "";
        } else {
            return $string;
        }
    }
}
