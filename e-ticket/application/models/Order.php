<?php

class Order extends CI_Model {


	public function get_data($value = null)
	{
		
		$this->db->order_by('id_order', 'DESC');
		$this->db->join('user', 'user.id_user = orders.user_id');
		$this->db->join('event', 'event.id_event = orders.event_id');
		if($value != null ){
			$this->db->where('user_id', $value);
		}

		return $this->db->get('orders')->result();
	}

	public function save($data, $reg){
		$conf 	= $this->db->insert('orders', $data);
		$reg 	= $this->db->insert('event_register', $reg);

		if($conf && $reg) {
			return [
				'id' => $this->db->insert_id(),
				'status' => true,
				'message' => 'Data Order berhasil disimpan'
			];
		}
	}

	public function delete($id)
	{
		$this->db->where('id_order', $id);
		$delete = $this->db->delete('orders');

		if($delete) {
			return [
	  		'status' => true,
	  		'message' => 'Event Has Been Deleted!' 
	  	];
		}
	}
}
