<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['title'] = 'Home';

		$this->load->view('themes/head', $data);
		$this->load->view('themes/header', $data);
		$this->load->view('home/index', $data);
		$this->load->view('themes/footer');
	
	}

	public function register()
	{
		$data['title'] = 'Register';

		$this->load->view('themes/head', $data);
		$this->load->view('themes/header', $data);
		$this->load->view('home/register', $data);
		$this->load->view('themes/footer');
	
	}	


	public function forget()
	{
		$data['title'] = 'Forget Password';

		$this->load->view('themes/head', $data);
		$this->load->view('themes/header', $data);
		$this->load->view('home/forget', $data);
		$this->load->view('themes/footer');
	
	}

	public function changePassword()
	{

		$data['title'] = 'Change <strong>Password<strong>';

		$this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[3]|matches[password2]', 
			[
				'matches' => 'Password dont match!',
				'min_length' => 'Password to short' 
			]
		);

		$this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|matches[password1]');
		if($this->form_validation->run() === false) {
			$this->load->view('themes/head', $data);
			// $this->load->view('themes/header', $data);
			$this->load->view('auth/change-password');
			// $this->load->view('themes/footer');
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

	public function detail($id)
	{
		$data['title'] = 'Order';

		$data['event'] = $this->db->get_where('event', ['id_event' => $id])->row();

		$this->load->view('themes/head', $data);
		$this->load->view('themes/header', $data);
		$this->load->view('order/index', $data);
		$this->load->view('themes/footer');
	
	}

	public function deposit()
	{
		$data['title'] = 'Deposit';

		$this->load->view('themes/head', $data);
		$this->load->view('themes/header', $data);
		$this->load->view('order/deposit', $data);
		$this->load->view('themes/footer');
	
	}

	public function history_deposit()
	{
		$data['title'] = 'History Deposit';

		$this->load->view('themes/head', $data);
		$this->load->view('themes/header', $data);
		$this->load->view('order/history-deposit', $data);
		$this->load->view('themes/footer');
	
	}

	public function history_order()
	{
		$data['title'] = 'History Order';

		$this->load->view('themes/head', $data);
		$this->load->view('themes/header', $data);
		$this->load->view('order/history-order', $data);
		$this->load->view('themes/footer');
	
	}

	public function profile()
	{
		$data['title'] = 'My Profile';

		$this->load->view('themes/head', $data);
		$this->load->view('themes/header', $data);
		$this->load->view('home/profile', $data);
		$this->load->view('themes/footer');
	
	}

	public function editProfile()
	{
		$data['title'] = 'Edit Profile';

		$this->load->view('themes/head', $data);
		$this->load->view('themes/header', $data);
		$this->load->view('home/edit-profile', $data);
		$this->load->view('themes/footer');
	
	}
}