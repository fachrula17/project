<?php 

use \Firebase\JWT\JWT;

class MemberController extends CI_Controller {
	private $secret = 'myadmin';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Member');
		$this->load->library('email');

		header("Access-Control-Allow-Origin: *");
	  	header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE");
	  	header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Content-Range, Content-Disposition, Content-Description');
	}

	public function index()
	{
		$data = $this->Member->get_data();

		$result = array('data' => array());

		$no = 1;
		foreach ($data as $key => $value) :
			$confirm = "return confirm('Are you sure delete this data?')";

			#button action
			$buttons = '
				<a href="#" onclick="removed('.$value->id_user.')" class="badge badge-danger">Delete</a>
				<a href="#"	onclick="updateStatus('.$value->id_user.', '.$value->is_active.')" class="badge badge-primary">Edit Status</a>
				<a href="'.site_url('member/deposit/'.$value->id_user).'" class="badge badge-success">List Deposit</a>
			';

			if($value->is_active == '1'){
				$status = 'Active';
			}else{
				$status = 'No Active';
			}

			$result['data'][$key] = array(
				$no,
				$value->email,
				$value->fullname,
				$value->address,
				$value->phone,
				"Rp ".number_format($value->total_deposit),
				$status,
				$buttons
			);

			$no++;
		endforeach;

		return $this->response($result);
	}

	public function show()
	{
		$id = $this->check_token();
		$data = $this->Member->get_data('id_user', $id);
		return $this->response($data);
	}

	public function show_admin()
	{
		$id = $this->check_token_admin();
		$data = $this->Member->get_data_admin('id_admin', $id);
		return $this->response($data);
	}

	public function updateStatus($id_user){
		// $this->check_token();
		$status = $this->input->post('status');

		if($status == '0'){
			$set = '1';
		}else{
			$set = '0';
		}

		return $this->response($this->db->update('user', ['is_active' => $set], ['id_user' => $id_user]));
	}

	public function update($id)
	{
		$password = $this->input->put('password');

		if($password == ''){
			$data = array(
			'email' 	=> $this->input->put('emails'),
			'fullname'	=> $this->input->put('fullname'),
			'address' 	=> $this->input->put('address'),
			'phone'		=> $this->input->put('phone')
			);
		}else{
			$data = array(
			'email' 	=> $this->input->put('emails'),
			'fullname'	=> $this->input->put('fullname'),
			'address' 	=> $this->input->put('address'),
			'password' 	=> password_hash($this->input->post('password'), PASSWORD_DEFAULT),
			'phone'		=> $this->input->put('phone')
			);
		}

		return $this->response($this->Member->update($data, $id));
	}

	public function login() 
	{
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if($this->form_validation->run() === false) :
			$output['status'] = false;

			foreach($_POST as $key => $value) :
				$output['message'][$key] = form_error($key);
			endforeach;

			$this->response($output, 401);
		else: 
			$email = $this->input->post('email');
			$user = $this->Member->get_data('email', $email);

			if(!empty($user)) : 
				$login = $this->Member->is_login();
				// return $this->response($login);

				if(!$login) {
					return $this->response([
						'status' => false,
						'message' => 'Password anda salah'
					], 401);
				}

				#generate token.
				$payload = array(
					'id_user' 	=> $user->id_user,
					'email' 	=> $user->email,
					'fullname'	=> $user->fullname
				);

				$output['status'] = true;
				$output['id_token'] = JWT::encode($payload, $this->secret);
				return $this->response($output);
				
			else:
				return $this->response([
					'status' => false,
					'message' => 'email Invalid'
				], 401);
			endif;
		endif;
	}

	public function store() 
	{
		#terima datanya
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('fullname', 'Fullname', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('phone', 'Phone', 'required');

		if($this->form_validation->run() === false) :
			$output['status'] = false;

			foreach($_POST as $key => $value) :
				$output['message'][$key] = form_error($key);
			endforeach;

			$this->response($output, 401);
		else: 
			$datas = [
				'email' 				=> $this->input->post('email'),
				'password' 				=> password_hash($this->input->post('password'), PASSWORD_DEFAULT),
				'fullname' 				=> $this->input->post('fullname'),
				'address' 				=> $this->input->post('address'),
				'phone' 				=> $this->input->post('phone'),
				'total_deposit' 		=> 0,
				'is_active' 			=> '0',
			];

			$token = token(20);
			$user_token = [
				'token' => $token,
				'email' => $this->input->post('email'),
				'date' => time()
			];
			$this->_sendEmail($token, 'verify');

			$data = $this->Member->register($datas, $user_token);

			return $this->response($data);
		endif;
	}

	public function delete()
	{	
		$id = $this->input->delete('id');
		return $this->response(
			$this->Member->delete($id)
		);
		
	}

	public function topup() {
		$this->check_token();
		$total 		= $this->input->post('total');
		$id_user 	= $this->input->post('id_user');

		$this->load->library('upload'); #import library upload

		$config['upload_path'] 		= "uploads"; #folder penyimpanan file
		$config['allowed_types'] 	= 'jpg|jpeg|png'; #type file

		$this->upload->initialize($config);

		if($this->upload->do_upload('upload')) {
        	$file = $this->upload->data();
        } else {
            return $this->response([
				'status' => false,
				'message' => 'Image Has Required!'
			], 401);
        }

        
		$data = array(
			'total'		=> $total,
			'user_id'	=> $id_user,
			'upload' 	=> $file['file_name'],
		);

		$this->Member->save($data);

		return  $this->response([
				'status' => true,
				'message' => 'Data Has Been Saved!'
		], 200);
	}

	private function get_input()
	{
		return json_decode(file_get_contents('php://input'));
	}


	private function check_token()
	{
		$jwt = $this->input->get_request_header('Authorization');

		try {
			$decoded = JWT::decode($jwt, $this->secret, array('HS256'));
			return $decoded->id_user;

		} catch (Exception $e) {
			return $this->response([
				'status' => false,
				'message' => 'token is not found'
			], 404);
		}
	}

	private function check_token_admin()
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

	public function verify()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');
		$user = $this->db->get_where('user', ['email' => $email])->row_array();

		if($user) :
			$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
			
			if($user_token) :

				if(time() - $user_token['date'] < (60*60*24)) :
					$this->db->set('is_active', '1');
					$this->db->where('email', $email);
					$this->db->update('user');

					$this->db->delete('user_token', array('email' => $email));
					$this->session->set_flashdata('message', '<p class="col-md-12 mb-2 alert alert-success">'.$email.' has been activated. Please login</p>');
					redirect('home');

				else:
					$this->db->delete('user', array('email' => $email));
					$this->db->delete('user_token', array('email' => $email));
					$this->session->set_flashdata('message', '<p class="col-md-12 mb-2 alert alert-danger">Token expired</p>');
					redirect('home');
				endif;

			else:
				$this->session->set_flashdata('message', '<p class="col-md-12 mb-2 alert alert-danger">Token invalid!</p>');
				redirect('home');
			endif;

		else:
			$this->session->set_flashdata('message', '<p class="col-md-12 mb-2 alert alert-danger">Account activation failed! Wrong email</p>');
			redirect('home');
		endif;
	}

	public function forgotPassword()
	{
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

		if($this->form_validation->run() === false) :
			$output['status'] = false;

			foreach($_POST as $key => $value) :
				$output['message'][$key] = form_error($key);
			endforeach;

			$this->response($output, 401);
		else:

			$email = $this->input->post('email', true);
			$user = $this->db->get_where('user', ['email' => $email, 'is_active' => '1'])->row_array();
			// return $this->response($this->db->last_query());

			if($user) :
				$token = base64_encode(random_bytes(32));
				$user_token = [
					'token' => $token,
					'email' => $email,
					'date' => time()
				];	

				$this->db->insert('user_token', $user_token);
				$this->_sendEmail($token, 'forgot');

				$output['status'] = true;
				$output['message'] = 'Please check email for link!';
				return $this->response($output);
			else:
				return $this->response([
					'status' => false,
					'message' => 'Email Not Found'
				], 401);
			endif;
		endif;
	}

	public function changePassword()
	{

		$this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[3]|matches[password2]', 
			[
				'matches' => 'Password dont match!',
				'min_length' => 'Password to short' 
			]
		);

		$this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|matches[password1]');
		if($this->form_validation->run() === false) {
			$output['status'] = false;

			foreach($_POST as $key => $value) :
				$output['message'][$key] = form_error($key);
			endforeach;

			$this->response($output, 401);
		} else {
			$email 		= $this->input->post('email');
			$password 	= password_hash($this->input->post('password1'), PASSWORD_DEFAULT);

			$this->db->set('password', $password);
			$this->db->where('email', $email);
			$this->db->update('user');

			// return $this->response($email);

			$this->session->unset_userdata('reset_email');
			$this->db->delete('user_token', ['email' => $email]);

			$output['status'] 	= true;
			$output['message'] 	= 'Password Has Been Changed!';
			return $this->response($output);
		}
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
		$this->email->from('arul.kotbum@gmail.com', 'E-Ticket Crew');
		$this->email->to($email);

		if($type == 'verify') :
			$this->email->subject('Account Verification');
			$this->email->message('Click the following URL to activate your account: <a href="'.site_url('api/member/verify?email=' .$email .'&token=' .$token).'">Activate</a>');
		else:
			$this->email->subject('Reset Password');
			$this->email->message('Click this link to reset your password: <a href="'.site_url('api/confirm-password?email=' .$email .'&token=' .$token).'">Reset Password</a>');
		endif;

		if($this->email->send()) {
			return true;
		} else {
			echo $this->email->print_debugger();
			die;
		}
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
}
?>