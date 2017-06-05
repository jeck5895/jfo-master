<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Google {

   public function __construct() {
      // Do something with $params
   }

   public function create_client(){
      $CI =& get_instance();
      //$CI->load->config('sri_config', TRUE);
      //$sri_config = $CI->config->item('sri_config');
      
      //load settings
      $CI->load->model('settings_model');
      
      // Include two files from google-php-client library in controller
      include_once APPPATH . "libraries/google-api-php-client-master/src/Google/Client.php";
      include_once APPPATH . "libraries/google-api-php-client-master/src/Google/Service/Oauth2.php";

      // Store values in variables from project created in Google Developer Console
      /*
      $client_id = $sri_config['google_client_id'];
      $client_secret = $sri_config['google_client_secret'];
      $redirect_uri = $sri_config['google_redirect_uri'];
      $simple_api_key = $sri_config['google_api_key'];
       * */
      $client_id = $CI->settings_model->get_settings('google_client_id');
      $client_secret = $CI->settings_model->get_settings('google_client_secret');
      $redirect_uri = $CI->settings_model->get_settings('google_redirect_uri');
      $simple_api_key = $CI->settings_model->get_settings('google_api_key');

      // Create Client Request to access Google API
      $client = new Google_Client();
      $client->setApplicationName("PHP Google OAuth Login Example");
      $client->setClientId($client_id);
      $client->setClientSecret($client_secret);
      $client->setRedirectUri($redirect_uri);
      $client->setDeveloperKey($simple_api_key);
      //next two line added to obtain refresh_token
      //$client->setAccessType('offline');
      //$client->setApprovalPrompt('force');
      $client->addScope("https://www.googleapis.com/auth/userinfo.email");
      
      return $client;
   }
   
   public function get_token_expiration($param) {
    //https://www.googleapis.com/oauth2/v1/tokeninfo?access_token=  
   }
}
