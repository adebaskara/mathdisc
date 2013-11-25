<?php

class imdb extends MY_Controller
{
	function __construct() 
	{
		parent::__construct();
	}

	function index() 
	{
		$template_data = new TemplateData();
		$template_data->page_layout = 'no_sidebar';
		$template_data->template_part = 'imdb/index';

		$this->load->view('template/index', $template_data);
	}

	function test() {
		$this->load->model('imdb_model');
		$data = new stdClass;
		$data->imdbID = 'tt01330aa';
		$id = $this->imdb_model->add($data);
		var_dump($id);
	}

	function add()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
        	$this->load->model('imdb_model');
        	$this->load->library('form_validation');

        	$this->form_validation->set_rules('Title', 'Title', 'required');
        	$this->form_validation->set_rules('Year', 'Year', 'required');
        	$this->form_validation->set_rules('Rated', 'Rated', 'required');
        	$this->form_validation->set_rules('Released', 'Released', 'required');
        	$this->form_validation->set_rules('Runtime', 'Runtime', 'required');
        	$this->form_validation->set_rules('Genre', 'Genre', 'required');
        	$this->form_validation->set_rules('Director', 'Director', 'required');
        	$this->form_validation->set_rules('Writer', 'Writer', 'required');
        	$this->form_validation->set_rules('Actors', 'Actors', 'required');
        	$this->form_validation->set_rules('Plot', 'Plot', 'required');
        	$this->form_validation->set_rules('Poster', 'Poster', 'required');
        	$this->form_validation->set_rules('imdbRating', 'imdbRating', 'required');
        	$this->form_validation->set_rules('imdbVotes', 'imdbVotes', 'required');
        	$this->form_validation->set_rules('imdbID', 'imdbID', 'required');
        	$this->form_validation->set_rules('Type', 'Type', 'required');
        	$this->form_validation->set_rules('Response', 'Response', 'required');            

            $Title = $this->input->post('Title');
            $Year = $this->input->post('Year');
            $Rated = $this->input->post('Rated');
            $Released = $this->input->post('Released');
            $Runtime = $this->input->post('Runtime');
            $Genre = $this->input->post('Genre');
            $Director = $this->input->post('Director');
            $Writer = $this->input->post('Writer');
            $Actors = $this->input->post('Actors');
            $Plot = $this->input->post('Plot');
            $Poster = $this->input->post('Poster');
            $imdbRating = $this->input->post('imdbRating');
            $imdbVotes = $this->input->post('imdbVotes');
			$imdbID = $this->input->post('imdbID');
            $Type = $this->input->post('Type');
            $Response = $this->input->post('Response');

            $success = false;
            $message = '';
            if ($this->form_validation->run() == TRUE)
    		{
    			$data = new stdClass;
    			$data->title = $Title;
    			$data->year = $Year;
    			$data->rated = $Rated;
    			$data->released = $Released;
    			$data->runtime = $Runtime;
    			$data->genre = $Genre;
    			$data->director = $Director;
    			$data->writer = $Writer;
    			$data->actors = $Actors;
    			$data->plot = $Plot;
    			$data->poster = $Poster;
    			$data->imdbRating = $imdbRating;
    			$data->imdbVotes = $imdbVotes;
    			$data->imdbID = $imdbID;
    			$data->type = $Type;
    			$data->response = $Response;

    			$success = $this->imdb_model->add($data);

    			if ($success) {
    				$message = 'New movie has been successfully saved: "' . $data->title . '"';
    			} else {
    				$message = 'Movie already in database before: "' . $data->title . '"';
    			}
    		}
    		else
    		{
    			
    		}

        	if (!$this->input->is_ajax_request())
        	{
        		if ($success)
        		{
        			
        		}
        		else
        		{
        			
        		}
        	}
        	else // POST ajax request
        	{
        		$json = new stdClass;
        		$json->success = $success;
        		$json->imdbID = $imdbID;
        		$json->message = $message;
        		
        		echo json_encode($json);
        		exit;
        	}
        }
        else // GET
        {
        	if (!$this->input->is_ajax_request())
        	{

        	}
        	else // GET ajax request
        	{

        	}
        }
	}

}