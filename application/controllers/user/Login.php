<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Mymodel');
	}

	public function reg() {
	 	$validate=$this->Crud_model->get_single('users',"mobile='".$_POST['mobile']."'");
	    if(!empty($validate)) {
			$data=array('result'=>0,'data'=>'phone');
		} else {
			$validate=$this->Crud_model->get_single('users',"email='".$_POST['email']."'");
			if(!empty($validate)) {
				$data=array('result'=>0,'data'=>'email');
			}
		}
		if(empty($validate)) {
			$data=array(
				'username' =>$_POST['username'],
				'userType' =>$_POST['user_type'],
				'email' =>$_POST['email'],
				'mobile' =>$_POST['mobile'],
				'serviceType' => implode(", ", $_POST['service']),
				'password' => md5($_POST['password']),
				'created'=>date('Y-m-d H:i:s'),
				'status'=>1
			);
			// if($this->Mymodel->insert('users',$data)) {
			// 	$email=$_POST['email'];
			//     $this->load->library('email');
			// 	$data=array('email'=>$email,'password'=>$_POST['password']);
			// 	$htmlContent = $this->load->view('email_template/signup',$data,TRUE);
			// 	$config = array(
			// 		'protocol' => 'ssmtp',
			// 		'smtp_host' => 'ssl://ssmtp.googlemail.com',
			// 		'smtp_port' => 587,
			// 		'smtp_user' => 'mediaadgroup',
			// 		'smtp_pass' => 'Kade2000',
			// 		'smtp_crypto' => 'security',
			// 		'mailtype' => 'html',
			// 		'smtp_timeout' => '4',
			// 		'charset' => 'iso-8859-1',
			// 		'wordwrap' => TRUE
			// 	);
			// 	$this->email->initialize($config);
			// 	$this->email->from('info@afrebay.pro','AFREBAY PRO');
			// 	$this->email->to($email);
			// 	$this->email->subject('Registration Confirmation message from AFREBAY PRO');
			// 	$this->email->message($htmlContent);
			// 	$this->email->send();
			// 	$this->session->set_flashdata('success', 'Registration Successfull !');
			// 	$data=array('result'=>1,'data'=>1);
			// } else {
			// 	$this->session->set_flashdata('error', 'Failed to Register !');
			// 	$data=array('result'=>2,'data'=>2);
			// }
			$result = $this->Mymodel->insert('users',$data);
			$insert_id = $this->db->insert_id();
			if(!empty($insert_id)) {
				$subject = 'Verify Your Email Address From Afrebay';
				$activationURL = base_url() . "email-verification/" . urlencode(base64_encode($otp));
				$imagePath = base_url() . 'assets/images/logo.png';
				$message = "<table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'>
				<tbody>
				<tr>
				<td align='center'>
				<table class='col-600' width='600' border='0' align='center' cellpadding='0' cellspacing='0' style='margin-left:20px; margin-right:20px; border-left: 1px solid #dbd9d9; border-right: 1px solid #dbd9d9; border-top:2px solid #232323'>
				<tbody>
				<tr>
				<td height='35'></td>
				</tr>
				<tr>
				<td align='left' style='padding:5px 10px;font-family: Raleway, sans-serif; font-size:16px; font-weight: bold; color:#2a3a4b;'><img src='" . $imagePath . "'/></td>
				</tr>
				<tr>
				<td height='35'></td>
				</tr>
				<tr>
				<td align='left' style='padding:5px 10px;font-family: Raleway, sans-serif; font-size:16px; font-weight: bold; color:#2a3a4b;'>Hello ".$_POST['username'].",</td>
				</tr>
				<tr>
				<td height='10'></td>
				</tr>
				<tr>
				<td align='left' style='padding:5px 10px;font-family: Lato, sans-serif; font-size:16px; color:#444; line-height:24px; font-weight: 400;'>
				Thank you for registration on <strong style='font-weight:bold;'>ConceptToCreation</strong>.
				</td>
				</tr>
				</tbody>
				</table>
				</td>
				</tr>
				<tr>
				<td align='center'>
				<table class='col-600' width='600' border='0' align='center' cellpadding='0' cellspacing='0' style='margin-left:20px; margin-right:20px; border-left: 1px solid #dbd9d9; border-right: 1px solid #dbd9d9; border-bottom:2px solid #232323'>
				<tbody>
				<tr>
				<td height='10'></td>
				</tr>
				<tr>
				<td align='left' style='padding:5px 10px;font-family: Lato, sans-serif; font-size:16px; color:#444; line-height:24px; font-weight: 400;'>
				Please click on the below activation link to verify your email address.
				</td>
				</tr>
				<tr>
				<td height='10'></td>
				</tr>
				<tr>
				<td align='left' style='text-align:center;padding:5px 10px;font-family: Lato, sans-serif; font-size:16px; color:#444; line-height:24px; font-weight: bold;'>
				<a href=" . $activationURL . " target='_blank' style='background:#232323;color:#fff;padding:10px;text-decoration:none;line-height:24px;'>click here</a>
				</td>
				</tr>
				<tr>
				<td height='10'></td>
				</tr>
				<tr>
				<td align='left' style='padding:5px 10px;font-family: Lato, sans-serif; font-size:16px; color:#444; line-height:24px; font-weight: bold;'>
				Email: " . $email . "<br/>
				</td>
				</tr>
				<tr>
				<td height='30'></td>
				</tr>
				<tr>
				<td align='left' style='padding:0 10px;font-family: Lato, sans-serif; font-size:16px; color:#232323; line-height:24px; font-weight: 700;'>
				Thank you!
				</td>
				</tr>
				<tr>
				<td align='left' style='padding:0 10px;font-family: Lato, sans-serif; font-size:14px; color:#232323; line-height:24px; font-weight: 700;'>
				Sincerely
				</td>
				</tr>
				<tr>
				<td align='left' style='padding:0 10px;font-family: Lato, sans-serif; font-size:14px; color:#232323; line-height:24px; font-weight: 700;'>
				Team ConceptToCreation
				</td>
				</tr>
				</tbody>
				</table>
				</td>
				</tr>
				</tbody>
				</table>";
				$mail = new PHPMailer(true);
				try {
					//Server settings
					$mail->CharSet = 'UTF-8';
					$mail->SetFrom('no-reply@goigi.com', 'Localfood-joints');
					$mail->AddAddress($email);
					$mail->IsHTML(true);
					$mail->Subject = $subject;
					$mail->Body = $message;
					//Send email via SMTP
					$mail->IsSMTP();
					$mail->SMTPAuth   = true;
					$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
					$mail->Host       = "smtp.gmail.com";
					$mail->Port       = 587; //587 465
					$mail->Username   = "no-reply@goigi.com";
					$mail->Password   = "wj8jeml3eu0z";
					$mail->send();
					// echo 'Message has been sent';
				} catch (Exception $e) {
					$this->session->set_flashdata('error_message', "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
				}
				//$msg = "An email has been sent to your email address containing an activation link. Please click on the link to activate your account. If you do not click the link your account will remain inactive and you will not receive further emails. If you do not receive the email within a few minutes, please check your spam folder.";
				echo $msg = '1';
			} else {
				echo $msg = '2';
			}
		}
		echo $msg;
    }

	public function validate_user($pId = null) {
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if($this->form_validation->run() == false) {
			$this->load->view('header');
			$this->load->view('login');
			$this->load->view('footer');
		} else {
			$email = $this->input->post("email");
			$password = $this->input->post("password");
			if($this->Mymodel->check_record($email, $password)) {
				$this->session->set_flashdata('message', 'Logged in successfully !');
				redirect('home');
			} else {
				$this->session->set_flashdata('error', 'Invalid Email or Password !');
				redirect('login');
			}
		}
	}

	public function logout() {
	    unset($_SESSION['afrebay']);
			$this->session->set_flashdata('msg', 'You have logged out.');
			redirect('login');
	    }

    function forgot_password() {
   	   	$this->load->view('header');
		$this->load->view('forgot_password');
		$this->load->view('footer');
   	}

	function send_forget_password() {
		//print_r($this->input->post('email')); die();
    	if(!empty($this->input->post('email',TRUE))) {
     		$get_email = $this->Crud_model->get_single('users',"email='".$_POST['email']."'");
         	if(!empty($get_email)) {
             	$data=array(
					'email'=>$get_email->email
				);
				$htmlContent = $this->load->view('email_template/forgot_password',$data,TRUE);
				$config = array(
					'protocol' => 'ssmtp',
					'smtp_host' => 'ssl://ssmtp.googlemail.com',
					'smtp_port' => 587,
					'smtp_user' => 'mediaadgroup',
					'smtp_pass' => 'Kade2000',
					'smtp_crypto' => 'security',
					'mailtype' => 'html',
					'smtp_timeout' => '4',
					'charset' => 'iso-8859-1',
					'wordwrap' => TRUE
				);
				$this->email->initialize($config);
				$this->email->from('info@afrebay.pro','AFREBAY PRO');
				$this->email->to($get_email->email);
				$this->email->subject('Forgot Password Confirmation message from AFREBAY PRO');
				$this->email->message($htmlContent);
				$this->email->send();
				print_r($this->email->send());
				//$msg = 'pass';
         	} else {
   				//$msg = 'fail';
   			}
			//echo
      	}

	}


	function new_password() {
	    $data['title']='Forget Password';
		$this->load->view('header',$data);
		$this->load->view('new_password');
		$this->load->view('footer');
	}

	public function setnew_password() {
		if($this->input->post('email',TRUE)){
		 	$get_email = $this->Crud_model->GetData('users','',"email='".$_POST['email']."'",'','','','1');
			if(!empty($get_email)) {
				$data = array('password' =>md5($_POST['password']));
			 	$con="userId='".$get_email->userId."'";
			 	$this->Crud_model->SaveData('users',$data, $con);
			 	$this->session->set_flashdata('message', 'New password successfully !');
	           	echo "1";
            } else {
            	$this->session->set_flashdata('error', 'Error');
            }
        }
	}

}//end controller
