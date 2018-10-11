<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GoogleCalendarApi extends CI_Controller {

	public function __construct(){
		parent :: __construct();
		$this->load->library("form_validation");
		$this->load->helper(array('form', 'url')); 
		$this->load->model("Events_model"); //to load model
		$this->load->library('session');
		$this->load->library('upload');		
		define('client_id', '452534868234-luf6g1pv56ldub4k8l5idodjb27u82ch.apps.googleusercontent.com');
		define('client_secret_id', 'AYCYcck4osoPq8pum5MV6uEI');
		define('client_redirect_url', 'http://localhost/kohana_crud/google-login');
	}
	function GetAccessToken($client_id, $redirect_uri, $client_secret, $code) {	
		$url = 'https://accounts.google.com/o/oauth2/token';			

		$curlPost = 'client_id=' . $client_id . '&redirect_uri=' . $redirect_uri . '&client_secret=' . $client_secret . '&code='. $code . '&grant_type=authorization_code';
		$ch = curl_init();		
		curl_setopt($ch, CURLOPT_URL, $url);		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);		
		curl_setopt($ch, CURLOPT_POST, 1);		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);	
		$data = json_decode(curl_exec($ch), true);
		$http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);		
		if($http_code != 200) 
			throw new Exception('Error : Failed to get access token');

		return $data;
	}

	function GetUserCalendarTimezone($access_token) {
		$url_settings = 'https://www.googleapis.com/calendar/v3/userinfo';
		$ch = curl_init();		
		curl_setopt($ch, CURLOPT_URL, $url_settings);		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);	
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $access_token));	
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);	
		$data = json_decode(curl_exec($ch), true); 
		$http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);		
		if($http_code != 200) 
			throw new Exception('Error : Failed to get timezone');
		return $data['value'];
	}

	function GetCalendarEventsList($access_token) {
		$url_parameters = array();
		$url_parameters['fields'] = 'items(id,summary,timeZone)';
		$url_parameters['minAccessRole'] = 'writer';
		// $url_parameters['maxResults'] ='100';
		// $url_parameters['showHidden'] = 'true';
		$url_calendars = 'https://www.googleapis.com/calendar/v3/calendars/primary/events';
		$ch = curl_init();		
		curl_setopt($ch, CURLOPT_URL, $url_calendars);		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);	
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $access_token));	
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);	
		$data = json_decode(curl_exec($ch), true); 
		$http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);		
		if($http_code != 200) 
			throw new Exception('Error : Failed to get calendars list');
		return $data['items'];
	}


	public function index(){
		if(($this->input->get('code'))) {
			$data = $this->GetAccessToken(client_id, client_redirect_url, client_secret_id, $this->input->get('code'));
			$this->session->set_userdata("access_token",$data['access_token']);
			redirect('success');
		}
		$this->load->view('google-login');
	}

	public function GetEventdata(){
		$data['events_list'] = $this->GetCalendarEventsList($_SESSION['access_token']);
		$sync  =$this->Events_model->clear_user_events(	$data['events_list'][0]['creator']['email']);
		foreach ($data['events_list'] as $key => $value) {
			if(!empty($value['creator']['email'])){
				$user = $value['creator']['email'];
			}
			$data_to_insert['user'] = $user;
			$data_to_insert['event_id'] = (!empty($value["id"])?$value["id"]:"nil");
			$data_to_insert['summary'] = (!empty($value["summary"])?$value["summary"]:"nil");
			$data_to_insert['status'] = (!empty($value["status"])?$value["status"]:"nil");
			$data_to_insert['created'] = (!empty($value["created"])?$value["created"]:"nil");
			$data_to_insert['updated'] = (!empty(	$value["updated"])?	$value["updated"]:"nil");
			$succ = $this->Events_model->insert_events($data_to_insert);
		}
		$data['dbvalues'] = $this->Events_model->getAllEventsFromDb($user);

		$this->load->view('success',$data);
	}
	public function pagenotfound(){
		$this->load->view('pagenotfound');
	}
	public function logout(){
		session_destroy();
		redirect('google-login');
	}



}
