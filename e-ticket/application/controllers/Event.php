<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['title'] = 'List Event';

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('event/index', $data);
		$this->load->view('templates/footer');
	
	}

	public function listing($id)
	{
		$data['title'] = 'List Peserta';
		$data['user'] = $this->db->get_where('user', 
			['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('backend/templates/header', $data);
		$this->load->view('backend/templates/sidebar', $data);
		$this->load->view('backend/templates/topbar', $data);
		$this->load->view('backend/coaching/list', $data);
		$this->load->view('backend/templates/footer');
		
	}

	public function getList($id)
	{
		$result = array('data' => array());

		$this->db->select('user_profile.address,user_profile.photo, user.fullname, user.email, coaching_register.*');
		$this->db->join('user', 'user.id = coaching_register.member_id');
		$this->db->join('user_profile', 'user_profile.user_id = user.id');
		$data = $this->db->get_where('coaching_register', ['coaching_id' => $id])->result_array();

		// print_r($data);die;

		$no = 1;
		foreach ($data as $key => $value) :
			$confirm = "return confirm('Are you sure delete this data?')";

			#button action
			$buttons = '
				<a href="'.site_url('event/delete-register/'.$value['cr_id']).'" onclick="'.$confirm.'" 
					class="badge badge-danger">Delete</a>
			';


			$result['data'][$key] = array(
				$no,
				$value['fullname'],
				$value['email'],
				$value['address'],
				$value['price'],
				"<a href='".base_url('assets/member/').$value['photo']."' data-lightbox='image-1' data-title='".$value['fullname']."'><img src='".base_url('assets/member/').$value['photo']."' width='90'></a>",
				tgl_indo($value['datetime']),
				$buttons
			);

			$no++;
		endforeach;

		echo json_encode($result);
	}

	public function printTicket($no)
	{
		$data['title'] = 'Ticket No : '.$no;

		$this->db->select('event_register.*, event_register.date as datereg ,event.*, event.date as eventdate, user.*, orders.status as ostatus');
		$this->db->join('user', 'user.id_user = event_register.user_id');
		$this->db->join('event', 'event.id_event = event_register.event_id');
		$this->db->join('orders', 'orders.no_ticket = event_register.no_ticket');
		$detail = $this->db->get_where('event_register', ['event_register.no_ticket' => $no])->row();
		// print_r($detail);die;
		if($detail->ostatus == '1'){
			$status = 'CONFIRM';
		}else{
			$status = 'NOT CONFIRM';
		}
		$mpdf = new \Mpdf\Mpdf();
		$html = '<!DOCTYPE html>
			<html lang="en">
			<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				
				<title>Ticket</title>
				<style>
					.title {background: #34495e; color: #ffffff; padding: 5px; text-align: center}
					.content {display: flex}
					.content-box {flex-grow : 1}
					table {width: 100%}
					td {padding: 10px 0}
					h3 {margin: 0}
				</style>
			</head>
			  <body>
			    <div class="title"><h3>Ticket No. '.$this->uri->segment(2).'</h3></div> 
			    <table border="0">
			    	<tr>
			    		<td>Name : '.$detail->fullname.'</td>
			    		<td align="right">'.tgl_indo($detail->datereg).'</td>
			    	</tr>
			    	<tr>
			    		<td colspan="2" align="center"><h2>'.$detail->event_name.'</h2></td>
			    	</tr>
			    	<tr>
			    		<td colspan="2" align="center" style="padding: 0"><h3>Location : '.$detail->location.' | Time : '.$detail->time.'</h3></td>
			    	</tr>
			    	<tr>
			    		<td></td>
			    	</tr>
			    	<tr>
			    		<td colspan="2" style=" border-bottom: 1px solid #34495e; padding-bottom: 10px; text-align: center"><p>Date : '.tgl_indo($detail->eventdate).'</p></td>
			    	</tr>
			    	<tr>
			    		<td></td>
			    	</tr>
			    	<tr>
			    		<td colspan="2" align="center" style="background: #2ecc71; width: 100%; color: white;"><h2>'.$status.'</h2>
			    		</td>
			    	</tr>
			    </table>
			  </body>
			  </html>';

		$mpdf->WriteHTML($html);
		$mpdf->Output();
	}
}