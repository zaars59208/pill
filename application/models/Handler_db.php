<?php
	class Handler_db extends CI_model{
		public function fetch_time($id){
			$this->db->select('time');
			$this->db->where('medication_id',$id);
			$query = $this->db->get('times')->result_array();
			return $query;
		}
		public function fetch_week($id){
			$this->db->select('week');
			$this->db->where('medication_id',$id);
			$query = $this->db->get('week')->result_array();
			return $query;
		}
        public function user_data1(){
			$this->db->select('Id,phone_number,UTC_val');
			$query = $this->db->get('users')->result_array();
			return $query;
		}
		public function update_date($id,$date){
		    $data = array(
               'once_date' => $date
            );
			$this->db->where('Id', $id);
			$this->db->update('medication', $data);
		}
		public function remove_data1($id){
			$this->db->select('Id');
			$this->db->where('user_id',$id);
			$query = $this->db->get('medication')->result_array();
			foreach ($query as $value) {
				$this->db->where('medication_id', $value['Id']);
				$this->db->delete('week');
				$this->db->where('medication_id',$value['Id']);
				$this->db->delete('times');
			}
			
			$this->db->where('user_id', $id);
			$this->db->delete('medication');
			$this->db->where('Id', $id);
			$this->db->delete('users');
		}
		public function medication_data(){
			$this->db->select('Id,user_id,medication_name,dosage,once_day,once_month,meal,once_date');
			$query = $this->db->get('medication')->result_array();
			return $query;
		}
		public function user_data($id){
			$this->db->select('phone_number,UTC_val');
			$this->db->where('Id',$id);
			$query = $this->db->get('users')->result_array();
			return $query;
		}
		public function validation_phone_number($phone_number,$password){
			// $user_details= $this->db->query("SELECT * FROM users")->result_array();
			// $user_details=$this->db->get('users')->result_array();

			$this->db->where('phone_number',$phone_number);
			$this->db->where('password',$password);
			$query = $this->db->get('users');
			if($query->num_rows() > 0 ){
				return true;
			}
			else{
				return false;
			}
			
		}
		public function insert_user_details($phone_number,$password,$gmt){
			$data = array(
			   'phone_number' => $phone_number,
			   'password' => $password ,
			   'UTC_val'=> $gmt
			);
			$this->db->insert('users',$data);

		}
		public function val_pho($phone_number){

			$this->db->where('phone_number',$phone_number);
			$query = $this->db->get('users');
			if($query->num_rows() > 0 ){
				return false;
			}
			else{
				return true;
			}
		}
		public function update_otp($phone_number,$password){
			$data = array(
               'password' => $password
            );
			$this->db->where('phone_number', $phone_number);
			$this->db->update('users', $data);
		}
		public function id_getter($phone_number,$password){
			$this->db->select('Id');
			$this->db->where('phone_number',$phone_number);
			$this->db->where('password',$password);
			$query = $this->db->get('users')->result_array();
			return $query;
		}
		public function fetch_data($Id){
			
			$this->db->select('medication.Id,medication_name,dosage,once_day,once_month');
			$this->db->from('users');
			$this->db->join('medication','medication.user_id = users.Id','inner');
			$this->db->where('users.Id',$Id);
			$query = $this->db->get()->result_array();
			$data = array();
			$count=0;
			foreach($query as $e){
			    $this->db->select('time');
			    $this->db->from('times');
			    $this->db->join('medication','medication.Id = times.medication_id','inner');
			    $this->db->where('times.medication_id',$e['Id']);
			    $data = $this->db->get()->result_array();
			    $temp = "";
			    foreach($data as $r){
			        if($r['time'] >= "11:59:59"){
			            $temp=$temp.$r['time']." PM,";
			        }
			        else{
			            $temp=$temp.$r['time']." AM,";
			        }
			    }
			    $query[$count]['time'] = $temp;
			    if($query[$count]['once_day'] != "NOP"){
			        $query[$count]['recurrence'] = 'Once Every '.$query[$count]['once_day'].' Day';
			    }
			    else if($query[$count]['once_month'] != "NOP"){
			        $query[$count]['recurrence'] = 'Once Per Month';
			    }
			    else{
			        $this->db->select('week');
    			    $this->db->from('week');
    			    $this->db->join('medication','medication.Id = week.medication_id','inner');
    			    $this->db->where('week.medication_id',$e['Id']);
    			    $data1 = $this->db->get()->result_array();
			        $temp1="";
			        foreach($data1 as $r){
			            $temp1=$temp1.$r['week'].", ";
    			    }
			        $query[$count]['recurrence'] = 'Once Per Day: '.$temp1;
			    }
			    $count = $count +1;
			}
			return $query;
		

		}
		public function remove_data($id){
			$this->db->where('medication_id', $id);
			$this->db->delete('week');
			$this->db->where('medication_id', $id);
			$this->db->delete('times');
			$this->db->where('Id', $id);
			$this->db->delete('medication');
		}
		public function add_medic($med_name,$dosage,$id,$o_day,$o_month,$meal,$time,$weekly,$date){
			if($weekly == "NOP"){
				$data = array(
					'medication_name'=>$med_name,
					'dosage'=>$dosage,
					'user_id'=>$id,
					'once_day'=>$o_day,
					'once_month'=>$o_month,
					'meal'=>$meal,
					'once_date'=>$date
				);
				$this->db->insert('medication',$data);
				$this->db->select_max('Id');
				$ID = $this->db->get('medication')->result_array();
				foreach($time as $v){
					$data1 = array(
						'medication_id'=>$ID[0]['Id'],
						'time'=> $v
					);
					$this->db->insert('times',$data1);
				}
			}
			else{
				$data = array(
					'medication_name'=>$med_name,
					'dosage'=>$dosage,
					'user_id'=>$id,
					'once_day'=>$o_day,
					'once_month'=>$o_month,
					'meal'=>$meal,
					'once_date'=>$date
				);
				$this->db->insert('medication',$data);
				$this->db->select_max('Id');
				$ID = $this->db->get('medication')->result_array();
				foreach($time as $v){
					$data1 = array(
						'medication_id'=>$ID[0]['Id'],
						'time'=> $v
					);
					$this->db->insert('times',$data1);
				}
				foreach($weekly as $v){
					$data1 = array(
						'medication_id'=>$ID[0]['Id'],
						'week'=> $v
					);
					$this->db->insert('week',$data1);
				}
			}
		}
	}
?>