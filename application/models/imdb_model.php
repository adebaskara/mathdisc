<?php

class imdb_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function add($data) {
		if (!$this->isExist($data->imdbID)) 
		{
			$this->db->insert('imdb', $data);
			return true;
		}
		else
		{
			return false;
		}
	}

	function isExist($imdbID) {
		$query = $this->db->get_where('imdb', array('imdbID' => $imdbID));
		return $query->num_rows() > 0;
	}

}