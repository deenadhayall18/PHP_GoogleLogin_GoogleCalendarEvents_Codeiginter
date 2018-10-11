<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'GoogleCalendarApi';
$route['404_override'] = 'Welcome/pagenotfound';
$route['translate_uri_dashes'] = FALSE;

$route['google-login'] = 'GoogleCalendarApi/index';
$route['success'] = 'GoogleCalendarApi/GetEventdata';
$route['logout'] = 'GoogleCalendarApi/logout';