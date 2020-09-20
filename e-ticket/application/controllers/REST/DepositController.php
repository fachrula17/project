<?php 

use \Firebase\JWT\JWT;

class DepositController extends CI_Controller {
	private $secret = 'myadmin';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Deposit');

		header("Access-Control-Allow-Origin: *");
	  	header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE");
	  	header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Content-Range, Content-Disposition, Content-Description');
	}

	public function index()
	{

		$data = $this->Deposit->get_data();

		$result = array('data' => array());

		$no = 1;
		foreach ($data as $key => $value) :
			$confirm = "return confirm('Are you sure delete this data?')";

			#button action
			

			if($value->status == '1'){
				$status = 'Confirm';
				$buttons = '
					<a href="#" onclick="removed('.$value->id_deposit.')" class="badge badge-danger">Delete</a>
				';
			}else{
				$status = 'Not Confirm';

				$buttons = '
				<a href="#" class="badge badge-success" onclick="confirm('.$value->id_deposit.')">Confirmation</a>
				<a href="#" onclick="removed('.$value->id_deposit.')" class="badge badge-danger">Delete</a>
				';
			}

			$result['data'][$key] = array(
				$no,
				$value->fullname,
				"Rp ".number_format($value->total),
				tgl_indo($value->date),
				"<a href='".base_url('uploads/').$value->upload."' data-lightbox='image-1' data-title='".$value->fullname."'><img src='".base_url('uploads/').$value->upload."' width='90'></a>",
				$status,
				$buttons
			);

			$no++;
		endforeach;

		return $this->response($result);
	}

	public function member($id)
	{

		$data = $this->Deposit->get_data($id);

		$result = array('data' => array());

		$no = 1;
		foreach ($data as $key => $value) :
			
			if($value->status == '1'){
				$status = 'Confirm';
			}else{
				$status = 'Not Confirm';
			}

			$result['data'][$key] = array(
				$no,
				$value->fullname,
				"Rp ".number_format($value->total),
				tgl_indo($value->date),
				"<a href='".base_url('uploads/').$value->upload."' data-lightbox='image-1' data-title='".$value->fullname."'><img src='".base_url('uploads/').$value->upload."' width='90'></a>",
				$status
			);

			$no++;
		endforeach;

		return $this->response($result);
	}

	public function confirm($id = NULL)
	{
		$pay 	= $this->db->get_where('deposit', ['id_deposit' => $id])->row();
		$usr 	= $this->db->get_where('user', ['id_user' => $pay->user_id])->row();
		$total 	= $usr->total_deposit + $pay->total;

		$this->db->update('user', ['total_deposit' => $total], ['id_user' => $pay->user_id]);
		$this->db->update('deposit', ['status' => '1', 'confirmed_by' => '1'], ['id_deposit' => $id]);
		return $this->response(['status' => true, 'message' => 'Data Has Been Saved!']);
		
	}

	public function delete()
	{	
		$id = $this->input->delete('id');
		
		return $this->response(
			$this->Deposit->delete($id)
		);
		
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
			return $decoded->id;

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