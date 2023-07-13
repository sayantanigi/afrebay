<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Home extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Mymodel');
		$this->load->model('post_job_model');
		$this->load->model('Users_model');
	}

    public function home_list() {
        $data['get_post'] = $this->Crud_model->GetData('postjob', 'id,post_title,description,user_id', "is_delete='0'", '', '(id)desc', '6');
		$data['countries']=$this->Crud_model->GetData('countries',"","");
		$data['get_freelancerspost'] = $this->Crud_model->GetData('postjob', '', "is_delete='0'", '', '', '8');
		$data['get_career'] = $this->Crud_model->GetData('career_tips', '', "status='Active'", '', '', '3');
		$data['get_company'] = $this->Crud_model->GetData('company_logo', '', "status='Active'", '', '', '');
		$data['get_users'] = $this->Users_model->get_users();
		$data['get_ourservice'] = $this->Crud_model->GetData('our_service', '', "status='Active'", '', '', '');
		$data['get_banner'] = $this->Crud_model->get_single('banner', "page_name='Home Top'");
		$data['get_banner_middle'] = $this->Crud_model->get_single('banner', "page_name='Home Middle'");
        $data['status'] = '1';
        echo json_encode($data);
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

    public function post_details($postid) {
        $vis_ip = $this->getVisIPAddr(); // Store the IP address
		$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $vis_ip));
		$data['countryName'] = $ipdat->geoplugin_countryName;
		if(!empty($_SESSION['afrebay_admin'])){
			$type='admin';
		} else if(!empty($_SESSION['afrebay'])) {
			$type='user';
		} else {
			$type='nouser';
		}
		$con = "postjob.id='" . base64_decode($postid) . "'";
		$data['post_data'] = $this->post_job_model->viewdata($con);

		if($type=='admin'){
			//$this->load->view('header',$data);
			$data['type']='admin';
		} else if($type=='user') {
			//$this->load->view('header',$data);
			$data['type']='user';
		} else {
			//$this->load->view('header',$data);
			$data['type']='';
		}
        $data['status'] = '1';
        echo json_encode($data);
	}

	function vendor_lists() {
		try {
			$getdata['getcategory']=$this->Crud_model->GetData('category');
			$title = $this->input->post('title_keyword');
			$category_id = $this->input->post('category');
			$subcategory_id = $this->input->post('subcategory');
			$search_location = $this->input->post('location');
			$days = $this->input->post('days');
			$userType = 2;
			$this->load->library('pagination');
			$config = array();
			$config['base_url'] = '#';
			$config['total_rows'] = count($this->Users_model->get_employercount());
			$config['per_page'] = 10;
			$config['uri_segment'] = 3;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['next_link'] = '&gt;';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['prev_link'] = '&lt;';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='active'><a href='#'>";
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['num_links'] = 3;
			$this->pagination->initialize($config);
			$page = 1;
			$start = ($page - 1) * $config['per_page'];

			if(isset($title) || isset($category_id) || isset($subcategory_id) || isset($search_location) || isset($days) || isset($userType)) {
				$getdata['vendor_list']=$this->Users_model->employer_fetchdataForAPI($config["per_page"], $start, $title, $category_id, $subcategory_id, $search_location, $days, $userType);
			} else {
				$getdata['vendor_list']=$this->Users_model->employer_fetchdataForAPI($config["per_page"], $start, $title, $category_id, $subcategory_id, $search_location, $days, $userType);
			}
			$response = array('status'=> 'success', 'msg'=> $getdata);
			echo json_encode($response);
		} catch (\Exception $e) {
			$response = array('status'=> 'error', 'msg'=> $e->getMessage());
			echo json_encode($response);
		}
	}

    function vendor_details($user_id) {
		$userid = base64_decode($user_id);
		$data['userdata'] = $this->Crud_model->get_single('users',"userId='".$userid."'");
		$data['get_post'] = $this->Crud_model->GetData('postjob','',"user_id='".$userid."' AND is_delete = '0'");
        $data['count_post'] = $this->db->query("SELECT COUNT(id) as total FROM postjob WHERE user_id='".$userid."' AND is_delete = '0'")->result_array();
		$data['prod_list'] = $this->db->query("SELECT user_product.id, user_product.prod_name, user_product.prod_description, user_product_image.prod_image FROM user_product_image JOIN user_product ON user_product.id = user_product_image.prod_id WHERE user_product.status = 1 AND user_product.is_delete = 1 AND user_id='".$userid."' group by user_product.id")->result_array();
		$viewcount = $data['userdata']->view_count+1;
		$insert_data=array(
			'view_count'=>$viewcount,
		);
		$this->Crud_model->SaveData('users',$insert_data,"userId='".$userid."'");
        $data['status'] = '1';
        echo json_encode($data);
	}

    function product_details($id) {
		$prod_id = base64_decode($id);
		$data['prod_details']=$this->db->query("SELECT * FROM user_product WHERE status = 1 AND is_delete = 1 AND id = '".$prod_id."'")->result_array();
        $data['prod_images']=$this->db->query("SELECT * FROM user_product_image WHERE prod_id = '".$prod_id."'")->result_array();
        $data['status'] = '1';
        echo json_encode($data);
	}

}
