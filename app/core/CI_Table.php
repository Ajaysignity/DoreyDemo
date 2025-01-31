<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CI_Table extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->adminstable = 'dorey_admins';
		$this->userstable = 'dorey_users';
		$this->organisationtable = 'dorey_organisations';
		$this->otptable = 'dorey_otpmaster';
		$this->plansmastertable = 'dorey_plansmaster';
		$this->userlastlogintable = 'dorey_userlastlogin';   
		$this->solutionstable = 'dorey_usersolutions';   
		$this->supporttable = 'dorey_supportdata';
		$this->contacttable = 'dorey_contactformdata';
		$this->rolestable = 'dorey_rolesmaster';
		$this->faqstable = 'dorey_faqsdata';
		$this->catfaqstable = 'dorey_faqcategory';
		$this->discountmastertable = 'dorey_discountmaster';
		
		$this->menutable = 'dorey_menuname';
		$this->permissiontable = 'dorey_permissions';
		$this->paymentoptionstable = 'dorey_paymentoptions';
		$this->tblcountries = 'dorey_countries';
		
		$this->assumptionstable = 'dorey_investment_assumptions';
		$this->userrequestdeletetable = 'dorey_userrequestdelete';
		
		$this->tblorders = 'dorey_orders';
		$this->tblorderdetails = 'dorey_orderdetails';
		$this->tblcurrencies = 'dorey_currency';
		$this->tblordersReminderEmail = 'dorey_ordersreminderemails';
		$this->allocatortable = 'dorey_userallocator';  
		$this->appaccesstable = 'dorey_app_access';   
		$this->allocatorinfotable = 'dorey_allocatorinfo';   
		$this->jtcpensionstable = 'dorey_jtcpensions'; 
		
		
		$this->jtctoolstable = 'dorey_jtctools';   
		$this->jtctoolsHistorytable = 'dorey_jtctools_history';   
		$this->jtctoolstepstable = 'dorey_jtctoolsteps'; 
		  
		$this->tbldocuments = 'dorey_documents';
			
    }
}
?>