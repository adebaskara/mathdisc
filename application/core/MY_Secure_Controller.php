<?php

class MY_Secure_Controller extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->is_login())
        {
            redirect(base_url('login'));
        }
    }
}
