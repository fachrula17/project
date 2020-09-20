<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['title'] = 'List Member';

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('member/index', $data);
		$this->load->view('templates/footer');
	
	}

	public function changePassword()
	{
		if(!$this->session->userdata('reset_email')) :
			redirect('auth');
		endif;

		$data['title'] = 'Change <strong>Password<strong>';

		$this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[3]|matches[password2]', 
			[
				'matches' => 'Password dont match!',
				'min_length' => 'Password to short' 
			]
		);

		$this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|matches[password1]');
		if($this->form_validation->run() === false) {
			$this->load->view('themes/header', $data);
			$this->load->view('auth/change-password');
			$this->load->view('themes/footer');
		} else {
			$password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);

			$this->db->set('password', $password);
			$this->db->where('email', $email);
			$this->db->update('user');

			$this->session->unset_userdata('reset_email');
			$this->db->delete('user_token', ['email' => $email]);

			$this->session->set_flashdata('message', '<p class="text-gray-500 mb-0">Password has been changed!. Please login</p>');
			redirect('administrador/auth/message');
		}
	}

	public function deposit($id_user){
		$data['title'] = 'List Deposit Member';

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('member/deposit-list', $data);
		$this->load->view('templates/footer');
	}
}