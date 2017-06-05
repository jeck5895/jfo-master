<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Googleplus {
	
	public function __construct() {
		
		$CI =& get_instance();

		$CI->load->database();

		$CI->load->model('Settings_model');

		$CI->config->load('googleplus');
	
		
		require APPPATH .'third_party/google-login-api/apiClient.php';
		require APPPATH .'third_party/google-login-api/contrib/apiOauth2Service.php';
		
		$this->client = new apiClient();

		//// get setting from database
		
		$this->client->setApplicationName($CI->Settings_model->get_settings('google_application_name'));

		$this->client->setClientId($CI->Settings_model->get_settings('google_client_id'));

		$this->client->setClientSecret($CI->Settings_model->get_settings('google_client_secret'));

		$this->client->setRedirectUri($CI->Settings_model->get_settings('google_redirect_uri'));

		$this->client->setDeveloperKey($CI->Settings_model->get_settings('google_api_key'));

		$this->client->setScopes($arrayName = array());

		$this->client->setAccessType('online');

		$this->client->setApprovalPrompt('auto');

		$this->oauth2 = new apiOauth2Service($this->client);

	}

	
	public function loginURL() {
        return $this->client->createAuthUrl();
    }
	
	public function getAuthenticate() {
        return $this->client->authenticate();
    }
	
	public function getAccessToken() {
        return $this->client->getAccessToken();
    }
	
	public function setAccessToken() {
        return $this->client->setAccessToken();
    }
	
	public function revokeToken() {
        return $this->client->revokeToken();
    }
	
	public function getUserInfo() {
        return $this->oauth2->userinfo->get();
    }
	
}
?>