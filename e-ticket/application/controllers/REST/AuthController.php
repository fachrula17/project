<?php
use GuzzleHttp\Client;

# 1. install guzzle
#	2. users
# 3. get user by id
# 4. login
# 5. catch error
# 6. delete authorization

# 7. refactor kode
# 8. update dan register (latihan murid)

class AuthController extends CI_Controller {
	private $client = '';

	public function __construct()
	{
		parent::__construct();
		$this->client = new Client([
			'base_uri' => 'http://localhost:8000/api/'
		]);
	}

	public function index()
	{
		try {
			$response = $this->client->request('GET', 'users', [
			]);

			$result = json_decode($response->getBody()->getContents(), true);
			var_dump($result);

		} catch (GuzzleHttp\Exception\ClientException $e) {
		  $response = $e->getResponse()->getStatusCode();
			echo 'Caught response: ' . $response;
		}
	}

	public function show($id)
	{
		try {
			$response = $this->client->request('GET', 'users/' .$id, [
			]);

			$result = json_decode($response->getBody()->getContents(), true);
			var_dump($result);

		} catch (GuzzleHttp\Exception\ClientException $e) {
		  $response = $e->getResponse()->getStatusCode();
			echo 'Caught response: ' . $response;
		}
	}

	public function delete($id)
	{
		try {
			$response = $this->client->request('DELETE', 'users/' .$id, [
				'headers' => [
		    	'Authorization' => $this->session->userdata('token')
		    ]
			]);

			$result = json_decode($response->getBody()->getContents(), true);
			var_dump($result);

		} catch (GuzzleHttp\Exception\ClientException $e) {
		  $response = $e->getResponse();
		  $result = json_decode($response->getBody()->getContents(), true);

		  $status = $response->getStatusCode();
		  $message = $response->getReasonPhrase();
		  $headers = $response->getHeaders();

		  if($status === 404 || $status === 403) :
		  	$errors = $result['message'];
		  	$this->session->set_flashdata('status', $errors);
				redirect('users/login');
			endif;
		}
	}

	public function login()
	{
		$data['errors'] = $this->session->flashdata('status') ? $this->session->flashdata('status') : null;

		$this->load->view('auth/login', $data);
	}

	public function isLogin()
	{
		$data = [
			'username' => $this->input->post('username'),
			'password' => sha1($this->input->post('password'))
		];

		try {
		 $response = $this->client->request('POST', 
			'admin', [
				'form_params' => $data
			]);    

		 	$result = json_decode($response->getBody()->getContents(), true);
		 	$this->session->set_userdata('token', $result['id_token']);
			var_dump($result);
		}
		catch (GuzzleHttp\Exception\ClientException $e) {
		  $response = $e->getResponse();
		  $result = json_decode($response->getBody()->getContents(), true);

		  $status = $response->getStatusCode();
		  $message = $response->getReasonPhrase();
		  $headers = $response->getHeaders();

		  if($status === 401) :
		  	$errors = $result['message'];
		  	$this->session->set_flashdata('status', $errors);
				redirect('users/login');
			endif;
		}
	}

	public function register()
	{
		$this->load->view('auth/register');
	}

}