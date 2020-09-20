<?php 

use \Firebase\JWT\JWT;

class EventController extends CI_Controller {
	private $secret = 'myadmin';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Event');

		header("Access-Control-Allow-Origin: *");
	  	header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE");
	  	header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Content-Range, Content-Disposition, Content-Description');
	}

	public function index()
	{
		$data = $this->Event->get_data();

		$result = array('data' => array());

		$no = 1;
		foreach ($data as $key => $value) :
			$confirm = "return confirm('Are you sure delete this data?')";

			#button action
			$buttons = '
				<a href="#" class="badge badge-success" onclick="edit('.$value->id_event.')">Edit</a>
				<a href="#" onclick="removed('.$value->id_event.')" class="badge badge-danger">Delete</a>
				<a href="'.site_url('event/listing/'.$value->id_event).'"	class="badge badge-primary">List Audience</a>
			';

			if($value->is_active == '1'){
				$status = 'Active';
			}else{
				$status = 'No Active';
			}

			$result['data'][$key] = array(
				$no,
				$value->event_name,
				$value->location,
				$value->time,
				tgl_indo($value->date),
				"Rp ".number_format($value->price),
				$status,
				$buttons
			);

			$no++;
		endforeach;

		return $this->response($result);
	}

	public function list($id)
	{
		$data = $this->Event->get_list($id);

		$result = array('data' => array());

		$no = 1;
		foreach ($data as $key => $value) :
			$confirm = "return confirm('Are you sure delete this data?')";

			if($value->status == '1'){
				$status = '<span class="bg-success text-white" style="display: block; text-align: center">Yes</span>';
				$buttons = '
					<a href="#" onclick="removed('.$value->id_registered.')" class="badge badge-danger">Delete</a>
				';
			}else{
				$status = 'No';
				$buttons = '
					<a href="#" class="badge badge-success" onclick="confirm('.$value->id_registered.')">Present Confirm</a>
					<a href="#" onclick="removed('.$value->id_registered.')" class="badge badge-danger">Delete</a>
				';
			}

			if($value->ostatus == '1'){
				$ostatus = 'PAID';
			}else{
				$ostatus = 'NO PAID';
			}

			$result['data'][$key] = array(
				$no,
				$value->fullname,
				$value->email,
				$value->phone,
				$value->no_ticket,
				tgl_indo($value->date),
				$ostatus,
				$status,
				$buttons
			);

			$no++;
		endforeach;

		return $this->response($result);
	}

	public function show($id = NULL)
	{	
		
		$data = $this->Event->get_data($id);
		return $this->response($data);
	}

	public function confirm($id = NULL)
	{
		$this->db->update('event_register', ['status' => '1'], ['id_registered' => $id]);
		return $this->response(['status' => true, 'message' => 'Data Has Been Updated!']);
		
	}

	public function sorting($sort)
	{	
		
		$data = $this->Event->get_data_sort($sort);
		return $this->response($data);
	}

	public function search()
	{	
		$sort = $this->input->post('keyword');
		$data = $this->Event->get_data_search($sort);
		return $this->response($data);
	}

	public function check(){
		$id_user = $this->input->post('id_user');
		$id_event = $this->input->post('id_event');

		$cek = $this->db->get_where('event_register', ['user_id' => $id_user, 'event_id' => $id_event])->row();
		// return $this->response($cek);

		if($cek != null || $cek != ''){
			return $this->response(['status' => true, 'message' => 'You Have Been Registered!']);
		}else{
			return $this->response(['status' => false, 'message' => 'Please Register!']);
		}
	}

	public function update($id)
	{
		$data = array(
			'event_name' 	=> $this->input->put('event_name'),
			'location'	 	=> $this->input->put('location'),
			'time' 			=> $this->input->put('time'),
			'date'			=> $this->input->put('date'),
			'price' 		=> $this->input->put('price'),
			'is_active' 	=> $this->input->put('status')
		);	

		return $this->response($this->Event->update($data, $id));
	}

	public function store() 
	{
		$this->form_validation->set_rules('event_name', 'Event Name', 'required');
		$this->form_validation->set_rules('location', 'Location', 'required');
		$this->form_validation->set_rules('time', 'Time', 'required');
		$this->form_validation->set_rules('date', 'Date', 'required');
		$this->form_validation->set_rules('price', 'Price', 'required');

		if($this->form_validation->run() === false) :
			$output['status'] = false;

			foreach($_POST as $key => $value) :
				$output['message'][$key] = form_error($key);
			endforeach;

			$this->response($output, 401);
		else: 
			$data = [
				'event_name' 	=> $this->input->post('event_name'),
				'location' 		=> $this->input->post('location'),
				'time' 			=> $this->input->post('time'),
				'date' 			=> $this->input->post('date'),
				'price' 		=> $this->input->post('price'),
				'is_active' 	=> $this->input->post('status'),
			];

			$data = $this->Event->save($data);
			return $this->response(['result' => $data, 'message' => 'Data Has Been Saved!']);
		endif;
	}

	public function delete()
	{	
		$id = $this->input->delete('id');
		
		return $this->response(
			$this->Event->delete($id)
		);
		
	}

	public function delete_event()
	{	
		$id = $this->input->delete('id');
		
		return $this->response(
			$this->Event->delete_event($id)
		);
		
	}

	public function list_delete()
	{	
		$id = $this->input->delete('id_registered');
		
		return $this->response(
			$this->Event->delete($id)
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