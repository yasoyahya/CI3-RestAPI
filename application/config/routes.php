<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Restful API Paket
$route['paket'] = 'api/PaketController/index';

// Restful API User
$route['user'] = 'api/UserController/index';

// Auth
$route['login'] = 'auth/LoginController/index';


// Referensi
$route['api'] = 'api/ApiController/users';
