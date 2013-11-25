<?php

class home extends MY_Controller
{
	function __construct() 
	{
		parent::__construct();
	}

	function index() 
	{
		$template_data = new TemplateData();
		$template_data->page_layout = 'no_sidebar';
		$template_data->template_part = 'home/index';

		$this->load->view('template/index', $template_data);
	}

}