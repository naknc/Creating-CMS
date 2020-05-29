<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI TING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/ing.html
|
| -------------------------------------------------------------------------
| RESERVED 
| -------------------------------------------------------------------------
|
| There are three reserved :
|
|	$e['default_controller'] = 'welcome';
|
| This e indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$e['404_override'] = 'errors/page_missing';
|
| This e will tell the ter which controller/method to use if those
| provided in the URL cannot be matched to a valid e.
|
|	$e['translate_uri_dashes'] = FALSE;
|
| This is not exactly a e, but allows you to automatically e
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route["login"] = "userop/login";
$route["logout"] = "userop/logout";