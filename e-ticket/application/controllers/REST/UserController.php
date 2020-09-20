<?php 

use \Firebase\JWT\JWT;

class UserController extends CI_Controller {
	private $secret = 'myadmin';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User');

		header("Access-Control-Allow-Origin: *");
	  	header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE");
	  	header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Content-Range, Content-Disposition, Content-Description');
	}

	public function index()
	{
		$data = $this->User->get_data();
		return $this->response($data);
	}

	public function show($id)
	{
		$data = $this->User->get_data('id', $id);
		return $this->response($data);
	}

	public function update($id)
	{
		$data = $this->get_input();
		if($this->protected_method($id)) {
			return $this->response( $this->User->update($data, $id) );
		}
	}

	public function adminUpdate($id)
	{
		$this->check_token();
		$password = $this->input->put('password');

		if($password == ''){
			$data = array(
				'username' 	=> $this->input->put('username')
			);
		}else{
			$data = array(
				'username' 	=> $this->input->put('username'),
				'password' 	=> password_hash($password, PASSWORD_DEFAULT),
			);
		}

		return $this->response($this->User->update($data, $id));
	}

	public function login() 
	{
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if($this->form_validation->run() === false) :
			$output['status'] = false;

			foreach($_POST as $key => $value) :
				$output['message'][$key] = form_error($key);
			endforeach;

			$this->response($output, 401);
		else: 
			$username = $this->input->post('username');
			$user = $this->User->get_data('username', $username);

			if(!empty($user)) : 
				$login = $this->User->is_login();

				if(!$login) {
					return $this->response([
						'status' => false,
						'message' => 'Password anda salah'
					], 401);
				}

				#generate token.
				$payload = array(
					'id_admin' => $user->id_admin,
					'username' => $user->username
				);

				$output['status'] = true;
				$output['id_token'] = JWT::encode($payload, $this->secret);
				return $this->response($output);
				
			else:
				return $this->response([
					'status' => false,
					'message' => 'Username Invalid'
				], 401);
			endif;
		endif;
	}

	public function store() 
	{
		#terima datanya
		$email = $this->input->post('email');
		$password = $this->input->post('password');


		$data = $this->User->register($email, $password);
		return $this->response($data);
	}

	public function delete($id)
	{	
		if($this->protected_method($id)) {
			return $this->response(
				$this->User->delete($id)
			);
		}
	}

	private function get_input()
	{
		return json_decode(file_get_contents('php://input'));
	}

	private function response($data, $status = 200)
	{
		$this->output
        ->set_status_header($status)
        ->set_content_type('application/json')
        ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();

		exit;
	}

	private function check_token()
	{
		$jwt = $this->input->get_request_header('Authorization');

		try {
			$decoded = JWT::decode($jwt, $this->secret, array('HS256'));
			return $decoded->id_admin;

		} catch (Exception $e) {
			return $this->response([
				'status' => false,
				'message' => 'token is not found'
			], 404);
		}
	}

	private function protected_method($id)
	{
		$token_id = $this->check_token();
		if($token_id === $id) {
			return true;
		} else {
			return $this->response([
				'status' => false,
				'message' => 'forbidden user..'
			], 403);
		}
	}
}
?>