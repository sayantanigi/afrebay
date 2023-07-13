<?php $settings = $this->Crud_model->get_single('setting');
//print_r($settings); die();
?>
<!DOCTYPE html>
<html>
<head>
	<title>New Product Query</title>
	<meta charset="utf-8">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
	<div style="width:600px;margin: 0 auto;background: #fff;font-family: 'Poppins', sans-serif; border: 1px solid #e6e6e6;">
		<div style="padding: 30px 30px 15px 30px;box-sizing: border-box;">
		 	<img src="<?= base_url('uploads/logo/'.@$settings->logo)?>" style="width:100px;float: right;margin-top: 0 auto;">
			<h3 style="padding-top:40px; line-height: 30px;">Greetings from<span style="font-weight: 900;font-size: 35px;color: #F44C0D; display: block;">Afrebay</span></h3>
			<p style="font-size:24px;">Hello Admin,</p>
			<p style="font-size:20px;">Please find the below details for product related queries</p>
            <p style="font-size:20px;"><b>Product Name: </b><?php echo $this->input->post('p_name')?></p>
            <p style="font-size:20px;"><b>Customer Name: </b><?php echo $this->input->post('name')?></p>
            <p style="font-size:20px;"><b>Customer Email: </b><?php echo $this->input->post('email')?></p>
            <p style="font-size:20px;"><b>Message: </b><?php echo $this->input->post('details')?></p>
			<p style="font-size:20px;">Thank you!</p>
    		<p style="font-size:20px;list-style: none;">Sincerly</p>
    		<p style="list-style: none;"><b>Afrebay</b></p>
	    	<p style="list-style: none;"><b>Visit us:</b> <span><?= @$settings->address?></span></p>
	    	<p style="list-style: none"><b>Email us:</b> <span><?= @$settings->email?></span></p>
        </div>
        <footer style="height:25px;width:100%;background: #F44C0D;"><span style="padding-left: 10px; width:100%; display: block; margin-bottom: 20px; text-align: center;"> Copyright &copy; <?=date('Y')?> Afrebay. All rights reserved.</span></footer>
	</div>
</body>
</html>
