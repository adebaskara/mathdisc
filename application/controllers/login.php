<?php

class login extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $redirect_url = '';

        $status = $this->session_model->is_login();

        $template_data = new TemplateData();
        $template_data->page_layout = "no_sidebar";
        $template_data->template_part = 'login/index';
        $template_data->scripts = array('login');
        $this->load->library('form_validation');

        if (!$status)
        {
            $this->form_validation->set_rules('userID', 'User ID', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_message('required', '%s belum diisi');
            
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                if (!$this->input->is_ajax_request())
                {
                    $userID = $this->input->post('userID');
                    $password = $this->input->post('password');

                    if ($this->form_validation->run() == TRUE)
                    {
                        $status = $this->session_model->login($userID, $password);
                        if ($status)
                        {
                            redirect(base_url($redirect_url));
                        }
                        else
                        {
                            $data = new stdClass();
                            $data->message = 'User ID atau Password yang Anda masukkan tidak benar!';

                            $template_data->data = $data;

                            $this->load->view('template/index', $template_data);
                        }
                    }
                    else
                    {
                        $this->form_validation->set_error_delimiters('', '<br />');

                        $data = new stdClass();
                        $data->message = validation_errors();

                        $template_data->data = $data;

                        $this->load->view('template/index', $template_data);
                    }
                }
                else // rekues ajax
                {
                    $this->form_validation->set_error_delimiters('', '');

                    $userID = $this->input->post('userID');
                    $password = $this->input->post('password');

                    $json = new stdClass();
                    if ($this->form_validation->run() == TRUE)
                    {
                        $status = $this->session_model->login($userID, $password);

                        if ($status)
                        {
                            $json->success = true;
                            $json->redirect = base_url($redirect_url);
                        }
                        else
                        {
                            $json->success = false;
                            $json->message = 'User ID atau Password yang Anda masukkan tidak benar!';
                        }
                    }
                    else
                    {
                        $json->message = validation_errors();
                    }
                    echo json_encode($json);
                    exit;
                }
            }
            else // get biasa
            {
                $this->load->view('template/index', $template_data);
            }
        }
        else // sudah login
        {
            redirect(base_url($redirect_url));
        }
    }
}

?>