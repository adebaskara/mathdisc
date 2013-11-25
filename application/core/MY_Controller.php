<?php

class MY_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		include (APPPATH . 'libraries/template_data.php');
	}

	function is_login()
	{
		return $this->session_model->is_login();
	}
}