<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller
{
	public function index()
	{
		$this->load->library('ci_pusher');

		$pusher = $this->ci_pusher->get_pusher();
		$socket = $_POST['socket_id'];
		$channel = $_POST['channel_name'];

		$auth = $pusher->socket_auth($channel, $socket);

		echo $auth;
	}	

}
