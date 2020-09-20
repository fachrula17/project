<?php

class Member extends CI_Model {

	public function register($data, $token) 
	{
		$user = $this->db->insert('user', $data);
		$token = $this->db->insert('user_token', $token);
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

		$this->db->where('id_user', $id);
		$update = $this->db->update('user', $data);

		if($update) {
			return [
	  		'status' => true,
	  		'message' => 'Data users berhasil update' 
	  	];
		}
	}

	public function get_data($key = null, $value = null)
	{
		if($key !== null) {
			$user = $this->db->get_where('user', [$key => $value, 'is_active' => '1']);
			return $user->row();
		}

		return $this->db->get('user')->result();
	}

	public function get_data_admin($key = null, $value = null)
	{
		if($key !== null) {
			$user = $this->db->get_where('admin', [$key => $value]);
			return $user->row();
		}

		return $this->db->get('admin')->result();
	}

	public function is_login()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$user = $this->get_data('email', $email);
		$hash = $user->password;

		if(password_verify($password, $hash)) {
			return true;
		}

		return $hash;
	}

	public function delete($id)
	{
		$this->db->where('id_user', $id);
		$delete = $this->db->delete('user');

		if($delete) {
			return [
		  		'status' => $this->db->last_query(),
		  		'message' => 'Data users berhasil dihapus' 
		  	];
		}
	}

	public function save($data){
		$deposit = $this->db->insert('deposit', $data);
		if($deposit) {
			return [
				'id' => $this->db->insert_id(),
				'status' => true,
				'message' => 'Data Deposit berhasil disimpan'
			];
		}
	}
}
