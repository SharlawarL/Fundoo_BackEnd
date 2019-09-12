<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'User';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//for user request
$route['login'] = 'User/login';
$route['Register'] = 'User/Register';
$route['Apply_forgot'] = 'User/Apply_forgot';
$route['Reset_password'] = 'User/Reset_password';
$route['check_reset_token'] = 'User/check_reset_token';


//for notes
$route['CreateNotes'] = 'Notes/CreateNotes';
$route['Get_Notes/(:any)'] = 'Notes/Get_Notes/$1';
$route['Update_Notes'] = 'Notes/Update_Notes';
