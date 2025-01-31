<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['generate-code'] = 'Welcome/refreshCaptchaCode';
$route['generate-password'] = 'welcome/generate_password';
$route['forgot-your-password'] = 'welcome/forgotpassword';

$route['term-and-conditions'] = 'Apps/termandconditions';
$route['concerto-json/(:any)'] = 'ConcertoAjax/$1';
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;
