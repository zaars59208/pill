<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Twilio\Rest\Client;
class Otp extends CI_Controller {
	public function index()
	{
	    
		$data['pageName'] = 'login';
		$this->load->view('starter',$data);
	}

	public function verify()
	{
		$this->load->model('Handler_db');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('date_time','DATETIME','required');
		$this->form_validation->set_rules('phone_number','PHONENUMBER','required');
		if($this->form_validation->run())
		{
			$GMT_code = $this->input->post('date_time');
			$phone_number = $this->input->post('phone_number');
			$countrycode = $this->input->post('countryCode');
			$number = "+".$countrycode.$phone_number;
			if($this->Handler_db->val_pho($number)){
				$session_data = array(
				 	'phone_number'=>$number
				 );	
				$randomNumber = rand(000000,999999);
				$this->message_generator($number,$randomNumber);
				$this->session->set_userdata($session_data);
				$this->Handler_db->insert_user_details($number,$randomNumber,$GMT_code);
				redirect(base_url('index.php/Otp/otp_verify_page'));
			}
			else{
				$session_data = array(
				 	'phone_number'=>$number
				 );
				$randomNumber = rand(000000,999999);
				$this->message_generator($number,$randomNumber);
				$this->session->set_userdata($session_data);
				$this->Handler_db->update_otp($number,$randomNumber);
				redirect(base_url('index.php/Otp/otp_verify_page'));
			}
		}
		else
		{
			$this->index();
		}
		
		
	}
	public function message_generator($phone_number,$message){

			// Update the path below to your autoload.php,
			// see https://getcomposer.org/doc/01-basic-usage.md
			require_once 'vendor/autoload.php';

			

			// Find your Account Sid and Auth Token at twilio.com/console
			// DANGER! This is insecure. See http://twil.io/secure
			$sid    = "AC4474a12ece60444185210af5afbc778c";
			$token  = "99e6949fa6f4d56b619c6b8c5b14174b";
			$twilio = new Client($sid, $token);

			$message = $twilio->messages
			                  ->create($phone_number, 
			                           [
			                               "body" => "THIS IS YOUR OTP CODE: {$message}",
			                               "from" => "+14425001455"
			                           ]
			                  );
	}
	public function otp_verify_page(){
		if($this->session->userdata('phone_number')!=""){
			$this->load->view('verifying');
		}
		else{
			redirect(base_url('index.php/Otp/index'));
		}
	}

	public function otp_verification_process(){
		$this->load->model('Handler_db');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('otp','OTP','required');
		if($this->form_validation->run())
		{
			$otp = $this->input->post('otp');
			if($this->Handler_db->validation_phone_number($this->session->userdata('phone_number'),$otp)){
				$data =array('Id' => $this->Handler_db->id_getter($this->session->userdata('phone_number'),$otp)[0]['Id']);
				$this->session->set_userdata($data);
				redirect(base_url("index.php/Otp/main_menu"));
			}
			else{
				redirect(base_url("index.php/Otp/index"));
			}
		}
	}
	public function main_menu()
	{
		if(isset($_SESSION['Id'])){
			$data['pageName']= 'main/main_page';
			$this->load->view('main_menu',$data);
		}
		else{
			redirect(base_url('index.php/Otp/index'));
		}
	}
	public function med_list()
	{	
		$this->load->model('Handler_db');

		if(isset($_SESSION['Id'])){
			$data['med_name'] = $this->Handler_db->fetch_data($this->session->userdata('Id'));
			$data['pageName'] = 'Show_list/med_list';
			$this->load->view('list_page',$data);
		}
		else{
			redirect(base_url('index.php/Otp/index'));
		}	
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url('index.php/Otp/index'));
	}



	public function Remove(){
		
		$this->load->model('Handler_db');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('delete','Delete','required');
		if($this->form_validation->run())
		{
			$id = $this->input->post('delete');
			$this->Handler_db->remove_data($id);
			redirect(base_url('index.php/Otp/med_list'));
		}
	}





	public function add_med(){
		$this->load->model('Handler_db');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('m_name','M_name','required');
		$this->form_validation->set_rules('dosage','Dosage','required');
		if($this->form_validation->run()){
			$med_name = $this->input->post('m_name');
			$dosage = $this->input->post('dosage');
			$meal = $this->input->post('intake');
			$time = $this->input->post('appt');
			$checker = $this->input->post('optradio');
			$onceevery = "NOP";
			$weekly = "NOP";
			$oncemonth = "NOP";
			if(!empty($meal)){
				$meal = 1;
			}
			else{
				$meal = 0;
			}
			if($checker == "onceevery"){
				$onceevery = "every";
				$onceevery = $this->input->post('once_day');
				if(!empty($time)){
					$this->Handler_db->add_medic($med_name,$dosage,$this->session->userdata('Id'),$onceevery,$oncemonth,$meal,$time,$weekly,date("Y-m-d"));
					$dat = array(
						'success_message'=>"Your Pill Reminder Was Successfully Added"
					);
					$this->session->set_userdata($dat);
					redirect(base_url("index.php/Otp/med_list"));
				}
				else{
					redirect(base_url("index.php/Otp/main_menu"));
				}
			}
			else if($checker == "weekly"){
				$weekly = $this->input->post('week');
				if(!empty($weekly) && !empty($time)){
					$this->Handler_db->add_medic($med_name,$dosage,$this->session->userdata('Id'),$onceevery,$oncemonth,$meal,$time,$weekly,"NOP");
					$dat = array(
						'success_message'=>"Your Pill Reminder Was Successfully Added"
					);
					$this->session->set_userdata($dat);
					redirect(base_url("index.php/Otp/med_list"));
				}
				else{
					redirect(base_url("index.php/Otp/main_menu"));
				}
			}	
			else if($checker == "oncemonth"){
				$oncemonth = "month";
				if(!empty($time)){
					$this->Handler_db->add_medic($med_name,$dosage,$this->session->userdata('Id'),$onceevery,$oncemonth,$meal,$time,$weekly,"NOP");
					$dat = array(
						'success_message'=>"Your Pill Reminder Was Successfully Added"
					);
					$this->session->set_userdata($dat);
					redirect(base_url("index.php/Otp/med_list"));
				}
				else{
					redirect(base_url("index.php/Otp/main_menu"));
				}
			}
		}	
	}
}
