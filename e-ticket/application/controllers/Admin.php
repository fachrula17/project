<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['title'] = 'Dashboard';

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/index', $data);
		$this->load->view('templates/footer');
	}

	public function show()
	{
		$data['title'] = 'List Deposit';
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/deposit', $data);
		$this->load->view('templates/footer');
	}

	public function order()
	{
		$data['title'] = 'List Order';
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/order', $data);
		$this->load->view('templates/footer');
	}

	public function listAudience()
	{
		$data['title'] = 'List Audience';
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/list-audience', $data);
		$this->load->view('templates/footer');
	}	

	private function set_upload()
	{
		$config['upload_path']          = './assets/backend/img/kategori'; #directory untuk menyimpan gambar/file
    $config['allowed_types']        = 'png|jpg|jpeg|gif'; #jenis gambar
    $config['max_size']             = 20480; // Limitasi 1 file image 10mb

    $this->upload->initialize($config);
	}

	private function error_upload()
	{
		$error = array('errors' => $this->upload->display_errors()); #show errornya
		$this->session->set_flashdata('error-upload', '<div class="alert alert-danger">'.$error['errors'].'</div>');
	}

	public function changePassword()
	{
		$data['title'] = 'Change Password';
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/change-password', $data);
		$this->load->view('templates/footer');
	}
}