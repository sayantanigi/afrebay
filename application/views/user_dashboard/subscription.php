<section class="overlape">
    <div class="block no-padding">
        <div data-velocity="-.1" style="background: url('<?= base_url('assets/images/resource/mslider1.jpg')?>') repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div>
        <div class="container fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-header" style="padding-top: 90px;"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="dashboardhak">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Dashboard</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Subscription</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('sidebar');?>
<div class="col-md-12 col-sm-12 display-table-cell v-align User_Sub">
    <div class="user-dashboard">
        <div class="row row-sm">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="cardak" style="background: #f2f2f2 !important;">
                    <div class="container-fluid">
                        <div class="row text-center align-items-end">
                            <!-- Pricing Table-->
                            <?php if(!empty($get_subscription)) {
                                $i=1;
                                foreach ($get_subscription as $value) { ?>
                            <div class="col-lg-4 mb-5 mb-lg-0">
                                <div class="Sub_Block">
                                    <div class="Sub_Head">
                                        <div class="Heading">
                                            <h1><?= $value->subscription_name; ?></h1>
                                            <h2>Price: <?= ' '.$value->subscription_amount; ?><span></span></h2>
                                            <p style="text-align: justify;">Duration: <b><?= ' '.$value->subscription_duration; ?></b><span></span></p>
                                        </div>
                                        <div class="Icon">
                                            <span>
                                                <img src="https://cdn-icons-png.flaticon.com/512/5673/5673647.png">
                                            </span>
                                        </div>
                                    </div>
                                    <div></div>
                                    <div><?= $value->subscription_description; ?></div>
                                    <a href="javascript:void(0);" class="btn btn-primary" id="getSubscription_<?php echo $i?>">Subscribe</a>
                                    <input type="text" name="user_id" id="user_id_<?php echo $i?>" value="<?php echo $_SESSION['afrebay']['userId']?>" />
                                    <input type="text" name="sub_id" id="sub_id_<?php echo $i?>" value="<?php echo $value->id?>" />
                                    <input type="text" name="sub_id" id="sub_name_<?php echo $i?>" value="<?php echo $value->subscription_name?>" />
                                    <input type="text" name="user_email" id="user_email_<?php echo $i?>" value="<?php echo $_SESSION['afrebay']['userEmail']?>" />
                                    <input type="text" name="sub_price" id="sub_price_<?php echo $i?>" value="<?php echo $value->subscription_amount?>" />
                                    <input type="text" name="sub_duration" id="sub_duration_<?php echo $i?>" value="<?php echo $value->subscription_duration?>" />
                                </div>
                            </div>
                            <?php $i++; }} else { ?>
                            <div class="col-lg-4 mb-5 mb-lg-0">
                                <div class="bg-white p-5 rounded-lg shadow" style="height: 500px;">
                                    <h1 class="h6 text-uppercase font-weight-bold mb-4">No Data Found</h1>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<div id="add_project" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header login-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Add Project</h4>
            </div>
            <div class="modal-body">
                <input type="text" placeholder="Project Title" name="name" />
                <input type="text" placeholder="Post of Post" name="mail" />
                <input type="text" placeholder="Author" name="passsword" />
                <textarea placeholder="Desicrption"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="cancel" data-dismiss="modal">Close</button>
                <button type="button" class="add-project" data-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>
</section>
<script>
$(document).ready(function(){
    <?php
    if(!empty($get_subscription)) {
        $i=1;
        foreach ($get_subscription as $value) { ?>
        $('#getSubscription_<?php echo $i?>').click(function() {
            var user_id = $('#user_id_<?php echo $i?>').val();
            var sub_id = $('#sub_id_<?php echo $i?>').val();
            var sub_name = $('#sub_name_<?php echo $i?>').val();
            var user_email = $('#user_email_<?php echo $i?>').val();
            var sub_price = $('#sub_price_<?php echo $i?>').val();
            var sub_duration = $('#sub_duration_<?php echo $i?>').val();
            var base_url = $('#base_url').val();
            $.ajax({
                url:base_url+"user/dashboard/userSubscription",
                method:"POST",
                data:{user_id: user_id,sub_id: sub_id,sub_name: sub_name,user_email: user_email,sub_price: sub_price,sub_duration: sub_duration},
                success:function(data) {
                    //alert(data);
                    if (data == '1'){
                        $('.text-success').show();
                        setTimeout(function () {
                            $('.text-success').hide();
                        }, 2500);
                    } else if (data == '2') {
                        $('.text-error').show();
                        setTimeout(function () {
                            $('.text-error').hide();
                        }, 2500);
                    } else if (data == '3') {
                        $('.text-danger').show();
                        setTimeout(function () {
                            $('.text-danger').hide();
                        }, 2500);
                    } else {
                        $('.text-danger').show();
                        setTimeout(function () {
                            $('.text-danger').hide();
                        }, 2500);
                    }
                }

            })
        })
    <?php $i++; } } ?>
})
</script>
