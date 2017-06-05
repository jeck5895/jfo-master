<?php

	if(!session_id()){
		session_start();
	}

	require_once("Facebook/autoload.php");



	class FacebookSDK{

		protected $fb;
		protected $helper;

		public function __construct(){

			$this->fb = new Facebook\Facebook([
				  'app_id' => '938590269606353',
				  'app_secret' => '711263b0d142774794d0b10e443914ce',
				  'default_graph_version' => 'v2.5',
				]);
			$this->helper = $this->fb->getRedirectLoginHelper();
			
		}

		function getLoginUrl($callback_url){
			
			$permissions = ['email']; // optional
			$loginUrl = $this->helper->getLoginUrl($callback_url, $permissions);
			return $loginUrl;
		}


		function getAccessToken(){
			try {
			  $accessToken = $this->helper->getAccessToken();
			  return $accessToken;
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
			  // When Graph returns an error
			  echo 'Graph returned an error: ' . $e->getMessage();
			  exit;
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
			  // When validation fails or other local issues
			  echo 'Facebook SDK returned an error: ' . $e->getMessage();
			  exit;
			}
		}


		function getUserData($access_token){
			$this->fb->setDefaultAccessToken($access_token);

			try {
			  $response = $this->fb->get('/me?fields=id,first_name,last_name,email,gender,locale,picture.width(400).height(400)');
			  $userNode = $response->getGraphUser();
			  return $userNode;
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
			  // When Graph returns an error
			  echo 'Graph returned an error: ' . $e->getMessage();
			  exit;
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
			  // When validation fails or other local issues
			  echo 'Facebook SDK returned an error: ' . $e->getMessage();
			  exit;
			}

		}


	}