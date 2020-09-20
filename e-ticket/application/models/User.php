<?php

class User extends CI_Model {

	public function register($data) 
	{

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

		$this->db->where('id_admin', $id);
		$update = $this->db->update('admin', $data);

		if($update) {
			return [
	  		'status' => true,
	  		'message' => 'Data admin berhasil update' 
	  	];
		}
	}

	public function get_data($key = null, $value = null)
	{
		if($key !== null) {
			$user = $this->db->get_where('admin', [$key => $value, 'is_active' => '1']);
			return $user->row();
		}

		return $this->db->get('admin')->result();
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
		$this->db->where('id', $id);
		$delete = $this->db->delete('user');

		if($delete) {
			return [
	  		'status' => true,
	  		'message' => 'Data users berhasil dihapus' 
	  	];
		}
	}
}
