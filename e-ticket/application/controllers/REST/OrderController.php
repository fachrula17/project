<?php 

use \Firebase\JWT\JWT;

class OrderController extends CI_Controller {
	private $secret = 'myadmin';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Order');

		header("Access-Control-Allow-Origin: *");
	  	header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE");
	  	header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Content-Range, Content-Disposition, Content-Description');
	}

	public function index()
	{
		$data = $this->Order->get_data();

		$result = array('data' => array());

		$no = 1;
		foreach ($data as $key => $value) :
			$confirm = "return confirm('Are you sure delete this data?')";

			#button action
			

			if($value->status == '1'){
				$status = 'Confirm';
				$buttons = '
					<a href="#" onclick="removed('.$value->id_order.')" class="badge badge-danger">Delete</a>
				';
			}else{
				$status = 'Not Confirm';

				$buttons = '
				<a href="#" class="badge badge-success" onclick="confirm('.$value->id_order.')">Confirmation</a>
				<a href="#" onclick="removed('.$value->id_order.')" class="badge badge-danger">Delete</a>
				';
			}

			if($value->upload == '' || $value->upload == null){
				$image = '';
			}else{
				$image = "<a href='".base_url('uploads/').$value->upload."' data-lightbox='image-1' data-title='".$value->fullname."'><img src='".base_url('uploads/').$value->upload."' width='90'></a>";
			}

			$result['data'][$key] = array(
				$no,
				$value->no_ticket,
				$value->event_name,
				$value->metode,
				"Rp ".number_format($value->total),
				$value->bank_name,
				$value->account_name,
				tgl_indo($value->date),
				$image,
				$status,
				$buttons
			);

			$no++;
		endforeach;

		return $this->response($result);
	}

	public function member($id)
	{
		$data = $this->Order->get_data($id);

		$result = array('data' => array());

		$no = 1;
		foreach ($data as $key => $value) :

			if($value->status == '1'){
				$status = 'Confirm';
			}else{
				$status = 'Not Confirm';
			}

			if($value->upload == '' || $value->upload == null){
				$image = '';
			}else{
				$image = "<a href='".base_url('uploads/').$value->upload."' data-lightbox='image-1' data-title='".$value->fullname."'><img src='".base_url('uploads/').$value->upload."' width='90'></a>";
			}

			$result['data'][$key] = array(
				$no,
				'<a href="'.site_url('e-ticket/'.$value->no_ticket).'" target="_blank">'.$value->no_ticket.'</a>',
				$value->event_name,
				tgl_indo($value->date),
				$value->metode,
				$value->bank_name,
				$value->account_name,
				"Rp ".number_format($value->total),
				$image,
				$status,
						);

			$no++;
		endforeach;

		return $this->response($result);
	}

	public function confirm($id = NULL)
	{
		$this->db->update('orders', ['status' => '1','confirmed_by' => '1'], ['id_order' => $id]);
		return $this->response(['status' => true, 'message' => 'Data Has Been Saved!']);
		
	}


	public function order() 
	{
		$this->check_token();
		$metode 		= $this->input->post('metode');
		$noticket 		= "ET".random(6).date('s');
		$id_user 		= $this->input->post('id_user');
		$id_event 		= $this->input->post('id_event');

		if($metode == 'transfer'){

			$this->form_validation->set_rules('metode', 'Metode', 'required');
			$this->form_validation->set_rules('bank_name', 'Bank Name', 'required');
			$this->form_validation->set_rules('bank_account', 'Bank Account', 'required');
			$this->form_validation->set_rules('price', 'Total', 'required');

			if($this->form_validation->run() === false) :
				return $this->response([
					'status' => false,
					'message' => 'All field are required!'
				], 401);
			else:

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
					'no_ticket'		=> $noticket,
					'user_id'		=> $id_user,
					'event_id'		=> $id_event,
					'user_id'		=> $id_user,
					'metode'		=> $metode,
					'bank_name'		=> $this->input->post('bank_name'),
					'account_name'	=> $this->input->post('bank_account'),
					'total'			=> $this->input->post('price'),
					'upload' 		=> $file['file_name'],
					'status'		=> '0'
				);

				$reg = array(
					'user_id'		=> $id_user,
					'event_id'		=> $id_event,
					'no_ticket'		=> $noticket,
					'status'		=> '0'
				);

				$this->Order->save($data, $reg);

				return  $this->response([
						'status' => true,
						'message' => 'Data Has Been Saved!'
				], 200);
			endif;
		}else{
			$data = array(
					'no_ticket'		=> $noticket,
					'user_id'		=> $id_user,
					'metode'		=> $metode,
					'event_id'		=> $id_event,
					'total'			=> $this->input->post('price'),
					'status'		=> '0'
				);

			$reg = array(
				'user_id'		=> $id_user,
				'event_id'		=> $id_event,
				'no_ticket'		=> $noticket,
				'status'		=> '0'
			);

			$getsaldo = $this->db->get_where('user', ['id_user' => $id_user])->row('total_deposit');
			$saldo = $getsaldo - $this->input->post('price');

			$this->Order->save($data, $reg);
			$this->db->update('user', ['total_deposit' => $saldo], ['id_user' => $id_user]);

			return  $this->response([
					'status' => true,
					'message' => 'Data Has Been Saved!'
			], 200);
		}
	}

	public function delete()
	{	
		$id = $this->input->delete('id');
		
		return $this->response(
			$this->Order->delete($id)
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
			return $decoded->id_user;

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