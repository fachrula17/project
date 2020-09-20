<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

#rest client
$route['users']['GET'] = 'REST/AuthController/index';
$route['users/(:num)']['GET'] = 'REST/AuthController/show/$1';
$route['users/delete/(:num)']['GET'] = 'REST/AuthController/delete/$1';

$route['users/login']['GET'] = 'REST/AuthController/login';
$route['login']['POST'] = 'REST/AuthController/isLogin';
$route['users/register']['GET'] = 'REST/AuthController/register';

#rest server
$route['change-password'] = 'Admin/changePassword';
$route['api/change-password/(:num)']['PUT'] = 'REST/UserController/adminUpdate/$1';
$route['api/users']['GET'] = 'REST/UserController/index';
$route['api/users']['POST'] = 'REST/UserController/store';

$route['api/users/(:num)']['PUT'] = 'REST/UserController/update/$1';
$route['api/users/(:num)']['DELETE'] = 'REST/UserController/delete/$1';

$route['api/users/(:num)']['GET'] = 'REST/UserController/show/$1'; 
$route['api/login']['POST'] = 'REST/UserController/login';
$route['api/check-token']['GET'] = 'REST/UserController/check_token';

$route['api/event']['GET'] = 'REST/EventController/index';
$route['api/event-member']['GET'] = 'REST/EventController/show';
$route['api/event-member/(:any)']['GET'] = 'REST/EventController/sorting/$1';
$route['api/event-member/(:any)']['POST'] = 'REST/EventController/search/$1';
$route['api/event']['POST'] = 'REST/EventController/store';
$route['api/event/(:num)']['GET'] = 'REST/EventController/show/$1';
$route['api/event/(:num)']['PUT'] = 'REST/EventController/update/$1';
$route['api/event']['DELETE'] = 'REST/EventController/delete-event';

$route['api/member']['GET'] = 'REST/MemberController/index';
$route['api/member/verify']['GET'] = 'REST/MemberController/verify';
$route['api/member']['POST'] = 'REST/MemberController/store';
$route['api/get-member']['GET'] = 'REST/MemberController/show';
$route['api/get-member-admin']['GET'] = 'REST/MemberController/show_admin';
$route['api/member-login']['POST'] = 'REST/MemberController/login';
$route['api/update-status/(:num)']['POST'] = 'REST/MemberController/updateStatus/$1';
$route['api/reset-password']['POST'] = 'REST/MemberController/forgotPassword';
$route['api/confirm-password'] = 'Home/changePassword';
$route['api/change-password']['POST'] = 'REST/MemberController/changePassword';
$route['api/deposit']['GET'] = 'REST/DepositController/index';
$route['api/member-deposit/(:num)']['GET'] = 'REST/DepositController/member/$1';
$route['api/member-order/(:num)']['GET'] = 'REST/OrderController/member/$1';
$route['api/member/(:num)']['PUT'] = 'REST/MemberController/update/$1';
$route['api/member']['DELETE'] = 'REST/MemberController/delete';
$route['api/deposit/(:num)']['GET'] = 'REST/DepositController/confirm/$1';
$route['api/deposit']['DELETE'] = 'REST/DepositController/delete';
$route['api/order']['POST'] = 'REST/OrderController/order';
$route['api/order']['DELETE'] = 'REST/OrderController/delete';
$route['api/member-order']['GET'] = 'REST/OrderController/index';
$route['api/confirm-order/(:num)']['GET'] = 'REST/OrderController/confirm/$1';
$route['api/confirm-event/(:num)']['GET'] = 'REST/EventController/confirm/$1';
$route['api/list-audience/(:num)']['GET'] = 'REST/EventController/list/$1';
$route['api/list-audience/(:num)']['DELETE'] = 'REST/EventController/list-delete/$1';
$route['api/topup']['POST'] = 'REST/MemberController/topup';
$route['api/check-register']['POST'] = 'REST/EventController/check';

$route['order/(:num)'] = 'Home/detail/$1';
$route['deposit'] = 'Home/deposit';
$route['profile'] = 'Home/profile';
$route['edit-profile'] = 'Home/editProfile';
$route['deposit/show'] = 'Admin/show';
$route['order/show'] = 'Admin/order';
$route['event/listing/(:num)'] = 'Admin/listAudience/$1';
$route['history-deposit'] = 'Home/history_deposit';
$route['history-order'] = 'Home/history_order';
$route['e-ticket/(:any)'] = 'Event/printTicket/$1';

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;