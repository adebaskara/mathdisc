<?php

class session_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
        $this->secret_key = 'bdl';
	}

	function is_limit_login_trial()
	{
		if ($this->session->userdata('login_trial'))
		{
			if ($this->session->userdata('login_trial') >= 10)
			{
				return true;
			}
		}
		return false;
	}

	function add_login_trial()
	{
		if ($this->session->userdata('login_trial'))
		{
			$login_trial = $this->session->userdata('login_trial') + 1;
			$this->session->set_userdata('login_trial', $login_trial);
		}
		else
		{
			$this->session->set_userdata('login_trial', 1);
		}
	}

	function get_login_trial()
	{
		if ($this->session->userdata('login_trial'))
		{
			return $this->session->userdata('login_trial');
		}
		else
		{
			return 0;
		}
	}

	function login($userID, $password)
	{
		$this->db->where('userid', $userID);
		$this->db->where('password', md5($password));
		$query = $this->db->get('password');
		if ($query->num_rows() > 0)
		{
			$this->session->sess_create();
			$this->session->set_userdata('userID', $userID);
			$this->session->set_userdata('secret_key', $this->secret_key);
			return true;
		}
		else
		{
			$this->add_login_trial();
			return false;
		}
	}

	function logout()
	{
		return $this->session->sess_destroy();
	}

	function is_login()
	{
		if ($this->session->userdata('userID') && $this->session->userdata('secret_key'))
		{
			if ($this->session->userdata('secret_key') == $this->secret_key)
			{
				return true;
			}
		}
		return false;
	}

	function get_fullname()
	{
		$this->db->select('fullname');
		$this->db->where('userid', $this->session->userdata('userID'));
		$query = $this->db->get('user');
		if ($query->num_rows() > 0)
		{
			return $query->first_row()->fullname;
		}
		return null;
	}

	function get_userid()
	{
		return $this->session->userdata('userID');
	}
}

?>