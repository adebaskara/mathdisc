<?php

class logout extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$this->session_model->logout();
		redirect(base_url());
	}
}
