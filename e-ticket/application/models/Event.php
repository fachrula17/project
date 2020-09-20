<?php

class Event extends CI_Model {

	public function register($email, $password) 
	{
		$data = [
			'email' => $email,
			'password' => password_hash($password, PASSWORD_DEFAULT)
		];

		$user = $this->db->insert('user', $data);
		if($user) {
			return [
				'id' => $this->db->insert_id(),
				'status' => true,
				'message' => 'Data Users berhasil disimpan'
			];
		}
	}

	public function update($data, $id)
	{

		$this->db->where('id_event', $id);
		$update = $this->db->update('event', $data);

		if($update) {
			return [
		  		'status' => TRUE,
		  		'message' => 'Event Has Been Updated!' 
		  	];
		}
	}

	public function get_data($value = null)
	{
		if($value !== null) {
			$user = $this->db->get_where('event', ['id_event' => $value]);
			return $user->row();
		}

		$this->db->order_by('id_event', 'DESC');
		return $this->db->get_where('event', ['is_active' => '1'])->result();
	}

	public function get_list($value = null)
	{
		$this->db->select('event_register.*, orders.status as ostatus, user.*');
		$this->db->order_by('id_registered', 'DESC');
		$this->db->join('user', 'user.id_user = event_register.user_id');
		$this->db->join('orders', 'orders.no_ticket = event_register.no_ticket');
		return $this->db->get_where('event_register', ['event_register.event_id' => $value])->result();
	}

	public function get_data_sort($value = null)
	{
		if($value == 'new'){
			$order = 'id_event';
		}else{
			$order = 'price';
		}
		$this->db->order_by($order, 'DESC');
		return $this->db->get_where('event', ['is_active' => '1'])->result();
	}

	public function get_data_search($value = null)
	{
		
		$this->db->order_by('id_event', 'DESC');

		if($value !== ''){
			$this->db->like('event_name', $value);
		}
		
		return $this->db->get_where('event', ['is_active' => '1'])->result();
	}

	public function save($value = null)
	{
		$this->db->insert('event', $value);
	}

	public function is_login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$user = $this->get_data('username', $username);
		$hash = $user->password;

		if(password_verify($password, $hash)) {
			return true;
		}

		return false;
	}

	public function delete($id)
	{
		$this->db->where('id_registered', $id);
		$delete = $this->db->delete('event_register');

		if($delete) {
			return [
	  		'status' => true,
	  		'message' => 'Event Has Been Deleted!' 
	  	];
		}
	}

	public function delete_event($id)
	{
		$this->db->where('id_event', $id);
		$delete = $this->db->delete('event');

		if($delete) {
			return [
	  		'status' => true,
	  		'message' => 'Event Has Been Deleted!' 
	  	];
		}
	}
}
