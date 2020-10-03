<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use Twilio\Rest\Client;
class Admin_con extends CI_Controller {
	public function view_page(){
		$this->load->model('Handler_db');	
		$data['all'] = $this->Handler_db->user_data1();
		$this->load->view('admin', $data);
	}
	public function Remove1(){
		
		$this->load->model('Handler_db');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('delete','Delete','required');
		if($this->form_validation->run())
		{
			$id = $this->input->post('delete');
			$this->Handler_db->remove_data1($id);
			redirect(base_url('index.php/Admin_con/view_page'));
		}
	}


}
?>