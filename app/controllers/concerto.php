<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/FrontEndController.php';
class concerto extends FrontEndController {
	public function __construct() {
		parent::__construct();
		$this->txtSessionIDtxtUserInput = '<input type="hidden" id="txtSessionIDtxtUserID"
        value="'.($this->organisation.'::'.$this->userid.'::'.$this->OrganisationApiName).'" />';
		if(IsMobileBrowser()) 
			$this->viewFolder = "/concerto/mobile/";
		else
			$this->viewFolder = "/concerto/";
		$this->load->model('concerto_model','concerto');
	}
	static public function SetdefaultCurrency(){
		if (!isset($_COOKIE['selectedcurrencyvalue'])) {
			$expiry = time() + (86400 * 30);
			setcookie('selectedcurrencyvalue', '$', $expiry, "/");
			setcookie('selectedcurrencytext', '$ (USD)', $expiry, "/");
		}
	} 
	public function index() {
		$data = array(
			'title' => 'Information  | '.$this->title,
		);
		$this->concerto->removejtcinfo($this->userid);
		$view = $this->template.$this->viewFolder.'informationshtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function choice() {
		$data = array(
			'title' => 'Choices  | '.$this->title,
		);
		self::SetdefaultCurrency();
		$view = $this->template.$this->viewFolder.'choiceshtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function contributing() {
		$data = array(
			'title' => 'Contributing | '.$this->title,
		);
		$view = $this->template.$this->viewFolder.'contributing/contributinghtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function contributing_background() {
		$info = $this->concerto->getjtcinfo();
		$data = array(
			'title' => 'Contributing background | '.$this->title,
			'type' => encryptKey('contributing_background'),
			'info' => (isset($info->contributing_background) ? json_decode($info->contributing_background) :''),
			'httpredirect' => encryptKey(website_url('concerto/contributing-horizon')),
		);
		$this->headerLabel = self::__commaonHeaderText('contributing');
		$view = $this->template.$this->viewFolder.'contributing/contributingbackgroundhtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function contributing_horizon() {
		$pagenview = "contributinghorizon-a-html";
		$info = $this->concerto->getjtcinfo();
		$data = array(
			'title' => 'Contributing Horizon | '.$this->title,
			'type' => encryptKey('contributing_horizon'),
			'info' => json_decode($info->contributing_horizon),
			'httpredirect' => encryptKey(website_url('concerto/contributing-growth')),
		);
		$this->headerLabel = self::__commaonHeaderText('contributing');
		$view = $this->template.$this->viewFolder.'contributing/'.$pagenview;
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function contributing_growth() {
		$info = $this->concerto->getjtcinfo();
		$data = array(
			'title' => 'Contributing Growth | '.$this->title,
			'type' => encryptKey('contributing_growth'),
			'atrtype' => encryptKey('runGrowthPage'),
			'info' => json_decode($info->contributing_growth),
			'tokenid' => encryptKey($info->id),
			'httpredirect' => encryptKey(website_url('concerto/contributing-potential-falls')),
		);
		$this->headerLabel = self::__commaonHeaderText('contributing');
		$view = $this->template.$this->viewFolder.'contributing/contributinggrowthhtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function contributing_potential_falls() {
		$info = $this->concerto->getjtcinfo();
		$data = array(
			'title' => 'Contributing Potential Falls | '.$this->title,
			'type' => encryptKey('contributing_potentialfalls'),
			'atrtype' => encryptKey('runPotentialFalls'),
			'info' => json_decode($info->contributing_potentialfalls),
			'httpredirect' => encryptKey(website_url('concerto/contributing-missing-out')),
		);
		$this->headerLabel = self::__commaonHeaderText('contributing');
		$view = $this->template.$this->viewFolder.'contributing/contributingpotentialfallshtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function contributing_missing_out() {
		$info = $this->concerto->getjtcinfo();
		$data = array(
			'title' => 'Contributing Missing Out | '.$this->title,
			'type' => encryptKey('contributing_missing_out'),
			'info' => json_decode($info->contributing_missing_out),
			'httpredirect' => encryptKey(website_url('concerto/contributing-liquidity')),
		);
		$this->headerLabel = self::__commaonHeaderText('contributing');
		$view = $this->template.$this->viewFolder.'contributing/contributingmissingouthtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}

	public function contributing_liquidity() {
		$info = $this->concerto->getjtcinfo();
		$data = array(
			'title' => 'contributing Liquidity | '.$this->title,
			'type' => encryptKey('contributing_liquidity'),
			'info' => json_decode($info->contributing_liquidity),
			'httpredirect' => encryptKey(website_url('concerto/contributing-risk')),
		);
		$this->headerLabel = self::__commaonHeaderText('contributing');
		$view = $this->template.$this->viewFolder.'contributing/contributingliquidityhtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}

	public function contributing_risk() {
		$info = $this->concerto->getjtcinfo();
		$data = array(
			'title' => 'Contributing Risk | '.$this->title,
			'type' => encryptKey('contributing_risk'),
			'info' => json_decode($info->contributing_risk),
			'httpredirect' => encryptKey(website_url('concerto/contributing-results')),
		);
		$this->headerLabel = self::__commaonHeaderText('contributing');
		$view = $this->template.$this->viewFolder.'contributing/contributingriskhtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}
	
	public function contributing_results() {
		$info = $this->concerto->getjtcinfo();
		$riskinfo = json_decode($info->contributing_risk);
		$horizoninfo = json_decode($info->contributing_horizon);
		$transparencyinfo = json_decode($info->contributing_background);
		$data = array(
			'title' => 'Contributing Results | '.$this->title,
			'type' => encryptKey('contributing_results'),
			'riskinfo' => $riskinfo,
			'transparencyinfo' => $transparencyinfo,
			'horizoninfo' => $horizoninfo,
			'httpredirect' => encryptKey(website_url('concerto/contributing-results')),
		);
		$this->headerLabel = self::__commaonHeaderText('contributing');
		$view = $this->template.$this->viewFolder.'contributing/contributingresultshtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}
	static public function valiateCustomMessage($status, $message, $title = NULL ) {
		return json_encode(array(
			'status' => $status,
			'title' => ($title == '' ? 'Error' : $title),
			'message' => $message
		));
	}
	public function savecontributingtransparency() {
		$type = decryptKey($this->input->post('type'));
		if( $type == 'contributing_background') {
			$this->form_validation->set_rules('Experience_investing', 'Experience investing', 'required|xss_clean');
			$this->form_validation->set_rules('Knowledge', 'Knowledge', 'required|xss_clean');
			$this->form_validation->set_rules('Investment_decision_maker', 'Investment decision maker', 'required|xss_clean');
			$this->form_validation->set_rules('Income_per_annum', 'Income per annum', 'required|xss_clean');
			$this->form_validation->set_rules('Contributions_per_annum', 'Contributions per annum', 'required|xss_clean');
			$this->form_validation->set_rules('Other_sources_of_income', 'Other sources of income', 'required|xss_clean');
		}
		if( $type == 'contributing_horizon') {
			$this->form_validation->set_rules('retirerment_age', 'Retirement age', 'required|xss_clean|is_numeric');
		}
		if( $type == 'contributing_growth') {
			$this->form_validation->set_rules('planting_growth_label', 'Planting Growth', 'required|xss_clean|is_numeric');
		}
		if( $type == 'contributing_potentialfalls') {
			$this->form_validation->set_rules('planting_potentialfalls_label', 'Planting Potential Fall', 'required|xss_clean|is_numeric');
		}
		if( $type == 'contributing_missing_out') {
			$this->form_validation->set_rules('planting_regret_label', 'Planting Missing Out', 'required|xss_clean|is_numeric');
		}
	
		$this->form_validation->set_rules('type', 'Type', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			echo self::valiateCustomMessage(false, 'Please complete all questions to proceed.' );
		} else {
			$income_per_annum = $this->input->post('Income_per_annum');
			$Contributions_per_annum = $this->input->post('Contributions_per_annum');
			$Contributions_percentage = $this->input->post('Contributions_percentage');
			if( $type == 'contributing_background' && filter_var($income_per_annum, FILTER_SANITIZE_NUMBER_INT) < 0 ) {
				echo self::valiateCustomMessage(false, 'Income can not be less than 0');
			} else if( $type == 'contributing_background' && filter_var($Contributions_per_annum, FILTER_SANITIZE_NUMBER_INT) <= 0 ) {
				echo self::valiateCustomMessage(false, 'If you are not making contributions, please return <a href="'.website_url('concerto/choice').'" style="text-decoration: underline;">Home</a> and select Investing or Withdrawing.','Check');
			} else if( $type == 'contributing_background' && filter_var($Contributions_percentage, FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION) <= 0 ) {
				echo self::valiateCustomMessage(false, 'If you are not making contributions, please return <a href="'.website_url('concerto/choice').'" style="text-decoration: underline;">Home</a> and select Investing or Withdrawing.','check');
			} else {
				$httpredirect = decryptKey($this->input->post('httpredirect'));
				$parameters = array(
					'userid' =>$this->userid,
					'contributing_pathway' =>$_COOKIE['LandingPageiTem'],
				);

				if( $type == 'contributing_background') {
					$parameters['contributing_background'] = json_encode(array(
						'Experience_investing' => $this->input->post('Experience_investing'),
						'Knowledge' => $this->input->post('Knowledge'),
						'Investment_decision_maker' => $this->input->post('Investment_decision_maker'),
						'Income_per_annum' => str_replace(',','',$this->input->post('Income_per_annum')),
						'Contributions_per_annum' => str_replace(',','',$this->input->post('Contributions_per_annum')),
						'Contributions_percentage' => $this->input->post('Contributions_percentage'),
						//'Desiredincome_per_annum' => str_replace(',','',$this->input->post('Desiredincome_per_annum')),
						'Other_sources_of_income' => $this->input->post('Other_sources_of_income')
					));
					$parameters['contributing_choice'] = $_COOKIE['LandingPageiTem'];
					$parameters['lastlogin'] = $this->UserLastLogin;
					$parameters['investing_background'] = json_encode(array(
						'Experience_investing' => $this->input->post('Experience_investing'),
						'Knowledge' => $this->input->post('Knowledge'),
						'Investment_decision_maker' => $this->input->post('Investment_decision_maker'),
						'Income_per_annum' => str_replace(',','',$this->input->post('Income_per_annum')),
						'Other_sources_of_income' => $this->input->post('Other_sources_of_income')
					));
					$parameters['withdrawing_background'] = json_encode(array(
						'Experience_investing' => $this->input->post('Experience_investing'),
						'Knowledge' => $this->input->post('Knowledge'),
						'Investment_decision_maker' => $this->input->post('Investment_decision_maker'),
						'Income_per_annum' => str_replace(',','',$this->input->post('Income_per_annum')),
						'Other_sources_of_income' => $this->input->post('Other_sources_of_income')
					));
				} 
				if( $type == 'contributing_horizon') {
					$parameters['contributing_horizon'] = json_encode(array(
						'current_age' => $this->input->post('current_age'),
						'retirerment_age' => $this->input->post('retirerment_age'),
					));
					$parameters['investing_horizon'] = json_encode(array(
						'current_age' => $this->input->post('current_age'),
						'retirerment_age' => $this->input->post('retirerment_age'),
					));
					$parameters['withdrawing_horizon'] = json_encode(array(
						'current_age' => $this->input->post('current_age'),
						'retirerment_age' => $this->input->post('current_age'),
					));
				}
				if( $type == 'contributing_growth') {
					$parameters['contributing_growth'] = json_encode(array(
						'planting_growth_info' => $this->input->post('planting_growth_info'),
						'planting_growth_label' => $this->input->post('planting_growth_label')		
					));
					$parameters['investing_growth'] = json_encode(array(
						'planting_growth_info' => $this->input->post('planting_growth_info'),
						'planting_growth_label' => $this->input->post('planting_growth_label')		
					));
					$parameters['withdrawing_growth'] = json_encode(array(
						'planting_growth_info' => $this->input->post('planting_growth_info'),
						'planting_growth_label' => $this->input->post('planting_growth_label')		
					));
				}
				if( $type == 'contributing_potentialfalls') {
					$parameters['contributing_potentialfalls'] = json_encode(array(
						'planting_potentialfalls_tagline' => $this->input->post('planting_potentialfalls_tagline'),
						'planting_potentialfalls_info' => $this->input->post('planting_potentialfalls_info'),
						'planting_potentialfalls_label' => $this->input->post('planting_potentialfalls_label'),
					));
					$parameters['investing_potentialfalls'] = json_encode(array(
						'planting_potentialfalls_tagline' => $this->input->post('planting_potentialfalls_tagline'),
						'planting_potentialfalls_info' => $this->input->post('planting_potentialfalls_info'),
						'planting_potentialfalls_label' => $this->input->post('planting_potentialfalls_label'),
					));
					$parameters['withdrawing_potentialfalls'] = json_encode(array(
						'planting_potentialfalls_tagline' => $this->input->post('planting_potentialfalls_tagline'),
						'planting_potentialfalls_info' => $this->input->post('planting_potentialfalls_info'),
						'planting_potentialfalls_label' => $this->input->post('planting_potentialfalls_label'),
					));
				}
				if( $type == 'contributing_missing_out') {
					$parameters['contributing_missing_out'] = json_encode(array(
						'planting_regret_info' => $this->input->post('planting_regret_info'),
						'planting_regret_label' => $this->input->post('planting_regret_label')
					));
					$parameters['investing_missing_out'] = json_encode(array(
						'planting_regret_info' => $this->input->post('planting_regret_info'),
						'planting_regret_label' => $this->input->post('planting_regret_label')
					));
					$parameters['withdrawing_missing_out'] = json_encode(array(
						'planting_regret_info' => $this->input->post('planting_regret_info'),
						'planting_regret_label' => $this->input->post('planting_regret_label')
					));
				}
				if( $type == 'contributing_liquidity') {
					$parameters['contributing_liquidity'] = json_encode(array(
						'withdraw_percentage' => $this->input->post('withdraw_percentage'),
					));
					$parameters['withdrawing_liquidity'] = json_encode(array(
						'withdraw_percentage' => $this->input->post('withdraw_percentage'),
					));
					$parameters['investing_liquidity'] = json_encode(array(
						'withdraw_percentage' => $this->input->post('withdraw_percentage'),
					));
				}
				
				if( $type == 'contributing_risk') {
					$parameters['contributing_risk'] = json_encode(array(
						'risklabel' => $this->input->post('risklabel'),
						'risknumber' => $this->input->post('risknumber')
					));
				}
				$info = $this->concerto->getjtcinfo();
				if( !empty($info) ) {
					$this->concerto->UpdateJtcToolnfo($parameters);
					$this->concerto->UpdateJtcToolnfoHistory($parameters);
					$message = "Updated";
				} else {
					$this->concerto->SaveJtcToolnfo($parameters);
					$this->concerto->SaveJtcToolnfoHistory($parameters);
					$message = "Saved";
				}
				if( $type == 'contributing_background' && filter_var($income_per_annum, FILTER_SANITIZE_NUMBER_INT) < (filter_var($Contributions_per_annum, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION)*12) ) {
					echo json_encode(array('status'=>true,'openSuccessPopup'=>true,'http_redirect'=>$httpredirect, 'message'=>'Your contributions exceed your stated income. Please check this is correct or update before continuing.'));
				}elseif( $type == 'contributing_liquidity' && $this->input->post('withdraw_percentage') < 1 ) {
					echo json_encode(array('status'=>true,'openSuccessPopup'=>true,'http_redirect'=>$httpredirect, 'message'=>'Please confirm your liquidity needs are 0% to proceed. If not, please click ‘Back’ to update.'));
				} else if( $type == 'contributing_transparency' && (filter_var($Contributions_per_annum, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION)*12) > filter_var($income_per_annum, FILTER_SANITIZE_NUMBER_INT) ) {
					echo json_encode(array('status'=>true,'successpopup'=>true,'http_redirect'=>$httpredirect,'message'=>'Your annual contributions exceed your annual income. Please confirm this is correct.'));
				} else {
					echo json_encode(array('status'=>true,'http_redirect'=>$httpredirect,'message'=>'Content has been '.$message.' successfully!'));
				}
			}
		}
	}

	/**************investing start***********/
	public function investing() {
		$data = array(
			'title' => 'Investing | '.$this->title,
		);
		$view = $this->template.$this->viewFolder.'investing/investinghtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}
    
	public function investing_background() {
		$info = $this->concerto->getjtcinfo();
		$data = array(
			'title' => 'Investing Background | '.$this->title,
			'type' => encryptKey('investing_background'),
			'info' => json_decode($info->investing_background),
			'httpredirect' => encryptKey(website_url('concerto/investing-horizon')),
		);
		$this->headerLabel = self::__commaonHeaderText('investing');
		$view = $this->template.$this->viewFolder.'investing/investingbackgroundhtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}
	
	public function investing_horizon() {
		$pagenview = "investinghorizon-a-html";
		$info = $this->concerto->getjtcinfo();
		$data = array(
			'title' => 'Investing Horizon | '.$this->title,
			'type' => encryptKey('investing_horizon'),
			'info' => json_decode($info->investing_horizon),
			'httpredirect' => encryptKey(website_url('concerto/investing-growth')),
		);
		$this->headerLabel = self::__commaonHeaderText('investing');
		$view = $this->template.$this->viewFolder.'investing/'.$pagenview;
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function investing_growth() {
		$info = $this->concerto->getjtcinfo();
		$data = array(
			'title' => 'Investing Growth | '.$this->title,
			'type' => encryptKey('investing_growth'),
			'atrtype' => encryptKey('runGrowthPage'),
			'info' => json_decode($info->investing_growth),
			'httpredirect' => encryptKey(website_url('concerto/investing-potential-falls')),
		);
		$this->headerLabel = self::__commaonHeaderText('investing');
		$view = $this->template.$this->viewFolder.'investing/investinggrowthhtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function investing_potential_falls() {
		$info = $this->concerto->getjtcinfo();
		$data = array(
			'title' => 'Investing Potential Falls | '.$this->title,
			'type' => encryptKey('investing_potentialfalls'),
			'atrtype' => encryptKey('runPotentialFalls'),
			'info' => json_decode($info->investing_potentialfalls),
			'httpredirect' => encryptKey(website_url('concerto/investing-missing-out')),
		);
		$this->headerLabel = self::__commaonHeaderText('investing');
		$view = $this->template.$this->viewFolder.'investing/investingpotentialfallshtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function investing_missing_out() {
		$info = $this->concerto->getjtcinfo();
		$data = array(
			'title' => 'Investing Missing Out | '.$this->title,
			'type' => encryptKey('investing_missing_out'),
			'info' => json_decode($info->investing_missing_out),
			'httpredirect' => encryptKey(website_url('concerto/investing-liquidity')),
		);
		$this->headerLabel = self::__commaonHeaderText('investing');
		$view = $this->template.$this->viewFolder.'investing/investingmissingouthtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}

	public function investing_liquidity() {
		$info = $this->concerto->getjtcinfo();
		$data = array(
			'title' => 'Investing Liquidity | '.$this->title,
			'type' => encryptKey('investing_liquidity'),
			'info' => json_decode($info->investing_liquidity),
			'httpredirect' => encryptKey(website_url('concerto/investing-risk')),
		);
		$this->headerLabel = self::__commaonHeaderText('investing');
		$view = $this->template.$this->viewFolder.'investing/investingliquidityhtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}

	public function investing_risk() {
		$info = $this->concerto->getjtcinfo();
		$data = array(
			'title' => 'Investing Risk | '.$this->title,
			'type' => encryptKey('investing_risk'),
			'info' => json_decode($info->investing_risk),
			'httpredirect' => encryptKey(website_url('concerto/investing-results')),
		);
		$this->headerLabel = self::__commaonHeaderText('investing');
		$view = $this->template.$this->viewFolder.'investing/investingriskhtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}

	public function investing_results() {
		$info = $this->concerto->getjtcinfo();
		$riskinfo = json_decode($info->investing_risk);
		$horizoninfo = json_decode($info->investing_horizon);
		$transparencyinfo = json_decode($info->investing_background);

		
		$data = array(
			'title' => 'Investing Results | '.$this->title,
			'type' => encryptKey('investing_results'),
			'riskinfo' => $riskinfo,
			'transparencyinfo' => $transparencyinfo,
			'horizoninfo' => $horizoninfo,
			'httpredirect' => encryptKey(website_url('concerto/investing-results')),
		);
		$this->headerLabel = self::__commaonHeaderText('investing');
		$view = $this->template.$this->viewFolder.'investing/investingresultshtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function saveinvestingtransparency() {
		$type = decryptKey($this->input->post('type'));
		if( $type == 'investing_background') {
			$this->form_validation->set_rules('Experience_investing', 'Experience investing', 'required|xss_clean');
			$this->form_validation->set_rules('Knowledge', 'Knowledge', 'required|xss_clean');
			$this->form_validation->set_rules('Investment_decision_maker', 'Investment decision maker', 'required|xss_clean');
			$this->form_validation->set_rules('Income_per_annum', 'Income per annum', 'required|xss_clean');
			$this->form_validation->set_rules('Contributions_per_annum', 'Contributions per annum', 'required|xss_clean');
			$this->form_validation->set_rules('Other_sources_of_income', 'Other sources of income', 'required|xss_clean');
		}
		if( $type == 'investing_growth') {
			$this->form_validation->set_rules('planting_growth_label', 'Investing Label', 'required|xss_clean|is_numeric');
		}
		if( $type == 'investing_potentialfalls') {
			$this->form_validation->set_rules('planting_potentialfalls_label', 'Investing Potential Falls', 'required|xss_clean|is_numeric');
		}
		if( $type == 'investing_missing_out') {
			$this->form_validation->set_rules('planting_regret_label', 'Investing Missing Out', 'required|xss_clean|is_numeric');
		}
		
		$this->form_validation->set_rules('type', 'Type', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			echo self::valiateCustomMessage(false, 'Please complete all questions to proceed.');
		} else {
			if( $type == 'investing_background' && filter_var($this->input->post('Income_per_annum'), FILTER_SANITIZE_NUMBER_INT) < 0 ) {
				echo self::valiateCustomMessage(false, 'Income can not be less than 0');
			} else {
				$httpredirect = decryptKey($this->input->post('httpredirect'));
				$parameters = array(
					'userid' =>$this->userid,
					'contributing_pathway' =>$_COOKIE['LandingPageiTem'],
				);

				if( $type == 'investing_background') {
					$info = $this->concerto->getjtcinfo();
					$PlantingTransparencyInfo = json_decode($info->contributing_background);
					$parameters['investing_background'] = json_encode(array(
						'Experience_investing' => $this->input->post('Experience_investing'),
						'Knowledge' => $this->input->post('Knowledge'),
						'Investment_decision_maker' => $this->input->post('Investment_decision_maker'),
						'Income_per_annum' => str_replace(',','',$this->input->post('Income_per_annum')),
						'Contributions_per_annum' => str_replace(',','',$this->input->post('Contributions_per_annum')),
						//'Desiredincome_per_annum' => str_replace(',','',$this->input->post('Desiredincome_per_annum')),
						'Other_sources_of_income' => $this->input->post('Other_sources_of_income'),
						
					));
					$parameters['investing_choice'] = $_COOKIE['LandingPageiTem'];
					$parameters['lastlogin'] = $this->UserLastLogin;
					$parameters['contributing_background'] = json_encode(array(
						'Experience_investing' => $this->input->post('Experience_investing'),
						'Knowledge' => $this->input->post('Knowledge'),
						'Investment_decision_maker' => $this->input->post('Investment_decision_maker'),
						'Income_per_annum' => $PlantingTransparencyInfo->Income_per_annum,
						'Contributions_per_annum' => $PlantingTransparencyInfo->Contributions_per_annum,
						'Contributions_percentage' => $PlantingTransparencyInfo->Contributions_percentage,
						//'Desiredincome_per_annum' => str_replace(',','',$this->input->post('Desiredincome_per_annum')),
						'Other_sources_of_income' => $this->input->post('Other_sources_of_income')
					));
					$parameters['withdrawing_background'] = json_encode(array(
						'Experience_investing' => $this->input->post('Experience_investing'),
						'Knowledge' => $this->input->post('Knowledge'),
						'Investment_decision_maker' => $this->input->post('Investment_decision_maker'),
						'Income_per_annum' => str_replace(',','',$this->input->post('Income_per_annum')),
						'Other_sources_of_income' => $this->input->post('Other_sources_of_income')
					));
				}
				if( $type == 'investing_horizon') {
					$parameters['contributing_horizon'] = json_encode(array(
						'current_age' => $this->input->post('current_age'),
						'retirerment_age' => $this->input->post('retirerment_age')
					));
					$parameters['investing_horizon'] = json_encode(array(
						'current_age' => $this->input->post('current_age'),
						'retirerment_age' => $this->input->post('retirerment_age')
					));
					$parameters['withdrawing_horizon'] = json_encode(array(
						'current_age' => $this->input->post('current_age'),
						'retirerment_age' => $this->input->post('current_age')
					));
				}
				if( $type == 'investing_growth') {
					$parameters['contributing_growth'] = json_encode(array(
						'planting_growth_info' => $this->input->post('planting_growth_info'),
						'planting_growth_label' => $this->input->post('planting_growth_label')		
					));
					$parameters['investing_growth'] = json_encode(array(
						'planting_growth_info' => $this->input->post('planting_growth_info'),
						'planting_growth_label' => $this->input->post('planting_growth_label')			
					));
					$parameters['withdrawing_growth'] = json_encode(array(
						'planting_growth_info' => $this->input->post('planting_growth_info'),
						'planting_growth_label' => $this->input->post('planting_growth_label')			
					));
				}
				if( $type == 'investing_potentialfalls') {
					$parameters['contributing_potentialfalls'] = json_encode(array(
						'planting_potentialfalls_tagline' => $this->input->post('planting_potentialfalls_tagline'),
						'planting_potentialfalls_info' => $this->input->post('planting_potentialfalls_info'),
						'planting_potentialfalls_label' => $this->input->post('planting_potentialfalls_label')
					));
					$parameters['investing_potentialfalls'] = json_encode(array(
						'planting_potentialfalls_tagline' => $this->input->post('planting_potentialfalls_tagline'),
						'planting_potentialfalls_info' => $this->input->post('planting_potentialfalls_info'),
						'planting_potentialfalls_label' => $this->input->post('planting_potentialfalls_label')
					));
					$parameters['withdrawing_potentialfalls'] = json_encode(array(
						'planting_potentialfalls_tagline' => $this->input->post('planting_potentialfalls_tagline'),
						'planting_potentialfalls_info' => $this->input->post('planting_potentialfalls_info'),
						'planting_potentialfalls_label' => $this->input->post('planting_potentialfalls_label')
					));
				}
				if( $type == 'investing_missing_out') {
					$parameters['contributing_missing_out'] = json_encode(array(
						'planting_regret_info' => $this->input->post('planting_regret_info'),
						'planting_regret_label' => $this->input->post('planting_regret_label')
					));
					$parameters['investing_missing_out'] = json_encode(array(
						'planting_regret_info' => $this->input->post('planting_regret_info'),
						'planting_regret_label' => $this->input->post('planting_regret_label')
					));
					$parameters['withdrawing_missing_out'] = json_encode(array(
						'planting_regret_info' => $this->input->post('planting_regret_info'),
						'planting_regret_label' => $this->input->post('planting_regret_label')
					));
				}
				if( $type == 'investing_liquidity') {
					$parameters['contributing_liquidity'] = json_encode(array(
						'withdraw_percentage' => $this->input->post('withdraw_percentage'),
					));
					$parameters['withdrawing_liquidity'] = json_encode(array(
						'withdraw_percentage' => $this->input->post('withdraw_percentage'),
					));
					$parameters['investing_liquidity'] = json_encode(array(
						'withdraw_percentage' => $this->input->post('withdraw_percentage'),
					));
				}

				if( $type == 'investing_risk') {
					$parameters['investing_risk'] = json_encode(array(
						'risklabel' => $this->input->post('risklabel'),
						'risknumber' => $this->input->post('risknumber')
					));
				}

				$info = $this->concerto->getjtcinfo();
				if( !empty($info) ) {
					$this->concerto->UpdateJtcToolnfo($parameters);
					$this->concerto->UpdateJtcToolnfoHistory($parameters);
					$message = "Updated";
				} else {
					$this->concerto->SaveJtcToolnfo($parameters);
					$this->concerto->SaveJtcToolnfoHistory($parameters);
					$message = "Saved";
				}
				if( $type == 'investing_liquidity' && $this->input->post('withdraw_percentage') < 1 ) {
					echo json_encode(array('status'=>true,'openSuccessPopup'=>true,'http_redirect'=>$httpredirect, 'message'=>'Please confirm your liquidity needs are 0% to proceed. If not, please click ‘Back’ to update.'));
				} else {
					echo json_encode(array('status'=>true,'http_redirect'=>$httpredirect,'message'=>'Content has been '.$message.' successfully!'));
				}
			}
		}
	}




	/**************withdrawing start***********/
	public function withdrawing() {
		$data = array(
			'title' => 'Withdrawing | '.$this->title,
		);
		$view = $this->template.$this->viewFolder.'withdrawing/withdrawinghtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function withdrawing_background() {
		$info = $this->concerto->getjtcinfo();
		$PlantingTransparencyInfo = json_decode($info->contributing_background);
		$data = array(
			'title' => 'Withdrawing Background | '.$this->title,
			'type' => encryptKey('withdrawing_background'),
			'info' => json_decode($info->withdrawing_background),
			'httpredirect' => encryptKey(website_url('concerto/withdrawing-horizon')),
		);
		$this->headerLabel = self::__commaonHeaderText('withdrawing');
		$view = $this->template.$this->viewFolder.'withdrawing/withdrawingbackgroundhtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}

	public function withdrawing_horizon() {
		$pagenview = "withdrawinghorizon-a-html";
		$info = $this->concerto->getjtcinfo();
		$data = array(
			'title' => 'withdrawing Horizon | '.$this->title,
			'type' => encryptKey('withdrawing_horizon'),
			'info' => json_decode($info->withdrawing_horizon),
			'httpredirect' => encryptKey(website_url('concerto/withdrawing-growth')),
		);
		$this->headerLabel = self::__commaonHeaderText('withdrawing');
		$view = $this->template.$this->viewFolder.'withdrawing/'.$pagenview;
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function withdrawing_growth() {
		$info = $this->concerto->getjtcinfo();
		$data = array(
			'title' => 'Withdrawing Growth | '.$this->title,
			'type' => encryptKey('withdrawing_growth'),
			'atrtype' => encryptKey('runGrowthPage'),
			'info' => json_decode($info->withdrawing_growth),
			'httpredirect' => encryptKey(website_url('concerto/withdrawing-potential-falls')),
		);
		$this->headerLabel = self::__commaonHeaderText('withdrawing');
		$view = $this->template.$this->viewFolder.'withdrawing/withdrawinggrowthhtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function withdrawing_potential_falls() {
		$info = $this->concerto->getjtcinfo();
		$data = array(
			'title' => 'Withdrawing Potential Falls | '.$this->title,
			'type' => encryptKey('withdrawing_potentialfalls'),
			'atrtype' => encryptKey('runPotentialFalls'),
			'info' => json_decode($info->withdrawing_potentialfalls),
			'httpredirect' => encryptKey(website_url('concerto/withdrawing-missing-out')),
		);
		$this->headerLabel = self::__commaonHeaderText('withdrawing');
		$view = $this->template.$this->viewFolder.'withdrawing/withdrawingpotentialfallshtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function withdrawing_missing_out() {
		$info = $this->concerto->getjtcinfo();
		$data = array(
			'title' => 'Withdrawing Missing Out | '.$this->title,
			'type' => encryptKey('withdrawing_missing_out'),
			'info' => json_decode($info->withdrawing_missing_out),
			'httpredirect' => encryptKey(website_url('concerto/withdrawing-liquidity')),
		);
		$this->headerLabel = self::__commaonHeaderText('withdrawing');
		$view = $this->template.$this->viewFolder.'withdrawing/withdrawingmissingouthtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}

	public function withdrawing_liquidity() {
		$info = $this->concerto->getjtcinfo();
		$data = array(
			'title' => 'Withdrawing Liquidity | '.$this->title,
			'type' => encryptKey('withdrawing_liquidity'),
			'info' => json_decode($info->withdrawing_liquidity),
			'httpredirect' => encryptKey(website_url('concerto/withdrawing-risk')),
		);
		$this->headerLabel = self::__commaonHeaderText('withdrawing');
		$view = $this->template.$this->viewFolder.'withdrawing/withdrawingliquidityhtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function withdrawing_risk() {
		$info = $this->concerto->getjtcinfo();
		$data = array(
			'title' => 'Withdrawing Risk | '.$this->title,
			'type' => encryptKey('withdrawing_risk'),
			'info' => json_decode($info->withdrawing_risk),
			'httpredirect' => encryptKey(website_url('concerto/withdrawing-results')),
		);
		$this->headerLabel = self::__commaonHeaderText('withdrawing');
		$view = $this->template.$this->viewFolder.'withdrawing/withdrawingriskhtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function withdrawing_results() {
		$info = $this->concerto->getjtcinfo();
		$riskinfo = json_decode($info->withdrawing_risk);
		$horizoninfo = json_decode($info->withdrawing_horizon);
		$transparencyinfo = json_decode($info->withdrawing_background);
		$data = array(
			'title' => 'Withdrawing Results | '.$this->title,
			'type' => encryptKey('withdrawing_results'),
			'riskinfo' => $riskinfo,
			'transparencyinfo' => $transparencyinfo,
			'horizoninfo' => $horizoninfo,
			'httpredirect' => encryptKey(website_url('concerto/withdrawing-results')),
		);
		$this->headerLabel = self::__commaonHeaderText('withdrawing');
		$view = $this->template.$this->viewFolder.'withdrawing/withdrawingresultshtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function saveWithdrawingtransparency() {
		$type = decryptKey($this->input->post('type'));
		if( $type == 'withdrawing_background') {
			$this->form_validation->set_rules('Experience_investing', 'Experience investing', 'required|xss_clean');
			$this->form_validation->set_rules('Knowledge', 'Knowledge', 'required|xss_clean');
			$this->form_validation->set_rules('Investment_decision_maker', 'Investment decision maker', 'required|xss_clean');
			$this->form_validation->set_rules('Income_per_annum', 'Income per annum', 'required|xss_clean');
			$this->form_validation->set_rules('Contributions_per_annum', 'Contributions per annum', 'required|xss_clean');
			$this->form_validation->set_rules('Other_sources_of_income', 'Other sources of income', 'required|xss_clean');
		}
		if( $type == 'withdrawing_growth') {
			$this->form_validation->set_rules('planting_growth_label', 'Withdrawing growth label', 'required|xss_clean|is_numeric');
		}
		if( $type == 'withdrawing_potentialfalls') {
			$this->form_validation->set_rules('planting_potentialfalls_label', 'Withdrawing potential fall', 'required|xss_clean|is_numeric');
		}
		if( $type == 'withdrawing_missing_out') {
			$this->form_validation->set_rules('planting_regret_label', 'Withdrawing missing out', 'required|xss_clean|is_numeric');
		}
		$this->form_validation->set_rules('type', 'Type', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			echo self::valiateCustomMessage(false, 'Please complete all questions to proceed.');
		} else {
			if( $type == 'withdrawing_background' && filter_var($this->input->post('Income_per_annum'), FILTER_SANITIZE_NUMBER_INT) < 0 ) {
				echo self::valiateCustomMessage(false, 'Income can not be less than 0');
			} else {
				$httpredirect = decryptKey($this->input->post('httpredirect'));
				$parameters = array(
					'userid' =>$this->userid,
					'contributing_pathway' =>$_COOKIE['LandingPageiTem'],
				);
				if( $type == 'withdrawing_background') {
					$info = $this->concerto->getjtcinfo();
					$PlantingTransparencyInfo = json_decode($info->contributing_background);
					$parameters['withdrawing_background'] = json_encode(array(
						'Experience_investing' => $this->input->post('Experience_investing'),
						'Knowledge' => $this->input->post('Knowledge'),
						'Investment_decision_maker' => $this->input->post('Investment_decision_maker'),
						'Income_per_annum' => str_replace(',','',$this->input->post('Income_per_annum')),
						'Contributions_per_annum' => str_replace(',','',$this->input->post('Contributions_per_annum')),
						//'Desiredincome_per_annum' => str_replace(',','',$this->input->post('Desiredincome_per_annum')),
						'Other_sources_of_income' => $this->input->post('Other_sources_of_income'),
					));
					$parameters['withdrawing_choice'] = $_COOKIE['LandingPageiTem'];
					$parameters['lastlogin'] = $this->UserLastLogin;
					$parameters['contributing_background'] = json_encode(array(
						'Experience_investing' => $this->input->post('Experience_investing'),
						'Knowledge' => $this->input->post('Knowledge'),
						'Investment_decision_maker' => $this->input->post('Investment_decision_maker'),
						'Income_per_annum' => $PlantingTransparencyInfo->Income_per_annum,
						'Contributions_per_annum' => $PlantingTransparencyInfo->Contributions_per_annum,
						'Contributions_percentage' => $PlantingTransparencyInfo->Contributions_percentage,
						//'Desiredincome_per_annum' => str_replace(',','',$this->input->post('Desiredincome_per_annum')),
						'Other_sources_of_income' => $this->input->post('Other_sources_of_income')
					));
					$parameters['investing_background'] = json_encode(array(
						'Experience_investing' => $this->input->post('Experience_investing'),
						'Knowledge' => $this->input->post('Knowledge'),
						'Investment_decision_maker' => $this->input->post('Investment_decision_maker'),
						'Income_per_annum' => str_replace(',','',$this->input->post('Income_per_annum')),
						'Contributions_per_annum' => str_replace(',','',$this->input->post('Contributions_per_annum')),
						//'Desiredincome_per_annum' => str_replace(',','',$this->input->post('Desiredincome_per_annum')),
						'Other_sources_of_income' => $this->input->post('Other_sources_of_income')
					));
				}
				if( $type == 'withdrawing_horizon') {
					$parameters['withdrawing_horizon'] = json_encode(array(
						'current_age' => $this->input->post('current_age'),
						'retirerment_age' => $this->input->post('retirerment_age')
					));
				}
				if( $type == 'withdrawing_growth') {
					$parameters['contributing_growth'] = json_encode(array(
						'planting_growth_info' => $this->input->post('planting_growth_info'),
						'planting_growth_label' => $this->input->post('planting_growth_label')		
					));
					$parameters['investing_growth'] = json_encode(array(
						'planting_growth_info' => $this->input->post('planting_growth_info'),
						'planting_growth_label' => $this->input->post('planting_growth_label')		
					));
					$parameters['withdrawing_growth'] = json_encode(array(
						'planting_growth_info' => $this->input->post('planting_growth_info'),
						'planting_growth_label' => $this->input->post('planting_growth_label')	
					));
				}
				if( $type == 'withdrawing_potentialfalls') {
					$parameters['contributing_potentialfalls'] = json_encode(array(
						'planting_potentialfalls_tagline' => $this->input->post('planting_potentialfalls_tagline'),
						'planting_potentialfalls_info' => $this->input->post('planting_potentialfalls_info'),
						'planting_potentialfalls_label' => $this->input->post('planting_potentialfalls_label')
					));
					$parameters['investing_potentialfalls'] = json_encode(array(
						'planting_potentialfalls_tagline' => $this->input->post('planting_potentialfalls_tagline'),
						'planting_potentialfalls_info' => $this->input->post('planting_potentialfalls_info'),
						'planting_potentialfalls_label' => $this->input->post('planting_potentialfalls_label')
					));
					$parameters['withdrawing_potentialfalls'] = json_encode(array(
						'planting_potentialfalls_tagline' => $this->input->post('planting_potentialfalls_tagline'),
						'planting_potentialfalls_info' => $this->input->post('planting_potentialfalls_info'),
						'planting_potentialfalls_label' => $this->input->post('planting_potentialfalls_label')
					));
				}
				if( $type == 'withdrawing_missing_out') {
					$parameters['contributing_missing_out'] = json_encode(array(
						'planting_regret_info' => $this->input->post('planting_regret_info'),
						'planting_regret_label' => $this->input->post('planting_regret_label')
					));
					$parameters['investing_missing_out'] = json_encode(array(
						'planting_regret_info' => $this->input->post('planting_regret_info'),
						'planting_regret_label' => $this->input->post('planting_regret_label')
					));
					$parameters['withdrawing_missing_out'] = json_encode(array(
						'planting_regret_info' => $this->input->post('planting_regret_info'),
						'planting_regret_label' => $this->input->post('planting_regret_label')
					));
				}
				if( $type == 'withdrawing_liquidity') {
					$parameters['contributing_liquidity'] = json_encode(array(
						'withdraw_percentage' => $this->input->post('withdraw_percentage'),
					));
					$parameters['withdrawing_liquidity'] = json_encode(array(
						'withdraw_percentage' => $this->input->post('withdraw_percentage'),
					));
					$parameters['investing_liquidity'] = json_encode(array(
						'withdraw_percentage' => $this->input->post('withdraw_percentage'),
					));
				}
				if( $type == 'withdrawing_risk') {
					$parameters['withdrawing_risk'] = json_encode(array(
						'risklabel' => $this->input->post('risklabel'),
						'risknumber' => $this->input->post('risknumber')
					));
				}
				//print_r($parameters);
				$info = $this->concerto->getjtcinfo();
				if( !empty($info) ) {
					$this->concerto->UpdateJtcToolnfo($parameters);
					$this->concerto->UpdateJtcToolnfoHistory($parameters);
					$message = "Updated";
				} else {
					$this->concerto->SaveJtcToolnfo($parameters);
					$this->concerto->SaveJtcToolnfoHistory($parameters);
					$message = "Saved";
				}
				if( $type == 'withdrawing_liquidity' && $this->input->post('withdraw_percentage') < 1 ) {
					echo json_encode(array('status'=>true,'openSuccessPopup'=>true,'http_redirect'=>$httpredirect,'message'=>'Please confirm your liquidity needs are 0% to proceed. If not, please click ‘Back’ to update.'));
				} else {
					echo json_encode(array('status'=>true,'http_redirect'=>$httpredirect,'message'=>'Content has been '.$message.' successfully!'));
				}
			}
		}
	}
	public function termandconditions(){
		$data['title']  = 'Term and conditions | '.$this->title;
		$view = $this->template.$this->viewFolder.'termandconditionshtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function faqs(){
		$this->load->model('Faqs_model','faqs');
		$data['title']  = 'Faqs | '.$this->title;
		$data['lists'] = $this->faqs->getFaqCategory();
		$view = $this->template.$this->viewFolder.'faqshtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function faqs_subcategories($catid){
		$this->load->model('Faqs_model','faqs');
		$data['title']  = $catid. ' | '.$this->title;
		$arr = array();
		$mainCatLists = $this->faqs->getFaqCategory();
		 
		foreach ($mainCatLists as $key => $value) {
			$sub_arr = array();
			$sub_arr  = $value;
			$sub_arr->subcategory = $this->faqs->getFaqCategory($value->catid);
			array_push($arr, $sub_arr);
		}
		$data['mainCatLists'] = $arr;
		$data['info'] = $this->faqs->getSingleFaqCategory($catid);
		$data['lists'] = $this->faqs->getFaqCategory($catid);
		$view = $this->template.$this->viewFolder.'faqsubcategoryhtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}
	public function faqs_details($catid){
		$this->load->model('Faqs_model','faqs');
		$subcatid = $this->uri->segment(3);
		$maincatid = $this->uri->segment(2);
		$data['title']  = $catid. ' | '.$this->title;
		$data['subcatname']  = preg_replace('/[0-9]+/', '', $subcatid);
		$data['info'] = $this->faqs->getSingleFaqCategory($catid);
		$data['lists'] = $this->faqs->getallFaqlist($subcatid);
		$data['maincatid'] = $maincatid;
		$view = $this->template.$this->viewFolder.'faqdetailshtml';
		$this->load->view('concertolayouthtml',  array('data'=>$data,'views'=> $view));
	}
	static public function __commaonHeaderText( $fromtype ) {
		$headerLabel = '';
		if($fromtype == 'contributing' && $_COOKIE['LandingPageiTem'] == 'FlexibleIncome') {
			$headerLabel = "I am making contributions to my savings";
		} else if($fromtype == 'contributing' && $_COOKIE['LandingPageiTem'] == 'CashLumpSum') {
			$headerLabel = "I am making contributions to my savings";
		}else if($fromtype == 'contributing' && $_COOKIE['LandingPageiTem'] == 'Annuity') {
			$headerLabel = "I am making contributions to my savings";
		}else if($fromtype == 'contributing' && $_COOKIE['LandingPageiTem'] == 'InvestingforGrowth') {
			$headerLabel = "I am saving to invest for growth";
		}else if($fromtype == 'contributing' && $_COOKIE['LandingPageiTem'] == 'RainyDayFund') {
			$headerLabel = "I am saving for a rainy day";
		} else if($fromtype == 'investing' && $_COOKIE['LandingPageiTem'] == 'FlexibleIncome') {
			$headerLabel = "I am investing to grow my savings";
		} else if($fromtype == 'investing' && $_COOKIE['LandingPageiTem'] == 'CashLumpSum') {
			$headerLabel = "I am investing to grow my savings";
		} else if($fromtype == 'investing' && $_COOKIE['LandingPageiTem'] == 'Annuity') {
			$headerLabel = "I am investing to grow my savings";
		}else if($fromtype == 'investing' && $_COOKIE['LandingPageiTem'] == 'InvestingforGrowth') {
			$headerLabel = "I am investing to grow my savings";
		} else if($fromtype == 'investing' && $_COOKIE['LandingPageiTem'] == 'RainyDayFund') {
			$headerLabel = "I am investing to grow my savings";
		} else if($fromtype == 'withdrawing' && $_COOKIE['LandingPageiTem'] == 'FlexibleIncome') {
			$headerLabel = "I am withdrawing my money from my savings";
		} else if($fromtype == 'withdrawing' && $_COOKIE['LandingPageiTem'] == 'CashLumpSum') {
			$headerLabel = "I am withdrawing my money from my savings";
		} else if($fromtype == 'withdrawing' && $_COOKIE['LandingPageiTem'] == 'Annuity') {
			$headerLabel = "I am withdrawing my money from my savings";
		}
		return $headerLabel;
	}
}
?>