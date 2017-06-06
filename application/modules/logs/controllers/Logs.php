<?php
	class Logs extends MY_Controller{

		public function __construct()
		{
			parent::__construct();
			$this->load->model('Log_model','log_model');
		}
	}