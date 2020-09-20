<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{	
		if($this->session->userdata('email')) {
			redirect('admin');
		}

		$data['title'] = 'Login <strong>Page<strong>';
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if($this->form_validation->run() === false) {
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/login');
			$this->load->view('templates/auth_footer');
		} else {
			$this->login();
		}
	}

	public function registration()
	{
		$data['title'] = 'User <strong>Registration<strong>';

		$this->form_validation->set_rules('fullname', 'Fullname', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user.email]', [
			'is_unique' => 'This email has already registered!'
		]);

		$this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[3]|matches[password2]', 
			[
				'matches' => 'Password dont match!',
				'min_length' => 'Password to short' 
			]
		);

		$this->form_validation->set_rules('password2', 'Password', 'trim|required|matches[password1]');
		$this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|trim');
		$this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required|trim');
		$this->form_validation->set_rules('address', 'Alamat', 'required|trim');
		$this->form_validation->set_rules('phone', 'No. Telp', 'required|trim');
		$this->form_validation->set_rules('pekerjaan', 'pekerjaan', 'required|trim');
		$this->form_validation->set_rules('prestasi', 'prestasi', 'required|trim');


		if($this->form_validation->run() === false) {
			$this->load->view('backend/templates/auth_header', $data);
			$this->load->view('backend/auth/registration');
			$this->load->view('backend/templates/auth_footer');
		} else {
			$email = $this->input->post('email', true);

			$data = [
				'fullname'	 	=> htmlspecialchars($this->input->post('fullname', true)),
				'email'		 	=> htmlspecialchars($email),
				'password' 		=> password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
				'role_id' 		=> 2,
				'is_active' 	=> 0
			];

			$token = token(20);
			$user_token = [
				'token' => $token,
				'email' => $email,
				'date' => time()
			];

			$profile = [
				'tempat_lahir'		=> htmlspecialchars($this->input->post('tempat_lahir', true)),
				'tgl_lahir'			=> htmlspecialchars($this->input->post('tgl_lahir', true)),
				'gender'			=> htmlspecialchars($this->input->post('gender', true)),
				'address'			=> htmlspecialchars($this->input->post('address', true)),
				'phone'				=> htmlspecialchars($this->input->post('phone', true)),
				'fide_id'			=> htmlspecialchars($this->input->post('fide_id', true)),
				'link_lichess'		=> htmlspecialchars($this->input->post('link_lichess', true)),
				'pekerjaan'			=> htmlspecialchars($this->input->post('pekerjaan', true)),
				'prestasi'			=> htmlspecialchars($this->input->post('prestasi', true)),
			];

			// print_r($_FILES["photo"]["name"]);die;
			
			if($_FILES["photo"]["name"] !== "") : #bila gambar covernya tidak kosong
				$this->set_upload();

				#jika berhasil diupload.
				if($this->upload->do_upload("photo") ) :
					$image = $this->upload->data();
					$url = $image['file_name'];	
					$profile['photo'] = $url;
					
					$this->db->insert('user', $data);
					$user_id = $this->db->insert_id();
					$profile['user_id'] = $user_id;
					// print_r($profile);die;
					$this->db->insert('user_profile', $profile);
					$this->db->insert('user_token', $user_token);

					#kirim email
					$this->_sendEmail($token, 'verify');

					$this->session->set_flashdata('message', '<div class="alert alert-success">Congratulation! your account has been created. Please activate your account.</div>');
					redirect('auth/register');
				else:
					$this->error_upload();
					// print_r($this->error_upload());die;
					redirect('auth/register');
				endif;
			else:
				$this->session->set_flashdata("error-upload", '<div class="alert alert-danger">Tidak boleh kosong file uploadnya.</div>');
				// echo 'test';die;
				redirect('auth/register');
			endif;
		}
	}

	private function login()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$user = $this->db->get_where('user', ['email' => $email])->row_array();
		if($user) {

			if($user['is_active'] == 1) {
				if(password_verify($password, $user['password'])) {
					$data = [
						'user_id' => $user['id'],
						'email' => $user['email'],
						'role_id' => $user['role_id']
					];

					$this->session->set_userdata($data);
					if($user['role_id'] == 1) {
						redirect('admin');
					} else {
						redirect('admin');
					}
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger">Wrong password</div>');
					redirect('administrador');
				}

			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger">
					This email has not been activated</div>');
				redirect('administrador');
			}

		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger">Email is not registered</div>');
			redirect('administrador');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('role_id');

		$this->session->set_flashdata('message', '<div class="alert alert-success">You have been logged out</div>');
			redirect('administrador');
	}

	public function blocked()
	{
		$this->load->view('backend/auth/blocked');
	}

	public function verify()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');
		$user = $this->db->get_where('user', ['email' => $email])->row_array();

		if($user) :
			$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
			// print_r($token);die;
			if($user_token) :

				if(time() - $user_token['date'] < (60*60*24)) :
					$this->db->set('is_active', 1);
					$this->db->where('email', $email);
					$this->db->update('user'); 

					$this->db->delete('user_token', array('email' => $email));
					$this->session->set_flashdata('message', '<p class="text-gray-500 mb-0">'.$email.' has been activated. Please login</p>');
					redirect('auth/message');

				else:
					$this->db->delete('user', array('email' => $email));
					$this->db->delete('user_token', array('email' => $email));
					$this->session->set_flashdata('message', '<p class="text-gray-500 mb-0">Token expired</p>');
					redirect('auth/message');
				endif;

			else:
				$this->session->set_flashdata('message', '<p class="text-gray-500 mb-0">Token invalid!</p>');
				redirect('auth/message');
			endif;

		else:
			$this->session->set_flashdata('message', '<p class="text-gray-500 mb-0">Account activation failed! Wrong email</p>');
			redirect('administrador/auth/message');
		endif;
	}

	public function message()
	{
		$this->load->view('backend/auth/message');
	}

	public function resetPassword()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		$user = $this->db->get_where('user', ['email' => $email])->row_array();
		if($user) {
			$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

			if($user_token) :
				$this->session->set_userdata('reset_email', $email);
				$this->changePassword();
			else:
				$this->session->set_flashdata('message', '<p class="text-gray-500 mb-0">Wrong token!</p>');
				redirect('administrador/auth/message');
			endif;
		} else {
			$this->session->set_flashdata('message', '<p class="text-gray-500 mb-0">Wrong email invalid!</p>');
			redirect('administrador/auth/message');
		}
	}

	#habis ganti password user_token dihapus
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
			$this->load->view('backend/templates/auth_header', $data);
			$this->load->view('backend/auth/change-password');
			$this->load->view('backend/templates/auth_footer');
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

	#buat di mobile appsnya
	public function forgotPassword()
	{
		if($this->session->userdata('email')) {
			redirect('admin');
		}
		
		$data['title'] = 'Forgot <strong>Password<strong>';
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

		if($this->form_validation->run() === false) :
			$this->load->view('backend/templates/auth_header', $data);
			$this->load->view('backend/auth/forgot-password');
			$this->load->view('backend/templates/auth_footer');
		else:

			$email = $this->input->post('email', true);
			$user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();

			if($user) :
				$token = base64_encode(random_bytes(32));
				$user_token = [
					'token' => $token,
					'email' => $email,
					'date' => time()
				];	

				$this->db->insert('user_token', $user_token);

				#kirim email
				$this->_sendEmail($token, 'forgot');

				$this->session->set_flashdata('message', 
					'<div class="alert alert-success">Please, check your email to reset your password</div>');
				redirect('administrador');

			else:
				$this->session->set_flashdata('message', '<div class="alert alert-danger">Email is not registered or activated</div>');
				redirect('administrador/auth/forgot-password');
			endif;
		endif;
	}

	private function _sendEmail($token, $type)
	{
		$email = $this->input->post('email');
		$config = [
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_user' => 'arul.kotbum@gmail.com',
			'smtp_pass' => 'theaterofdream',
			'smtp_port' => 465,
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		]; 
 
		$this->email->initialize($config); 
		$this->email->from('arul.kotbum@gmail.com', 'SCUA');
		$this->email->to($email);

		if($type == 'verify') :
			$this->email->subject('Account Verification');
			$this->email->message('Click the following URL to activate your account: <a href="'.site_url('auth/verify?email=' .$email .'&token=' .$token).'">Activate</a>');
		else:
			$this->email->subject('Reset Password');
			$this->email->message('Click this link to reset your password: <a href="'.site_url('auth/reset-password?email=' .$email .'&token=' .$token).'">Reset Password</a>');
		endif;

		if($this->email->send()) {
			return true;
		} else {
			echo $this->email->print_debugger();
			die;
		}
	}

	private function set_upload()
	{
		$config['upload_path']          = './assets/member'; #directory untuk menyimpan gambar/file
    	$config['allowed_types']        = 'png|jpg|jpeg|gif'; #jenis gambar
    	$config['max_size']             = 20480; // Limitasi 1 file image 10mb

    	$this->upload->initialize($config);
	}

	private function error_upload()
	{
		$error = array('errors' => $this->upload->display_errors()); #show errornya
		$this->session->set_flashdata('error-upload', '<div class="alert alert-danger">'.$error['errors'].'</div>');
	}

}