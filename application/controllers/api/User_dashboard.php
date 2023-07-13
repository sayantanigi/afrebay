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
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$user_id = $formdata['user_id'];
			$userType = $formdata['user_type'];
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

			$subscription_check = $this->db->query("SELECT * FROM employer_subscription WHERE employer_id='".@$user_id."' AND (status = '1' OR status = '2')")->result_array();
			if(!empty($subscription_check)) {
				$data['current_plan'] = $this->Crud_model->GetData('employer_subscription', '', "employer_id='".@$user_id."' AND status IN (1,2)");
				$data['expired_plan'] = $this->Crud_model->GetData('employer_subscription', '', "employer_id='".@$user_id."' AND status = '3'");
			} else {
				$data['get_subscription'] = $this->db->query("SELECT * FROM subscription ".$cond." AND subscription_user_type = '".$uType."'")->result();
			}
			$response = array('status'=> 'success','result'=> $data);
		} catch (\Exception $e) {
			$response = array('status'=> 'error','result'=> $e->getMessage());
		}
		echo json_encode($response);
	}

	public function userSubscription() {
		if(!empty(@$_SESSION['afrebay']['userId'])) {
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
					'employer_id' => @$_SESSION['afrebay']['userId'],
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
		$userid = @$user_id = $_GET['user_id'];
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
				'user_id' => $_POST['user_id'],
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
			$updateProfile = $this->db->query("UPDATE users SET companyname = '".$_POST['companyname']."', firstname = '".$_POST['firstname']."', lastname = '".$_POST['lastname']."', email = '".$_POST['email']."', mobile = '".$_POST['mobile']."', gender = '".$_POST['gender']."', skills = '".$skills."', profilePic = '".$image."', zip = '".$_POST['zip']."', address = '".$_POST['address']."', foundedyear = '".$_POST['foundedyear']."', teamsize = '".$_POST['teamsize']."', latitude = '".$_POST['latitude']."', longitude = '".$_POST['longitude']."', short_bio = '".$_POST['short_bio']."' WHERE userId = '".$_POST['user_id']."'");
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
	}

	public function education_list() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$userid = $formdata['user_id'];
			$education_list = $this->Crud_model->GetData('user_education', '', "user_id='".@$userid."' order by id DESC");
			if(!empty($education_list)) {
				$response = array('status'=> 'success','msg'=> $education_list);
			} else {
				$response = array('status'=> 'error','msg'=> 'No Data Found');
			}
		} catch (\Exception $e) {
			$response = array('status'=> 'error','msg'=> $e->getMessage());
		}
		echo json_encode($response);
	}

	public function save_education() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$data = array(
				'user_id' => $formdata['user_id'],
				'education' => $formdata['education'],
				'passing_of_year' => $formdata['passing_of_year'],
				'college_name' => $formdata['college_name'],
				'department' => $formdata['department'],
				'description' => $formdata['description'],
				'created_date' => date('Y-m-d H:i:s'),
			);
			$this->Crud_model->SaveData('user_education', $data);
			$response = array('status'=> 'success', 'msg'=> 'Education Created Successfully !');
		} catch (\Exception $e) {
			$response = array('status'=> 'error','msg'=> $e->getMessage());
		}
		echo json_encode($response);
	}

	public function get_educationDetails() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$education_id = $formdata['id'];
			$get_education = $this->Crud_model->get_single('user_education', "id='" . $education_id . "'");
			$response = array('status'=> 'success', 'msg'=> $get_education);
		} catch (\Exception $e) {
			$response = array('status'=> 'error','msg'=> $e->getMessage());
		}
		echo json_encode($response);
	}

	public function update_education() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$data = array(
				'education' => $formdata['education'],
				'passing_of_year' => $formdata['passing_of_year'],
				'college_name' => $formdata['college_name'],
				'department' => $formdata['department'],
				'description' => $formdata['description'],
				'id' => $formdata['id']
			);
			$this->Crud_model->SaveData('user_education', $data, "id='".$formdata['id']."'");
			$response = array('status'=> 'success', 'msg'=> 'Education Updated Successfully !');
		} catch (\Exception $e) {
			$response = array('status'=> 'error','msg'=> $e->getMessage());
		}
		echo json_encode($response);
	}

	public function delete_education() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$education_id = $formdata['id'];
			$this->Crud_model->DeleteData('user_education', "id='".$education_id."'");
			$response = array('status'=> 'success', 'msg'=> 'Education Deleted successfully !');
		} catch (\Exception $e) {
			$response = array('status'=> 'error','msg'=> $e->getMessage());
		}
		echo json_encode($response);
	}

	public function workexperience_list() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$user_id = $_GET['user_id'];
			$workexperience_list = $this->Crud_model->GetData('user_workexperience', '', "user_id='".$user_id."' order by id DESC");
			if(!empty($workexperience_list)) {
				$response = array('status'=> 'success','msg'=> $workexperience_list);
			} else {
				$response = array('status'=> 'error','msg'=> 'No Data Found');
			}
			echo json_encode($response);
		} catch (\Exception $e) {
			$response = array('status'=> 'error','msg'=> $e->getMessage());
			echo json_encode($response);
		}
	}

	public function save_workexperience() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$data = array(
				'user_id' => $formdata['user_id'],
				'designation' => $formdata['designation'],
				'company_name' => $formdata['company_name'],
				'from_date' => $formdata['from_date'],
				'to_date' => $formdata['to_date'],
				'description' => $formdata['description'],
				'created_date' => date('Y-m-d H:i:s'),
			);
			$this->Crud_model->SaveData('user_workexperience', $data);
			$response = array('status'=> 'success', 'msg'=> 'Work Experience Created Successfully !');
		} catch (\Exception $e) {
			$response = array('status'=> 'error','msg'=> $e->getMessage());
		}
		echo json_encode($response);
	}

	public function get_workexperience() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$work_id = $formdata['id'];
			$get_workexperience = $this->Crud_model->get_single('user_workexperience', "id='".$work_id."'");
			$response = array('status'=> 'success', 'msg'=> $get_workexperience);
		} catch (\Exception $e) {
			$response = array('status'=> 'error','msg'=> $e->getMessage());
		}
		echo json_encode($response);
	}

	public function update_workexperience() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$data = array(
				'designation' => $formdata['designation'],
				'company_name' => $formdata['company_name'],
				'from_date' => $formdata['from_date'],
				'to_date' => $formdata['to_date'],
				'description' => $formdata['description'],
				'id' => $formdata['id']
			);
			$this->Crud_model->SaveData('user_workexperience', $data, "id='".$formdata['id']."'");
			$response = array('status'=> 'success', 'msg'=> 'Work Experience Updated Successfully !');
		} catch (\Exception $e) {
			$response = array('status'=> 'error','msg'=> $e->getMessage());
		}
		echo json_encode($response);
	}

	public function delete_workexperience() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$work_id = $formdata['id'];
			$this->Crud_model->DeleteData('user_workexperience', "id='".$work_id."'");
			$response = array('status'=> 'success', 'msg'=> 'Work Experience Deleted successfully !');
		} catch (\Exception $e) {
			$response = array('status'=> 'error','msg'=> $e->getMessage());
		}
		echo json_encode($response);
	}

	public function save_postbid() {
		try{
			$formdata = json_decode(file_get_contents('php://input'), true);
			$data = array(
				'postjob_id' => $formdata['postjob_id'],
				'user_id' => $formdata['user_id'],
				'bid_amount' => $formdata['bid_amount'],
				'currency' => $formdata['currency'],
				'duration' => $formdata['duration'],
				'description' => $formdata['description'],
				'created_date' => date('Y-m-d H:i:s'),
			);
			$this->Crud_model->SaveData('job_bid', $data);
			$insert_id = $this->db->insert_id();
			if(!empty($insert_id)) {
				$response = array('status'=> 'success', 'msg'=> 'Bid Submitted Successfully! You will be notified once the Vendor has approved your bid');
			} else {
				$response = array('status'=> 'success', 'msg'=> 'Something went wrong. Please try again later.');
			}
			echo json_encode($response);
		} catch(\Exception $e) {
			$response = array(''=> '', ''=> $e->getMessage());
			echo json_encode($response);
		}
	}

	public function jobbid() {
		$this->load->model('Post_job_model');
		try{
			$formdata = json_decode(file_get_contents('php://input'), true);
			$userType = $formdata['user_type'];
			if($userType == '1'){
				$cond = "job_bid.user_id='".@$formdata['user_id']."'";
			} else {
				$cond = "postjob.user_id='".@$formdata['user_id']."'";
			}
			$get_postjob = $this->Post_job_model->postjob_bid($cond);
			if(!empty($get_postjob)) {
				$response = array('status'=> 'success', 'msg'=> $get_postjob);
			} else {
				$response = array('status'=> 'error', 'msg'=> 'No Data Found');
			}
			echo json_encode($response);
		} catch (\Exception $e) {
			$response = array('status'=> 'error', 'msg'=> $e->getMessage());
			echo json_encode($response);
		}
	}

	function delete_job() {
		try{
			$formdata = json_decode(file_get_contents('php://input'), true);
			$jobbid_id = $formdata['id'];
			$delete_prod = $this->db->query("DELETE FROM postjob WHERE id = '$jobbid_id'");
			if($delete_prod > 0){
				$response = array('status'=> 'success','msg'=> 'Job deleted successfully');
			} else {
				$response = array('status'=> 'error','msg'=> 'Something went wrong. Please try again later');
			}
		} catch (\Exception $e) {
			$response = array('status'=> 'error','msg'=> $e->getMessage());
		}
		echo json_encode($response);
	}

	public function myjob() {
		try{
			$formdata = json_decode(file_get_contents('php://input'), true);
			$userid = $formdata['user_id'];
			$get_postjob = $this->Crud_model->GetData('postjob', '', "user_id='".$userid."'");
			if(!empty($get_postjob)) {
				$response = array('status'=> 'success', 'msg'=> $get_postjob);
			} else {
				$response = array('status'=> 'success', 'msg'=> 'No data found');
			}
			echo json_encode($response);
		} catch(\Exception $e) {
			$response = array('status'=> 'error', 'msg'=> $e->getMessage());
			echo json_encode($response);
		}
	}

	public function edit_post_job() {
		try{
			$formdata = json_decode(file_get_contents('php://input'), true);
			$postid = $formdata['post_id'];
			$update_data = $this->Crud_model->get_single('postjob', "id='".$postid."'");
			if(!empty($update_data)) {
				$data = array(
					'post_title' => $update_data->post_title,
					'description' => $update_data->description,
					//'duration' => $update_data->duration,
					'key_skills' => $update_data->required_key_skills,
					'duration' => $update_data->duration,
					'charges' => $update_data->charges,
					'currency' => $update_data->currency,
					'category' => $update_data->category_id,
					'subcategory' => $update_data->subcategory_id,
					'appli_deadeline' => $update_data->appli_deadeline,
					'countries' => $update_data->country,
					'state' => $update_data->state,
					'cities' => $update_data->city,
					'location' => $update_data->location,
					'latitude' => $update_data->latitude,
					'longitude' => $update_data->longitude,
					'id' => $postid,
				);
				$response = array('status'=> 'success', 'msg'=> $data);
			} else {
				$response = array('status'=> 'error', 'msg'=> 'No data found');
			}
			echo json_encode($response);
		} catch(\Exception $e) {
			$response = array('status'=> 'error', 'msg'=> $e->getMessage());
			echo json_encode($response);
		}
	}

	public function update_post_job() {
		try{
			$formdata = json_decode(file_get_contents('php://input'), true);
			$key_skills = $formdata['key_skills'];
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
			$data=array(
				'id'=> $formdata['id'],
				'post_title'=> $formdata['post_title'],
				'description'=> $formdata['description'],
				'required_key_skills'=> implode(", ",$formdata['key_skills']),
				'duration'=> $formdata['duration'],
				'currency'=> $formdata['currency'],
				'charges'=> $formdata['charges'],
				'category_id'=> $formdata['category_id'],
				'subcategory_id'=> $formdata['subcategory_id'],
				'appli_deadeline'=> $formdata['appli_deadeline'],
				'country'=> $formdata['country'],
				'state'=> $formdata['state'],
				'city'=> $formdata['city'],
				'location'=> $formdata['location'],
				'latitude'=> $formdata['latitude'],
				'longitude'=> $formdata['longitude'],
				'created_date'=>date('Y-m-d H:i:s'),
			);
			$this->Crud_model->SaveData('postjob', $data, "id='".$formdata['id']."'");
			$response = array('status'=> 'success', 'msg'=> 'Post Job Updated Successfully !');
			echo json_encode($response);
		} catch(\Exception $e) {
			$response = array('status'=> 'error', 'msg'=> $e->getMessage());
			echo json_encode($response);
		}
	}

	public function changebiddingstatus() {
		try{
			$formdata = json_decode(file_get_contents('php://input'), true);
			$bidstatus = $formdata['bidstatus'];
			$jodBidid = $formdata['jodBidid'];
			$postJobid = $formdata['postJobid'];
			$jobbiduserid = $formdata['jobbiduserid'];
			$jobpostuserid = $formdata['jobpostuserid'];
			$data1 = array('bidding_status' => $bidstatus);
			$this->Crud_model->SaveData('job_bid', $data1, "id='".$jodBidid."' AND postjob_id='".$postJobid."'");
			if($bidstatus == "Selected") {
				$this->Crud_model->SaveData('job_bid', $data1, "id='".$jodBidid."' AND postjob_id='".$postJobid."'");
				$binddingstatus = $this->Crud_model->GetData('job_bid', '', "postjob_id = '".$postJobid."' and bidding_status IN ('Under Review','Short Listed')");
				foreach ($binddingstatus as $row) {
					$data = array('bidding_status' => 'Rejected');
					$this->Crud_model->SaveData('job_bid', $data, "id='" . $row->id . "'");
				}
				$getChatData = $this->db->query("SELECT * FROM chat WHERE userfrom_id != '".$jobbiduserid."' AND userto_id != '".$jobbiduserid."' AND postjob_id = '".$postJobid."'")->result();
				if(!empty($getChatData)) {
					$updateChatData = $this->db->query("UPDATE chat SET is_delete = '2' WHERE userfrom_id != '".$jobbiduserid."' AND userto_id != '".$jobbiduserid."' AND postjob_id = '".$postJobid."'");
				}
				$updatepost = array('is_delete' => 1);
				$this->Crud_model->SaveData('postjob', $updatepost, "id='".$postJobid."'");
				$response = array('status'=> 'success', 'msg'=> 'Bid status changed successfully');
			}
			echo json_encode($response);
		} catch(\Exception $e) {
			$response = array('status'=> 'error', 'msg'=> $e->getMessage());
			echo json_encode($response);
		}
	}

	public function products() {
		try{
			$formdata = json_decode(file_get_contents('php://input'), true);
			$user_id = $formdata['user_id'];
			$product_list = $this->Crud_model->GetData('user_product', '', "user_id='".$user_id."' AND status = 1 and is_delete = 1");
			if(!empty($product_list)) {
				$productList = array();
				foreach ($product_list as $key => $value) {
					$productList[$key]['id'] = $value->id;
					$productList[$key]['user_id'] = $value->user_id;
					$productList[$key]['prod_name'] = $value->prod_name;
					$productList[$key]['prod_description'] = $value->prod_description;
					$productList[$key]['status'] = $value->status;
					$productList[$key]['is_delete'] = $value->is_delete;
					$pro_Img = $this->db->query("SELECT * FROM user_product_image where prod_id = '".$value->id."'")->result_array();
					$productList[$key]['prod_image'][] = $pro_Img;
					$pro_contact = $this->db->query("SELECT * FROM product_contact where product_id = '".$value->id."'")->result_array();
					$productList[$key]['prod_inquery'][] = $pro_contact;
				}
				$response = array('status'=> 'success', 'msg'=> $productList);
			} else {
				$response = array('status'=> 'success', 'msg'=> 'No data found');
			}
			echo json_encode($response);
		} catch(\Exception $e) {
			$response = array('status'=> 'success', 'msg'=> $e->getMessage());
			echo json_encode($response);
		}
	}

	function add_product() {
		try{
			if(!empty($this->input->post())){
				$data = array(
					'user_id' => $this->input->post('user_id'),
					'prod_name' => $this->input->post('prod_name'),
					'prod_description' => $this->input->post('prod_description'),
					'created_date' => date("Y-m-d H:i:s"),
				);
				$this->Crud_model->SaveData('user_product', $data);
				$insert_id = $this->db->insert_id();
				if(!empty($insert_id)) {
					if ($_FILES['prod_image']['name'] != '') {
						$cpt = count($_FILES['prod_image']['name']);
						for($i=0; $i<$cpt; $i++) {
							$_POST['prod_image'] = rand(0000, 9999) . "_" . $_FILES['prod_image']['name'][$i];
							$config2['image_library'] = 'gd2';
							$config2['source_image'] =  $_FILES['prod_image']['tmp_name'][$i];
							$config2['new_image'] =   getcwd() . '/uploads/products/'.$_POST['prod_image'];
							$config2['upload_path'] =  getcwd() . '/uploads/products/';
							$config2['allowed_types'] = 'jpg|png|jpeg|PNG|JPEG';
							$config2['maintain_ratio'] = TRUE;
							$this->load->library('image_lib', $config2);
							$this->image_lib->initialize($config2);
							if (!$this->image_lib->resize()) {
								$response = array('status'=> 'error', 'msg'=> $this->image_lib->display_errors());
								exit;
							} else {
								$image = $_POST['prod_image'];
								@unlink('uploads/products/' . $_POST['old_image']);
							}
							$data_image = array(
								'prod_id' => $insert_id,
								'prod_image' => $image,
								'created_date' => date("Y-m-d H:i:s"),
							);
							$this->Crud_model->SaveData('user_product_image', $data_image);
							$response = array('status'=> 'success', 'msg'=> 'Product Created Successfully !');
						}
					}
				}
			}
			echo json_encode($response);
		} catch(\Exception $e) {
			$response = array('status'=> 'error', 'msg'=> $e->getMessage());
			echo json_encode($response);
		}
	}

	public function edit_product() {
		try{
			$formdata = json_decode(file_get_contents('php://input'), true);
			$prod_id = $formdata['id'];
			//$product_list = $this->Crud_model->GetData('user_product', '', "user_id='".$user_id."' AND status = 1 and is_delete = 1");
			$product_list = $this->db->query("SELECT * FROM user_product WHERE id='".$prod_id."'")->result_array();
			if(!empty($product_list)) {
				$productList = array();
				foreach ($product_list as $key => $value) {
					$productList[$key]['id'] = $value['id'];
					$productList[$key]['user_id'] = $value['user_id'];
					$productList[$key]['prod_name'] = $value['prod_name'];
					$productList[$key]['prod_description'] = $value['prod_description'];
					$productList[$key]['status'] = $value['status'];
					$productList[$key]['is_delete'] = $value['is_delete'];
					$pro_Img = $this->db->query("SELECT * FROM user_product_image where prod_id = '".$value['id']."'")->result_array();
					foreach ($pro_Img as $img) {
						$productList[$key]['prod_image'][] = $img['prod_image'];
					}
				}
				$response = array('status'=> 'success', 'msg'=> $productList);
			} else {
				$response = array('status'=> 'success', 'msg'=> 'No data found');
			}
			echo json_encode($response);
		} catch(\Exception $e) {
			$response = array('status'=> 'success', 'msg'=> $e->getMessage());
			echo json_encode($response);
		}
	}

	public function update_product() {
		try{
			if(!empty($this->input->post())){
				$data = array(
					'prod_name' => $this->input->post('prod_name'),
					'prod_description' => $this->input->post('prod_description'),
					'id' =>  $this->input->post('id')
				);
				$updateQuery = $this->Crud_model->SaveData('user_product', $data, "id='".$id."'");
				if (!empty($_FILES['prod_image']['name'][0])) {
					$cpt = count($_FILES['prod_image']['name']);
					for($i=0; $i<$cpt; $i++) {
						$_POST['prod_image'] = rand(0000, 9999) . "_" . $_FILES['prod_image']['name'][$i];
						$config2['image_library'] = 'gd2';
						$config2['source_image'] =  $_FILES['prod_image']['tmp_name'][$i];
						$config2['new_image'] =   getcwd() . '/uploads/products/'.$_POST['prod_image'];
						$config2['upload_path'] =  getcwd() . '/uploads/products/';
						$config2['allowed_types'] = 'JPG|PNG|JPEG|jpg|png|jpeg';
						$config2['maintain_ratio'] = FALSE;
						$this->image_lib->initialize($config2);
						if (!$this->image_lib->resize()) {
							$this->image_lib->display_errors();
							$response = array('status'=> 'error', 'msg'=> $this->image_lib->display_errors());
							exit;
						} else {
							$image  = $_POST['prod_image'];
							@unlink('uploads/products/' . $_POST['old_image']);
						}
						$data_image = array(
							'prod_id' => $_POST['id'],
							'prod_image' => $image,
							'created_date' => date("Y-m-d H:i:s"),
						);
						$this->Crud_model->SaveData('user_product_image', $data_image);
						$response = array('status'=> 'success', 'msg'=> 'Product Created Successfully !');
					}
				}
			}
			echo json_encode($response);
		} catch(\Exception $e) {
			$response = array('status'=> 'error', 'msg'=> $e->getMessage());
			echo json_encode($response);
		}
	}

	function delete_product() {
		try{
			$formdata = json_decode(file_get_contents('php://input'), true);
			$p_id = $formdata['id'];
			$delete_prod = $this->db->query("UPDATE user_product SET is_delete = '2' WHERE id = '$p_id'");
			if($delete_prod > 0){
				$response = array('status'=> 'success', 'msg'=> 'Product Deleted Successfully');
			} else {
				$response = array('status'=> 'error', 'msg'=> 'Oops! Something went wrong Please try again later.');
			}
			echo json_encode($response);
		} catch(\Exception $e) {
			$response = array('status'=> 'error', 'msg'=> $e->getMessage());
			echo json_encode($response);
		}
	}

	function delete_product_image() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$pi_id = $this->input->post('id');
			$delete_prod = $this->db->query("DELETE FROM user_product_image WHERE id = '$pi_id'");
			if($delete_prod > 0){
				$response = array('status'=> 'success', 'msg'=> 'Product image deleted');
			} else {
				$response = array('status'=> 'error', 'msg'=> 'Oops! Something went wrong Please try again later.');
			}
			echo json_encode($response);
		} catch (\Exception $e) {
			$response = array('status'=> 'error', 'msg'=> $e->getMessage());
			echo json_encode($response);
		}
	}

	public function message() {

	}
}
