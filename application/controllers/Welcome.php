<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('post_job_model');
	}

    function employees_list($id) {
        $data['getcategory']=$this->Crud_model->GetData('category');
		$data['get_banner']=$this->Crud_model->get_single('banner',"id='2'");
		$this->load->view('header');
		$this->load->view('frontend/new_employees_list',$data);
		$this->load->view('footer');
	}

	function searchjob() {
        $data['getcategory']=$this->Crud_model->GetData('category');
        $data['get_banner']=$this->Crud_model->get_single('banner',"id='2'");
        $this->load->view('header');
        $this->load->view('frontend/new_employees_list',$data);
        $this->load->view('footer');
    }

    function fetch_data() {
        sleep(1);
        $category_id = $this->input->post('category_id');
        $title = $this->input->post('title_keyword');
        $post_id = $this->input->post('post_id');
        $days = $this->input->post('days');
        $subcategory_id = $this->input->post('subcategory_id');
        $location = $this->input->post('location');
        $search_title = $this->input->post('search_title');
        $search_location = $this->input->post('search_location');
        if(isset($category_id)&& !empty($category_id) || isset($title)&& !empty($title)|| isset($days)&& !empty($days)||isset($subcategory_id)&& !empty($subcategory_id)|| isset($location)&& !empty($location)|| isset($search_title)&& !empty($search_title) || isset($search_location)&& !empty($search_location)) {
            $total_count=$this->post_job_model->subcategory_getcount($title, $location,$days,$category_id,$subcategory_id,$search_title,$search_location);
			//print_r($total_count);
        } else {
			$get_product=$this->Crud_model->GetData('postjob','',"subcategory_id='".$post_id."' and is_delete='0'");
            $total_count=count($get_product);
			//print_r($get_product);
        }

        $this->load->library('pagination');
        $config = array();
        $config['base_url'] = '#';
        $config['total_rows'] = $total_count;
        $config['per_page'] =10;
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
        $page = $this->uri->segment(3);
		if (!empty($page)){
			$start = ($page - 1) * $config['per_page'];
		} else {
			$start = '0';
		}

        if(isset($category_id) || isset($title)|| isset($days)||isset($subcategory_id)|| isset($location)|| isset($search_title)|| isset($search_location)) {
			$getdata=$this->post_job_model->subcategory_fetchdata($config["per_page"], $start, $title, $location,$days,$category_id,$subcategory_id,$post_id,$search_title,$search_location);
        } else {
            $getdata=$this->post_job_model->subcategory_fetchdata($config["per_page"], $start, $title, $location,$days,$category_id,$subcategory_id,$post_id,$search_title,$search_location);
        }

        $output = array(
            'pagination_link'  => $this->pagination->create_links(),
            'postlist'   =>$getdata,
            'keyword'   =>$this->input->post('search_title'),
            'keyword_location'   =>$this->input->post('search_location'),
        );
        echo json_encode($output);
    }

	function employer_detail($user_id) {
		$userid=base64_decode($user_id);
		$data['userdata']=$this->Crud_model->get_single('users',"userId='".$userid."'");
        $data['get_post']=$this->Crud_model->GetData('postjob','',"user_id='".$userid."'");
        $data['get_banner']=$this->Crud_model->get_single('banner',"id='15'");
        $viewcount=$data['userdata']->view_count+1;
        $insert_data=array(
            'view_count'=>$viewcount,
        );
        $this->Crud_model->SaveData('users',$insert_data,"userId='".$userid."'");
		$this->load->view('header');
		$this->load->view('frontend/employer_detail',$data);
		$this->load->view('footer');
	}

	function product_detail() {
		$this->load->view('header');
		$this->load->view('frontend/product_detail');
		$this->load->view('footer');
	}

	function workers_list() {
		$this->load->view('header');
		$this->load->view('frontend/workers_list');
		$this->load->view('footer');
	}

	function post_job() {
		$data['key_skills']=$this->Crud_model->GetData('specialist',"","status = 'Active'");
		$data['countries']=$this->Crud_model->GetData('countries',"","");
		$data['category']=$this->Crud_model->GetData('category','','');
		$data['subcategory']=$this->Crud_model->GetData('sub_category','','');
		$data['get_banner']=$this->Crud_model->get_single('banner',"id='8'");
		$this->load->view('header');
		$this->load->view('frontend/post_job',$data);
		$this->load->view('footer');
	}

	public function get_subcategory() {
        $id =$_POST['id'];
        $CategoryData = $this->Crud_model->GetData('sub_category',"","category_id ='".$id."'");
        $html = "<option value=''>Select Sub Category</option>";
        foreach ($CategoryData as $row_data) {
            $html .= "<option value='".$row_data->id."'>".ucfirst($row_data->sub_category_name)."</option>";
        }
        echo $html;
    }

    public function save_postjob() {
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
		$data=array(
    		'user_id'=>$_SESSION['afrebay']['userId'],
			'required_key_skills'=>implode(", ",$this->input->post('key_skills',TRUE)),
    		'category_id'=>$this->input->post('category_id',TRUE),
    		'subcategory_id'=>$this->input->post('subcategory_id',TRUE),
    		'post_title'=>$this->input->post('post_title',TRUE),
    		'description'=>$this->input->post('description',TRUE),
    		'duration'=>$this->input->post('duration',TRUE),
    		'charges'=>$this->input->post('charges',TRUE),
            'location'=>$this->input->post('location',TRUE),
    		'latitude'=>$this->input->post('latitude',TRUE),
    		'longitude'=>$this->input->post('longitude',TRUE),
    		//'complete_address'=>$this->input->post('complete_address',TRUE),
			'country'=>$this->input->post('country-dropdown',TRUE),
			'state'=>$this->input->post('state-dropdown',TRUE),
			'city'=>$this->input->post('city-dropdown',TRUE),
    		'appli_deadeline'=>$this->input->post('appli_deadeline',TRUE),
    		'created_date'=>date('Y-m-d H:i:s'),
    	);
		//echo "<pre>"; print_r($data); die;
    	$this->Crud_model->SaveData('postjob',$data);
    	$this->session->set_flashdata('message', 'Post Job Created Successfull !');
		redirect(base_url("postjob"));
    }

    function post_jobinfo($id) {
        $post_id=base64_decode($id);
        $con="postjob.id='".$post_id."' and postjob.is_delete='0'";
        $data['get_postjob']=$this->post_job_model->viewdata($con);
        $this->load->view('header');
        $this->load->view('user_dashboard/jobinfo',$data);
        $this->load->view('footer');
    }


 	// post job list in filter
 	public function subcategory_data() {
        $id =$_POST['id'];
        $CategoryData = $this->Crud_model->GetData('sub_category',"","category_id ='".$id."'");
        $html = "";
        foreach ($CategoryData as $row_data) {
         $html .= '<p> <input type="checkbox" class="common_selector storage" name="subcategory_id[]"  id="subcategory_'.$row_data->id.'"  value='.$row_data->id.'><label for="subcategory_'.$row_data->id.'">'.ucfirst($row_data->sub_category_name).'</label></p>';
        }
        echo $html;
     }

    public function filter_job() {
     	$con="postjob.is_delete='0'";
     	if(isset($_POST['title_keyword'])&& !empty($_POST['title_keyword'])) {
            $con .=" and postjob.post_title like '%".$_POST['title_keyword']."%'";
     	}

     	if(isset($_POST['search_location'])&& !empty($_POST['search_location'])) {
     		$con.=" and postjob.location like '%".$_POST['search_location']."%'";
     	}

     	if(isset($_POST['category_id'])&& !empty($_POST['category_id'])) {
     		$con.=" and postjob.category_id='".$_POST['category_id']."'";
     	}

     	if(isset($_POST['days'])&& !empty($_POST['days'])) {
			if($_POST['days']=='one') {
                $con ="postjob.created_date>=NOW()-INTERVAL 1 HOUR";
            } else {
                $current_date=date('Y-m-d');
                $dates=date('Y-m-d', strtotime($current_date.'-'.$_POST['days'].'days'));
                $con ="postjob.created_date>='".$dates."'";
            }
     	}

     	if(isset($_POST['subcategory_id'])&& !empty($_POST['subcategory_id'])) {
     		$con.=" and (";
     		foreach ($_POST['subcategory_id'] as $key => $value) {
     			if($key==0) {
         			$con.="  postjob.subcategory_id ='".$value."'";
         		} else {
         			$con.="or  postjob.subcategory_id ='".$value."'";
         		}
         	}
            $con.=")";
     	}
 		$data['get_postjob']=$this->post_job_model->postjobdata($con);
 		$this->load->view('filter/postjob_filter',$data);
    }

	public function states_by_country() {
		$c_name = $this->input->post('country_name');
		$get_cid = $this->db->query("SELECT * FROM countries WHERE name = '".$c_name."'")->result_array();
		$state_list = $this->db->query("SELECT * FROM states WHERE country_id = '".$get_cid[0]['id']."'")->result_array();
		if(!empty($state_list)) {
			$html = "<option value=''>Select State</option>";
	        foreach ($state_list as $row_data) {
	            $html .= "<option value='".$row_data['name']."'>".ucfirst($row_data['name'])."</option>";
	        }
		} else {
			$html = '';
		}
		echo $html;
	}

	public function cities_by_state() {
		$s_name = $this->input->post('state_name');
		$get_sid = $this->db->query("SELECT * FROM states WHERE name = '".$s_name."'")->result_array();
		$cities_list = $this->db->query("SELECT * FROM cities WHERE state_id = '".$get_sid[0]['id']."'")->result_array();
		if(!empty($cities_list)) {
			$html = "<option value=''>Select City</option>";
	        foreach ($cities_list as $row_data) {
	            $html .= "<option value='".$row_data['name']."'>".ucfirst($row_data['name'])."</option>";
	        }
		} else {
			$html = '';
		}
		echo $html;

	}
}
