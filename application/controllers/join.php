<?php

class join extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    function index()
    {
    	$template_data = new TemplateData();
        $template_data->page_layout = 'sidebar_right';
        $template_data->sidebar = 'join/sidebar';
        $template_data->template_part = 'join/index';
        $this->load->library('form_validation');

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $nomor_handphone = $this->input->post('nomor_handphone');
            $nik = $this->input->post('nik');
            $kata_sandi = $this->input->post('kata_sandi');
            $nama_lengkap = $this->input->post('nama_lengkap');
            $alamat = $this->input->post('alamat');
            $kabupaten = $this->input->post('kabupaten');
            $upline = $this->input->post('upline');

            $this->form_validation->set_rules('nomor_handphone', 'Nomor Handphone', 'callback_cek_nomor_handphone|required');
            $this->form_validation->set_rules('nik', 'Nomor KTP', 'required');
            $this->form_validation->set_rules('kata_sandi', 'Kata Sandi', 'required|matches[ulangi_kata_sandi]');
            $this->form_validation->set_rules('ulangi_kata_sandi', 'Ulangi Kata Sandi', 'required');
            $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
            $this->form_validation->set_rules('alamat', 'Alamat', 'required');
            $this->form_validation->set_rules('provinsi', 'Provinsi', 'required');
            $this->form_validation->set_rules('kabupaten', 'Kabupaten', 'required');
            $this->form_validation->set_rules('upline', 'Upline', 'required');

            $this->form_validation->set_message('cek_nomor_handphone', '%s tidak valid');
            $this->form_validation->set_message('required', '%s belum diisi');
            $this->form_validation->set_message('matches', '%s tidak cocok');
            $this->form_validation->set_error_delimiters('', '<br/>');

            $data = new stdClass();
            $data->nik = $nik;
            $data->nama_lengkap = $nama_lengkap;
            $data->alamat = $alamat;
            $data->upline = $upline;
            $data->kewenangan = 0;
            $data->aktif = 1;
            $data->kabupaten = $kabupaten;
            $data->kata_sandi = $kata_sandi;

            if ($this->form_validation->run() == TRUE)
            {
                $data_where = array
                (
                    'nomor_handphone' => $nomor_handphone,
                    'nik' => $nik
                );
            	if (!$this->anggota_model->apakah_anggota($data_where))
                {
                    $data_array = (array)$data;
                    $this->anggota_model->tambah_anggota($nomor_handphone, $data_array);
                    $this->session->set_userdata('join_sukses', true);
                    redirect(base_url('join/sukses'));
            	}
                else
                {
                    $this->session->set_userdata('telah_terjoin', true);
                    redirect(base_url('join/terjoin'));
            	}
            }
            else
            {
            	$profil_upline = $this->anggota_model->lihat_profil_anggota($upline);

                $data->nomor_handphone = $nomor_handphone;
                $data->provinsi = $this->input->post('provinsi');
                $data->pesan_galat = validation_errors();
                $data->galat = $this->form_validation->error_array();

                $this->load->model('geografi_model');

                $data->nomor_handphone_upline = $profil_upline->nomor_handphone;
                $data->nama_lengkap_upline = $profil_upline->nama_lengkap;
                $data->nama_kabupaten_upline = $this->geografi_model->nama_kabupaten($profil_upline->kabupaten);
                $id_provinsi = $this->geografi_model->provinsi_dari_kabupaten($profil_upline->kabupaten);
                $data->nama_provinsi_upline = $this->geografi_model->nama_provinsi($id_provinsi);

                $data->join_provinsi = $this->geografi_model->join_provinsi();
                $data->join_kabupaten = $this->geografi_model->join_kabupaten();

                $template_data->data = $data;
                $this->load->view('template/index', $template_data);
            }
        }
        else
        {
            $upline = $this->input->get('upline');

            if (!$this->apakah_login() && ($upline !== FALSE))
            {
                $profil_upline = $this->anggota_model->lihat_profil_anggota($upline);
            	$this->load->model('geografi_model');

                $data = new stdClass();
                $data->upline = $upline;
                $data->nomor_handphone_upline = $profil_upline->nomor_handphone;
                $data->nama_lengkap_upline = $profil_upline->nama_lengkap;
                $data->nama_kabupaten_upline = $this->geografi_model->nama_kabupaten($profil_upline->kabupaten);
                $id_provinsi = $this->geografi_model->provinsi_dari_kabupaten($profil_upline->kabupaten);
                $data->nama_provinsi_upline = $this->geografi_model->nama_provinsi($id_provinsi);
                // $data->jumlah_mitra_usaha = 0;

                $data->join_provinsi = $this->geografi_model->join_provinsi();
                $data->join_kabupaten = $this->geografi_model->join_kabupaten();

                $template_data->data = $data;
                $this->load->view('template/index', $template_data);
            }
            else if ($this->apakah_login())
            {
                redirect(base_url('anggota/dasbor'));
            }
            else
            {
                $sembarang_anggota = $this->anggota_model->ambil_sembarang_anggota();
                redirect(base_url('join?upline=' . $sembarang_anggota));
            }
        }
    }

    function sukses()
    {
    	if ($this->session->userdata('join_sukses'))
    	{
            $this->session->unset_userdata('join_sukses');

            $template_data = new TemplateData();
            $template_data->page_layout = 'sidebar_right';
            $template_data->sidebar = 'template/empty';
            $template_data->page_title = 'Penjoinan Sukses';
            $template_data->template_part = 'join/sukses';

            $this->load->view('template/index', $template_data);
        }
        else
        {
            redirect(base_url('anggota/dasbor'));
        }
    }

    function terjoin()
    {
    	if ($this->session->userdata('telah_terjoin'))
    	{
            $this->session->unset_userdata('telah_terjoin');

            $template_data = new TemplateData();
            $template_data->page_layout = 'sidebar_right';
            $template_data->sidebar = 'template/empty';
            $template_data->page_title = 'Penjoinan Dibatalkan';
            $template_data->template_part = 'join/terjoin';

            $this->load->view('template/index', $template_data);
    	}
        else
        {
            redirect(base_url('anggota/dasbor'));
        }
    }

    function cek_nomor_handphone($subject)
    {
        $pattern = '/^\s*08([0-9][\s-]*){4,}$/';
        if (preg_match($pattern, $subject) == 1)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
}

?>