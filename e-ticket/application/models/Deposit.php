<?php

class Deposit extends CI_Model {

	public function get_data($value = null)
	{
		
		$this->db->order_by('id_deposit', 'DESC');
		$this->db->join('user', 'user.id_user = deposit.user_id');

		if($value != null ){
			$this->db->where('user_id', $value);	
		}

		return $this->db->get('deposit')->result();
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
		$this->db->where('id_deposit', $id);
		$delete = $this->db->delete('deposit');

		if($delete) {
			return [
	  		'status' => true,
	  		'message' => 'Event Has Been Deleted!' 
	  	];
		}
	}
}
