<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Our_services extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('modelHome/Our_service_model');
	}
	function index()
	{
		$get_category=$this->Crud_model->GetData('category',"id,category_name");
		$header = array('title' => 'our service');
		$data = array(
			'heading' => 'Our Services',
			'get_category' => $get_category,
		);
		$this->load->view('admin/header', $header);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/managehome/ourservice_list',$data);
		$this->load->view('admin/footer');
	}

	public function ajax_manage_page()

	{
		$get_data = $this->Our_service_model->get_datatables();
		if(empty($_POST['start']))
		{

			$no=0;
		}
		else{
			$no =$_POST['start'];
		}
		$data = array();
		foreach ($get_data as $row)
		{

			$btn = '<span class="btn btn-sm bg-success-light mr-2" data-toggle="modal" data-target="#editModal" onclick="getValue('.$row->id.')" data-placement="right"><i class="far fa-edit mr-1"></i> Edit</span>';

			if(strlen($row->description)>50)
			{
				$desc=substr($row->description,0,50).'...';
			}
			else {
				$desc=$row->description;
			}
			$no++;
			$nestedData = array();
			$nestedData[] = $no;
			$nestedData[] = ucwords($row->category_name);
			$nestedData[] = $row->icon;

			$nestedData[] = $desc;
			$nestedData[] = $btn;
			$data[] = $nestedData;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Our_service_model->count_all(),
			"recordsFiltered" => $this->Our_service_model->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}
	public function create_action()
	{
		$get_data=$this->Crud_model->get_single('our_service',"category_id='".$_POST['category_id']."'");
		if(empty($get_data)){
			$data=array(
				'category_id'=>$_POST['category_id'],
				'description'=>$_POST['description'],
				'icon'=>$_POST['icon'],
				'created_date'=>date('Y-m-d H:i:s'),
			);

			$this->db->insert('our_service',$data);
			$this->session->set_flashdata('message', 'Our service added successfully');
			echo "1"; exit;
		}
		else{
			$this->session->set_flashdata('message', 'Something went wrong. Please try again later!');
			echo "0"; exit;
		}

	}

	public function get_value()
	{
		$get_data=$this->Crud_model->get_single('our_service',"id='".$_POST['id']."'");
		// if(!empty($get_data->image))
		//   {

		//       if(!file_exists("uploads/career/".$get_data->image))
		//       {
		//         $img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
		//       }
		//       else
		//       {

		//          $img ='<img  class="rounded service-img mr-1" src="'.base_url('uploads/career/'.$get_data->image).'" >';
		//       }
		//   }

		//   else
		//   {
		//       $img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
		//   }
		$data=array(
			'id'=>$get_data->id,
			'category_id'=>$get_data->category_id,
			//'image'=>$img,
			'icon'=>$get_data->icon,
			'description'=>$get_data->description,
		);

		echo json_encode($data);exit;
	}

	function update_action()
	{

		$get_data=$this->Crud_model->get_single_record('our_service',"category_id='".$_POST['category_id']."' and id!='".$_POST['id']."'");
		if(empty($get_data))
		{
			$data = array(
				'category_id'=>$_POST['category_id'],
				'description'=>$_POST['description'],
				'icon'=>$_POST['icon'],

			);
			$this->Crud_model->SaveData('our_service',$data,"id='".$_POST['id']."'");
			$this->session->set_flashdata('message', 'Our service updated successfully');
			echo 1; exit;
		}else{
			$this->session->set_flashdata('message', 'Something went wrong. Please try again later!');
			echo "0"; exit;
		}

	}


}
