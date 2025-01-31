<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
	
require (ENVIRONMENT == 'development' ? 'C:\laragon\www\vendor\autoload.php' : 'C:\Program Files\PHP\PHPMailer\vendor\autoload.php');

if(!function_exists('assets_url')) {
    function assets_url($path = '') {
        $return_url = base_url('assets/');
        if(strlen($path) > 0) {
            $return_url .= $path;
        }
        return $return_url;
    }
} 
if(!function_exists('website_url')) {
    function website_url($path = '') {
        $return_url = base_url($path);
        return $return_url;
    }
}
if(!function_exists('userinfo')) {
    function userinfo() {
        $result = array();
		$instance =& get_instance();
		$result = $instance->auth->getuserinfo($instance->userid);
        return $result;
    }
}
if(!function_exists('getorganisation_logo')) {
	function getorganisation_logo() {
		$instance =& get_instance();
		$result = $instance->auth->getorganisationinfo($instance->organisation);
		if( $result->Logo != '') {
		 	$path =  assets_url('uploads'. DIRECTORY_SEPARATOR .'organisation' . DIRECTORY_SEPARATOR . $result->Logo);
		} else {
			$path =  assets_url('pix'. DIRECTORY_SEPARATOR .'DFM-Financial-Projector_b.svg');
		}
		return $path;
	}
}
if(!function_exists('getprofile_image')) {
	function getprofile_image( $profile_pic = NULL ) {
		if( !empty( $profile_pic) ) {
			$path =  'uploads'. DIRECTORY_SEPARATOR .$profile_pic;
			$path =  assets_url('uploads'. DIRECTORY_SEPARATOR . $profile_pic);
		} else {
			$path =  assets_url('pix'. DIRECTORY_SEPARATOR .'profile_blank.png');
		}
		return $path;
	}
}

if(!function_exists('applists')) {
    function applists( $selected = NULL){
        $AppaccessInfo = array();
        $instance =& get_instance();
        $AppaccessInfo = $instance->auth->getappaccessinfo($instance->organisation);
        return $AppaccessInfo;
    }
}
if(!function_exists('getLastLoginInfo')) {
    function getLastLoginInfo() {
        $result = array();
		$instance =& get_instance();
		$result = $instance->auth->getLastLoginInfo($instance->userid);
        return $result;
    }
}
if(!function_exists('HasAppMenuAccess')) {
    function HasAppMenuAccess($menuname, $buttonname = NULL) {
        $class = '';
		$instance =& get_instance();
		$result = $instance->teams->ShowMenuAspeRrole($instance->userinfo->roleid, $menuname, $buttonname);
		if( empty($result) && $instance->userinfo->rolename !== 'Owner') {
			$class = 'cannot_access_menu';
		}
        return $class;
    }
}
if(!function_exists('getActionAppLabel')) {
    function getActionAppLabel($ActionLabels, $button) {
		$return = false;
		//if (strpos($ActionLabels, $button) !== false) {
		if (is_string($ActionLabels) && strpos($ActionLabels, $button) !== false) {

			$return = true;
		}
		return $return;
    }
}

if(!function_exists('AppRoleslist')) {
    function AppRoleslist($roleid = NULL ) {
        $result = array();
		$CI =& get_instance();
		$roles = $CI->teams->getroles_dropdown();
        return form_dropdown('roleid',array(''=>'Choose role')+$roles,$roleid,'class="uk-input"');
    }
}

if(!function_exists('IsMobileBrowser')) {
    function IsMobileBrowser() {
		$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
		$mobile_agents = [
			'android', 'bb', 'meego', 'avantgo', 'bada', 'blackberry', 'blazer', 'compal', 'elaine', 
			'fennec', 'hiptop', 'iemobile', 'iphone', 'ipod', 'iris', 'kindle', 'lge', 'maemo', 'midp', 
			'mmp', 'netfront', 'opera mobi', 'opera mini', 'palm', 'phone', 'pocket', 'psp', 'symbian', 
			'treo', 'up.browser', 'up.link', 'vodafone', 'wap', 'windows ce', 'windows phone', 'xda', 'xiino'
		];
		if (strpos($useragent, 'firefox') !== false && strpos($useragent, 'mobile') !== false) {
			return true;
		}
		if (strpos($useragent, 'safari') !== false && strpos($useragent, 'mobile') !== false) {
			return true;
		}
		foreach ($mobile_agents as $agent) {
			if (strpos($useragent, $agent) !== false) {
				return true;
			}
		}
		if (preg_match('/opera mini/i', $useragent)) {
			return true;
		}
		return false;
	}
}
if(!function_exists('doreyjtcSteps')) {
    function doreyjtcSteps( $currentpage = 'background' ){
		$result = array();
		$instance =& get_instance();
		$results = $instance->concerto->getdoretsteps();
		$ActiveMethods = explode('_',$instance->method);
		$info = $instance->concerto->getjtcinfo();
		$html = '<ul  class="uk-child-width-expand commonnavigationjtc '.($currentpage == 'risk' ? ' uk-margin-remove-bottom': '').'" uk-tab>';
		foreach( $results as $result ) {
			$menutype = $result->type;
			$pathway = $ActiveMethods[0].'_'.$menutype;
			$urlname = $ActiveMethods[0].'-'.$result->urlname;
			$rows  = json_decode($info->$pathway);
			if( $currentpage == $result->type ) {
				$html .=   '<li class="uk-active ukactiveclass ' . (!empty($rows) ? 'uk-lablefilled' : '') . '"><a onClick="window.location=\'' . website_url($instance->controller.'/'.$urlname) . '\'">'.($result->type != 'risk' ? $result->step.'.' :'').$result->name.' '.($result->tooltip == '' ? '': ' <i uk-icon="icon: question; ratio: .6" uk-tooltip="title:'.$result->tooltip.'; delay:500"></i>').'</a> </li>';
			} else {
				
				if(!empty($rows) ) {
					$html .= '<li class="bottom uk-visible@m ' . (!empty($rows) ? 'uk-lablefilled' : '') . '"> <a onClick="window.location=\'' . website_url($instance->controller.'/'.$urlname) . '\'">' . ($result->type != 'risk' ? $result->step.'.' :'') . $result->name . '</a>';
				} else {
					$html .= '<li class="uk-disabled uk-visible@m"> <a>' . ($result->type != 'risk' ? $result->step.'.' :'') . $result->name . '</a>';
				}
			}
		} 
		$html .= '</ul>';
		return $html;
    }
}
if(!function_exists('thumbnail_path')) {
    function thumbnail_path($path = '') {
        if(strlen($path) > 0) {
            $return_url = base_url('assets/uploads/'.$path);
        } else {
			$return_url = assets_url('pix/icon-user.png');
		}
        return $return_url;
    }
}
if(!function_exists('defaultdate')) {
	function defaultdate( $date = NULL, $time = NULL ) {
		if( !empty($date) ) {
			if( !empty($time) ) {
				return date('d M, Y H:i A',strtotime($date));
			} else {
				return date('d M, Y',strtotime($date));
			}
		} else {
			return date('d M, Y');
		}
	}
}

if(!function_exists('uploads_path')) {
    function uploads_path($path = '') {
        $return_url = base_url('assets/uploads/');
        if(strlen($path) > 0) {
            $return_url .= $path;
        }
        return $return_url;
    }
}
if(!function_exists('generate_otop')) {
	function generate_otop(){
		$otp_number = '';
		for ($p = 0; $p < 6; $p++) {
			$otp_number .= mt_rand(1,9);
		}
		$ExpireDateTime = date("Y-m-d H:i:s", strtotime('+15 minute'));
		return array(
			'otp_number' => $otp_number,
			'expiredatetime' => $ExpireDateTime,
		);
	}
}
if(!function_exists('encryptKey')) {
	function encryptKey($string) {
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$secret_key = 'SIGNITYPRODUCT';
		$secret_iv = 'XXXMMMMPPPTTT';
		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
		$output = base64_encode($output);
		return $output;
	}
}
if(!function_exists('decryptKey')) {
	function decryptKey($string) {
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$secret_key = 'SIGNITYPRODUCT';
		$secret_iv = 'XXXMMMMPPPTTT';
		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		return $output;
	}
}

if (!function_exists('sendemail')) {
    function sendemail($recipient, $subject, $emailbody, $supportemail = true, $bccEmail = NULL ) {
		// $message = common_email_template($emailbody);
		// $mail = new PHPMailer(true);
		// $mail->isSMTP();
		// $mail->Host = SMTP_HOST;
		// $mail->Port = SMTP_PORT;
		// $mail->SMTPSecure = SMTP_SECURE;
		// $mail->SMTPAuth   = true;
		// $mail->Username = SMTP_USER;
		// $mail->Password = SMTP_PASS;
		// $mail->SetFrom(SMTP_USER, 'Financial Projector');
		// $mail->addAddress($recipient);
		
		// if( !empty($supportemail)) {
		// 	$mail->AddCC(SUPPORT_EMAIL);
		// }
		// if( !empty($bccEmail)) {
		// 	$mail->addBcc($bccEmail);
		// }
		// $mail->Smtpdebug  = 0;
		// $mail->Subject = $subject;
		// $mail->Body  = ($message);
		// $mail->Debugoutput = function($str, $level) {echo "debug level $level; message: $str";}; 
		// $mail->Debugoutput = 'echo';
		// $mail->IsHTML(true);
		// $mail->send();
		return true;
    }
}
if (!function_exists('CheckPasswordStrength')) {
	function CheckPasswordStrength($pwd) {
		$error = '';
		if( strlen($pwd) < 8 ) {
			$error .= "<p>Password too short</p>";
		}
		if( strlen($pwd) > 20 ) {
			$error .= "<p>Password too long</p>";
		}
		if( !preg_match("#[0-9]+#", $pwd) ) {
			$error .= "<p>Password must include at least one number</p>";
		}
		if( !preg_match("#[a-z]+#", $pwd) ) {
			$error .= "<p>Password must include at least one letter</p>";
		}
		if( !preg_match("#[A-Z]+#", $pwd) ) {
			$error .= "<p>Password must include at least one capital letter</p>";
		}
		if( !preg_match("#\W+#", $pwd) ) {
			$error .= "<p>Password must include at least one special symbol</p>";
		}  
		return $error;
	}
}
if (!function_exists('__SendBulkEmail')) {
    function __SendBulkEmail($recipients, $subject, $message, $bccEmail = NULL ) {
		$logopath = assets_url('pix/email-logo.png');
		$signature = "
		<p><br/><br/>Kind regards,</p>
		<p><img src='".$logopath."' alt='Financial Projector' width='200px'></p>
		<p><a href='".website_url()."'>Privacy</a> | <a href='".website_url()."'>Help</a> | <a href='".website_url()."'>Contact</a></p>
		<p>Contact: ".SUPPORT_EMAIL."</p>";
		
		$mail = new PHPMailer(true);
		$mail->isSMTP();
		$mail->Host = SMTP_HOST;
		$mail->Port = SMTP_PORT;
		$mail->SMTPSecure = SMTP_SECURE;
		$mail->SMTPAuth   = true;
		$mail->Username = SMTP_USER;
		$mail->Password = SMTP_PASS;
		$mail->SetFrom(SMTP_USER, 'Financial Projector');
		foreach ($recipients as $recipient) {
			$mail->addAddress(trim($recipient));
		}
		if( !empty($bccEmail)) {
			$mail->addBcc($bccEmail);
		}
		$mail->Smtpdebug  = 0;
		$mail->Subject = $subject;
		$mail->Body  = ($message.$signature);
		$mail->Debugoutput = function($str, $level) {echo "debug level $level; message: $str";}; 
		$mail->Debugoutput = 'echo';
		$mail->IsHTML(true);
		$mail->send();
    }
}
if (!function_exists('convertMWArrayHelper')) {
	function convertMWArrayHelper($mxArrayIn){
		$vecSize = $mxArrayIn->mwsize;
		$mxOutput = array();
		$nRow = $vecSize[0];
		$nCol = $vecSize[1];
		for ($iRow=0;$iRow<$nRow;$iRow++){
			$mxOutput[$iRow] = [];
		}
		for ($iCol=0;$iCol<$nCol;$iCol++){
			for ($iRow=0;$iRow<$nRow;$iRow++){
				$mxOutput[$iRow][$iCol]=($mxArrayIn->mwdata[$iCol*($nRow)+$iRow]);
			}
		}
		return array(
			'mxOutput'=>$mxOutput,
			'vecSize'=>$vecSize
		);
	}
}
if (!function_exists('common_email_template')) {
	function common_email_template( $email_body ) {
		//$logopath = assets_url('pix/email-logo.png');
		$logopath = "https://dfmportal1.com/financialprojector/assets/pix/email-logo.png";
		$outerHtml = '<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="x-apple-disable-message-reformatting">
  <title></title>
  <!--[if mso]>
  <noscript>
    <xml>
      <o:OfficeDocumentSettings>
        <o:PixelsPerInch>96</o:PixelsPerInch>
      </o:OfficeDocumentSettings>
    </xml>
  </noscript>
  <![endif]-->
  <style>
    table, td, div, h1, p {font-family: Arial, sans-serif;}
  </style>
</head>
<body style="margin:0;padding:0;">
  <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
    <tr>
      <td align="center" style="padding:0;">
        <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
          <tr>
            <td align="center" style="padding:40px 0 30px 0;background:#425363;">
              <img src="'.$logopath.'" alt="" width="300" style="height:auto;display:block;" />
            </td>
          </tr>
          <tr>
            <td style="padding:36px 30px 42px 30px;">
              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                <tr>
                  <td style="padding:0 0 36px 0;color:#153643;">
					<div style="margin:0 0 12px 0;font-size:14px;line-height:24px;font-family:Arial,sans-serif;">
						'.$email_body.'
					</div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td style="padding:30px;background:#425363;">
              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                <tr>
                  <td style="padding:0;width:50%;" align="left">
                    <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
					Replies to this email are not monitored. This email was sent to you because you contacted us via the Financial Projector website. If you believe this was an error,<br/><br/> please contact <a href="'.SUPPORT_EMAIL.'" style="color:#ffffff;text-decoration:underline;">'.SUPPORT_EMAIL.'</a> immediately.<br/><br/>
					  <a href="'.website_url('privacy-policy').'" style="color:#ffffff;text-decoration:underline;">Privacy</a> | 
					  <a href="'.website_url().'" style="color:#ffffff;text-decoration:underline;">Help</a> | 
					  <a href="'.website_url().'" style="color:#ffffff;text-decoration:underline;">Contact</a>
                    </p>
					<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
					<br/>Help: new help page to be created and uploaded to <a href="'.website_url().'" style="color:#ffffff;text-decoration:underline;">'.website_url().'</a></p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>';
	return $outerHtml;
	}
}

















if(!function_exists('SeoUrlTitle')) {
    function SeoUrlTitle($path = '') {
		$instance =& get_instance();
        $url_title = website_url(strtolower($instance->router->fetch_class()).'/'.url_title($path,'dash',true));
        return $url_title;
    }
}
if(!function_exists('doreyjtcStepsmobilemenus')) {
    function doreyjtcStepsmobilemenus( $currentpage = 'background' ){
		$row = array();
		$instance =& get_instance();
		$ActiveMethods = explode('_',$instance->method);
		$instance->load->model('Jtctools_model','Jtctools');
		
		$results = $instance->Jtctools->getdoretsteps('',true);	
		$info = $instance->Jtctools->getjtcinfo();
		$ActviveMenu = '';
		$html = ' <ul  class="uk-child-width-expand" uk-tab>';
		$html .= '<li class="uk-active">';
		$html .= '<span class="uk-position-center-left uk-hidden@s atr-progress" style="padding-left: 20px; cursor: pointer"  uk-toggle="target: #offcanvas-nav-mobile">';
		foreach( $results as $rowInfo ) {
			$pathway = $ActiveMethods[0].'_'.$rowInfo->type;
			$urlname = $ActiveMethods[0].'-'.$rowInfo->urlname;
			$getdata  = json_decode($info->$pathway);
			if(!empty($getdata) ) {
				$html .= '<span class="complete"></span> ';
			} else {
				$html .= '<span></span> ';
			}
		}
		$StepInfo = $instance->Jtctools->getSingledoretstep($currentpage);
		if(!empty($StepInfo) ) {
			$ActviveMenu = '<a onClick="window.location=\'' . website_url($instance->controller.'/'.$ActiveMethods[0].'-'.$StepInfo->urlname) . '\'" style="padding-left: 11%;">' . ($StepInfo->type != 'risk' ? $StepInfo->step.'.' :'') . $StepInfo->name . '<i uk-icon="icon: question; ratio: .6" uk-tooltip="title: '.$StepInfo->tooltip.'; delay: 500"></i></a>';
		}
		//$ActviveMenu = '<a>'.$currentpage.'</a>';

		$html .= '</span>';
		$html .= $ActviveMenu;
		$html .= '</li>';
		$html .= '</ul>';
		
		
		$html .= '
		<div id="offcanvas-nav-mobile" uk-offcanvas="overlay: true">
			<div class="uk-offcanvas-bar">
				<ul class="uk-nav uk-nav-default">
					<li class="uk-nav-header">Progress</li>';
					foreach( $results as $result ) {
						$pathway = $ActiveMethods[0].'_'.$result->type;
						$urlname = $ActiveMethods[0].'-'.$result->urlname;
						$rows  = json_decode($info->$pathway);
						if( $currentpage == $result->type ) {
							$html .= '<li class="uk-active"><a href="javascript:void(0);"><span class="uk-margin-small-right" uk-icon="icon: check"></span>' . $result->step . '. ' . $result->name . '</a></li>';
						} else {
							if(!empty($rows) ) {
								$html .= '<li class="alreadyfilled"><a onClick="window.location=\'' . website_url($instance->controller.'/'.$urlname) . '\'"><span class="uk-margin-small-right" uk-icon="icon: check"></span>' . $result->step . '. ' . $result->name . '</a></li>';
							} else {
								$html .= '<li class="' . (!empty($rows) ? 'uk-lablefilled' : 'uk-disabled ') . '"> <a href="javascript:void(0);"><span class="uk-margin-small-right" style="color: transparent"  uk-icon="icon: minus"></span>' . $result->step . '. ' . $result->name . '</a>';
							}
						}
					}
					$html .= '
					<li class="uk-nav-divider uk-margin-top"></li>
					<li class="uk-nav-header">Results</li>
					<li class="'.(isset($ActiveMethods[1]) && $ActiveMethods[1] == 'risk' ? 'uk-active' : '').'"><a onClick="window.location=\'' . website_url($instance->controller.'/'.$ActiveMethods[0].'-risk') . '\'"><span class="uk-margin-small-right" uk-icon="icon: thumbnails"></span> Risk</a></li>
					<li class="'.(isset($ActiveMethods[1]) && $ActiveMethods[1] == 'results' ? 'uk-active' : '').'"><a onClick="window.location=\'' . website_url($instance->controller.'/'.$ActiveMethods[0].'-results') . '\'"><span class="uk-margin-small-right" uk-icon="icon: check "></span> Projections</a></li>
				</ul>
			</div>
		</div>';
		return $html;
    }
}
