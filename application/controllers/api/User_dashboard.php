<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require APPPATH . '/libraries/REST_Controller.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class User_dashboard extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('Mymodel');
    }

	function getVisIpAddr() {
    	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        	return $_SERVER['HTTP_CLIENT_IP'];
    	} else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        	return $_SERVER['HTTP_X_FORWARDED_FOR'];
    	} else {
        	return $_SERVER['REMOTE_ADDR'];
    	}
	}

    public function subscription_details() {
		if(!empty($_SESSION['afrebay']['userId'])) {
			try {
				$vis_ip = $this->getVisIPAddr(); // Store the IP address
				$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $vis_ip));
				$countryName = $ipdat->geoplugin_countryName;
				if($countryName == 'Nigeria') {
					$cond = " WHERE subscription_country = 'Nigeria'";
				} else {
					$cond = " WHERE subscription_country = 'Global'";
				}

				if($_SESSION['afrebay']['userType'] == '1') {
					$uType = 'Freelancer';
				} else {
					$uType = 'Vendor';
				}

				$subscription_check = $this->db->query("SELECT * FROM employer_subscription WHERE employer_id='".$_SESSION['afrebay']['userId']."' AND (status = '1' OR status = '2')")->result_array();
				if(!empty($subscription_check)) {
					$data['current_plan'] = $this->Crud_model->GetData('employer_subscription', '', "employer_id='".$_SESSION['afrebay']['userId']."' AND status IN (1,2)");
					$data['expired_plan'] = $this->Crud_model->GetData('employer_subscription', '', "employer_id='".$_SESSION['afrebay']['userId']."' AND status = '3'");
				} else {
					$data['get_subscription'] = $this->db->query("SELECT * FROM subscription ".$cond." AND subscription_user_type = '".$uType."'")->result();
				}
				$response = array('status'=> 'success','result'=> $data);
			} catch (\Exception $e) {
				$response = array('status'=> 'error','result'=> $e->getMessage());
			}
			echo json_encode($response);
		} else {
			$response = array('status'=> 'error','result'=> 'Oops, You are logged out');
			echo json_encode($response);
		}
    }

	public function userSubscription() {
		if(!empty($_SESSION['afrebay']['userId'])) {
			try {
				$formdata = json_decode(file_get_contents('php://input'), true);
				$paymentDate = date('Y-m-d H:i:s');
				$n=24;
				$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$randomString = '';
				for ($i = 0; $i < $n; $i++) {
					$index = rand(0, strlen($characters) - 1);
					$randomString .= $characters[$index];
				}
				$data = array(
					'employer_id' => $formdata['user_id'],
					'subscription_id' => $formdata['sub_id'],
					'name_of_card' => $formdata['sub_name'],
					'email' => $formdata['user_email'],
					'amount' => $formdata['sub_price'],
					'duration' => $formdata['sub_duration'],
					'transaction_id' => "sub_".$randomString,
					'payment_date' => $paymentDate,
					'created_date' => $paymentDate,
					'payment_status' => 'paid',
					'expiry_date' => date("Y-m-d", strtotime('+'.$formdata['sub_duration'].'days'))
				);
				$this->Crud_model->SaveData('employer_subscription', $data);
				$insert_id = $this->db->insert_id();
				if(!empty($insert_id)) {
					$response = array('status'=> 'success','msg'=> 'Subscription Successful.');
				} else {
					$response = array('status'=> 'error','msg'=> 'Oops, something went wrong. Please try again later.');
				}
				echo json_encode($response);
			} catch (\Exception $e) {
				$response = array('status'=> 'error','msg'=> $e->getMessage());
			}
		} else {
			$response = array('status'=> 'error','result'=> 'Oops, You are logged out');
			echo json_encode($response);
		}
	}

	public function profile_settings() {
		$userid = $_SESSION['afrebay']['userId'];
		if(!empty($userid)) {
			try {
				$user_info = $this->Crud_model->get_single('users', "userId='".$userid."'");
				$data['userinfo'] = $user_info;
				$response = array('status'=> 'success', 'msg'=> $data);
				echo json_encode($response);
			} catch(\Exception $e) {
				$response = array('status'=> 'error','msg'=> $e->getMessage());
				echo json_encode($response);
			}
		} else {
			$response = array('status'=> 'error','result'=> 'Oops, You are logged out');
			echo json_encode($response);
		}
	}

	public function update_profile() {
		$userid = $_SESSION['afrebay']['userId'];
		if(!empty($userid)){
			try {
				if ($_FILES['profilePic']['name'] != '') {
					$_POST['profilePic'] = rand(0000, 9999) . "_" . $_FILES['profilePic']['name'];
					$config2['image_library'] = 'gd2';
					$config2['source_image'] =  $_FILES['profilePic']['tmp_name'];
					$config2['new_image'] =   getcwd() . '/uploads/users/' . $_POST['profilePic'];
					$config2['upload_path'] =  getcwd() . '/uploads/users/';
					$config2['allowed_types'] = 'JPG|PNG|JPEG|jpg|png|jpeg';
					$config2['maintain_ratio'] = FALSE;
					$this->image_lib->initialize($config2);
					if (!$this->image_lib->resize()) {
						echo ('<pre>');
						echo ($this->image_lib->display_errors());
						exit;
					} else {
						$image  = $_POST['profilePic'];
						@unlink('uploads/users/' . $_POST['old_image']);
					}

					if(!empty($this->input->post('key_skills'))) {
						$key_skills = $this->input->post('key_skills');
						for ($i=0; $i < count($key_skills); $i++) {
							$get_specialist = $this->db->query("SELECT * FROM specialist WHERE specialist_name = '".$key_skills[$i]."'")->result();
							if(empty($get_specialist)) {
								$insrt = array(
									'specialist_name'=>ucfirst($key_skills[$i]),
									'created_date'=>date('Y-m-d H:i:s'),
								);
								$this->db->insert('specialist',$insrt);
							}
						}
						$skills = implode(", ",$this->input->post('key_skills',TRUE));
					} else {
						$skills = '';
					}
				} else {
					$image  = $_POST['old_image'];
				}

				$data = array(
					'companyname' => $_POST['companyname'],
					'firstname' => $_POST['firstname'],
					'lastname' => $_POST['lastname'],
					'email' => $_POST['email'],
					'mobile' => $_POST['mobile'],
					'gender' => $this->input->post('gender', TRUE),
					'skills' => $skills,
					'profilePic' => $image,
					'zip' => $_POST['zip'],
					'address' => $_POST['address'],
					'foundedyear' => $_POST['foundedyear'],
					'teamsize' => $_POST['teamsize'],
					'latitude' => $_POST['latitude'],
					'longitude' => $_POST['longitude'],
					'short_bio' => $_POST['short_bio']
				);
				//print_r($data); exit;
				$updateProfile = $this->db->query("UPDATE users SET companyname = '".$_POST['companyname']."', firstname = '".$_POST['firstname']."', lastname = '".$_POST['lastname']."', email = '".$_POST['email']."', mobile = '".$_POST['mobile']."', gender = '".$_POST['gender']."', skills = '".$skills."', profilePic = '".$image."', zip = '".$_POST['zip']."', address = '".$_POST['address']."', foundedyear = '".$_POST['foundedyear']."', teamsize = '".$_POST['teamsize']."', latitude = '".$_POST['latitude']."', longitude = '".$_POST['longitude']."', short_bio = '".$_POST['short_bio']."' WHERE userId = '".$userid."'");
				if($updateProfile > 0){
					$response = array('status'=> 'success','msg'=> 'Profile updated successfully');
				} else {
					$response = array('status'=> 'error','msg'=> 'Oops, Something went wrong please try again later');
				}
				echo json_encode($response);
			} catch(\Exception $e) {
				$response = array('status'=> 'error','msg'=> $e->getMessage());
				echo json_encode($response);
			}
		} else {

		}

	}
}
