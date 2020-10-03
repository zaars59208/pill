<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Twilio\Rest\Client;
class Cron_job extends CI_Controller {
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
			                               "body" => "{$message}",
			                               "from" => "+14425001455"
			                           ]
			                  );

	}
	public function croning(){
		$this->load->model('Handler_db');	
		$original = new DateTime("now", new DateTimeZone('GMT'));
		$data = $this->Handler_db->medication_data();
		foreach($data as $v){
			$phone_number = $this->Handler_db->user_data($v['user_id']);
			$timezoneName = timezone_name_from_abbr("",((int)$phone_number[0]['UTC_val'])*3600, false);
			$modified = $original->setTimezone(new DateTimezone($timezoneName));
			$meal =$v['meal'];
			if($v['once_month'] != "NOP"){
				$data1 = $this->Handler_db->fetch_time($v['Id']);
				foreach($data1 as $v1){
					if($modified->format('H:i:s') >= $v1["time"] && $modified->format('H:i:s') <= date('H:i:s',strtotime($v1['time'])+120) && $modified->format('Y-m-d') == $modified->format('Y-m-01')){
								if($meal == 1){
									$message = "Your medicine intake time alert and have to take with meal: MEDICINE NAME = ".$v['medication_name']." DOSAGE = ".$v['dosage'];
									$this->message_generator($phone_number[0]['phone_number'],$message);
								}
								else{
									$message = "Your medicine intake time alert and have to take without meal: MEDICINE NAME = ".$v['medication_name']." DOSAGE = ".$v['dosage'];
									$this->message_generator($phone_number[0]['phone_number'],$message);
								}
					}
				}
			}
			else if($v['once_day'] != "NOP"){
				if( date('Y-m-d', strtotime($v['once_date']. ' + '.$v['once_day'].' days')) == $modified->format('Y-m-d')){
					$data1 = $this->Handler_db->fetch_time($v['Id']);
					foreach($data1 as $v1){
					    
						if($modified->format('H:i:s') >= $v1["time"] && $modified->format('H:i:s') <= date('H:i:s',strtotime($v1['time'])+120)){
								
								if($meal == 1){
									$message = "Your medicine intake time alert and have to take with meal: MEDICINE NAME = ".$v['medication_name']." DOSAGE = ".$v['dosage'];
									$this->Handler_db->update_date($v['Id'],$modified->format('Y-m-d'));
									print_r("sdas");
									$this->message_generator($phone_number[0]['phone_number'],$message);
								}
								else{
									$message = "Your medicine intake time alert and have to take without meal: MEDICINE NAME = ".$v['medication_name']." DOSAGE = ".$v['dosage'];
									print_r("sdas");
									$this->Handler_db->update_date($v['id'],date("Y-m-d"));
									$this->message_generator($phone_number[0]['phone_number'],$message);
								}
						}
					}
				}

			}
			else{
				$data1 = $this->Handler_db->fetch_week($v['Id']);
				foreach($data1 as $v1){
					foreach($v1 as $e){
						switch($e){
							case "mon":
								$data1 = $this->Handler_db->fetch_time($v['Id']);
								foreach($data1 as $v1){
									if($modified->format('H:i:s') >= $v1["time"] && $modified->format('H:i:s') <= date('H:i:s',strtotime($v1['time'])+120)){
												if($meal == 1){
													$message = "Your medicine intake time alert and have to take with meal: MEDICINE NAME = ".$v['medication_name']." DOSAGE = ".$v['dosage'];
													$this->message_generator($phone_number[0]['phone_number'],$message);
												}
												else{
													$message = "Your medicine intake time alert and have to take without meal: MEDICINE NAME = ".$v['medication_name']." DOSAGE = ".$v['dosage'];
													$this->message_generator($phone_number[0]['phone_number'],$message);
												}
									}
								}
								break;
							case "tues":
								$data1 = $this->Handler_db->fetch_time($v['Id']);
								foreach($data1 as $v1){
									if($modified->format('H:i:s') >= $v1["time"] && $modified->format('H:i:s') <= date('H:i:s',strtotime($v1['time'])+120)){
												
												if($meal == 1){
													$message = "Your medicine intake time alert and have to take with meal: MEDICINE NAME = ".$v['medication_name']." DOSAGE = ".$v['dosage'];
													$this->message_generator($phone_number[0]['phone_number'],$message);
												}
												else{
													$message = "Your medicine intake time alert and have to take without meal: MEDICINE NAME = ".$v['medication_name']." DOSAGE = ".$v['dosage'];
													$this->message_generator($phone_number[0]['phone_number'],$message);
												}
									}
								}
								break;
							case "wed":
								$data1 = $this->Handler_db->fetch_time($v['Id']);
								foreach($data1 as $v1){
									if($modified->format('H:i:s') >= $v1["time"] && $modified->format('H:i:s') <= date('H:i:s',strtotime($v1['time'])+120)){
												
												if($meal == 1){
													$message = "Your medicine intake time alert and have to take with meal: MEDICINE NAME = ".$v['medication_name']." DOSAGE = ".$v['dosage'];
													$this->message_generator($phone_number[0]['phone_number'],$message);
												}
												else{
													$message = "Your medicine intake time alert and have to take without meal: MEDICINE NAME = ".$v['medication_name']." DOSAGE = ".$v['dosage'];
													$this->message_generator($phone_number[0]['phone_number'],$message);
												}
									}
								}
								break;
							case "thurs":
								$data1 = $this->Handler_db->fetch_time($v['Id']);
								foreach($data1 as $v1){
									if($modified->format('H:i:s') >= $v1["time"] && $modified->format('H:i:s') <= date('H:i:s',strtotime($v1['time'])+120)){
												if($meal == 1){
													$message = "Your medicine intake time alert and have to take with meal: MEDICINE NAME = ".$v['medication_name']." DOSAGE = ".$v['dosage'];
													$this->message_generator($phone_number[0]['phone_number'],$message);
												}
												else{
													$message = "Your medicine intake time alert and have to take without meal: MEDICINE NAME = ".$v['medication_name']." DOSAGE = ".$v['dosage'];
													$this->message_generator($phone_number[0]['phone_number'],$message);
												}
									}
								}
								break;
							case "fri":
								$data1 = $this->Handler_db->fetch_time($v['Id']);
								foreach($data1 as $v1){
									if($modified->format('H:i:s') >= $v1["time"] && $modified->format('H:i:s') <= date('H:i:s',strtotime($v1['time'])+120)){
												
												if($meal == 1){
													$message = "Your medicine intake time alert and have to take with meal: MEDICINE NAME = ".$v['medication_name']." DOSAGE = ".$v['dosage'];
													$this->message_generator($phone_number[0]['phone_number'],$message);
												}
												else{
													$message = "Your medicine intake time alert and have to take without meal: MEDICINE NAME = ".$v['medication_name']." DOSAGE = ".$v['dosage'];
													$this->message_generator($phone_number[0]['phone_number'],$message);
												}
									}
								}
								break;
							case "sat":
								$data1 = $this->Handler_db->fetch_time($v['Id']);
								foreach($data1 as $v1){
									if($modified->format('H:i:s') >= $v1["time"] && $modified->format('H:i:s') <= date('H:i:s',strtotime($v1['time'])+120)){
												
												if($meal == 1){
													$message = "Your medicine intake time alert and have to take with meal: MEDICINE NAME = ".$v['medication_name']." DOSAGE = ".$v['dosage'];
													$this->message_generator($phone_number[0]['phone_number'],$message);
												}
												else{
													$message = "Your medicine intake time alert and have to take without meal: MEDICINE NAME = ".$v['medication_name']." DOSAGE = ".$v['dosage'];
													$this->message_generator($phone_number[0]['phone_number'],$message);
												}
									}
								}
								break;
							case "sun":	
								$data1 = $this->Handler_db->fetch_time($v['Id']);
								foreach($data1 as $v1){
									if($modified->format('H:i:s') >= $v1["time"] && $modified->format('H:i:s') <= date('H:i:s',strtotime($v1['time'])+120)){
												
												if($meal == 1){
													$message = "Your medicine intake time alert and have to take with meal: MEDICINE NAME = ".$v['medication_name']." DOSAGE = ".$v['dosage'];
													$this->message_generator($phone_number[0]['phone_number'],$message);
												}
												else{
													$message = "Your medicine intake time alert and have to take without meal: MEDICINE NAME = ".$v['medication_name']." DOSAGE = ".$v['dosage'];
													$this->message_generator($phone_number[0]['phone_number'],$message);
												}
									}
								}
								break;
							
						}
					}
				}
			}
		}

		
	}
}
?>