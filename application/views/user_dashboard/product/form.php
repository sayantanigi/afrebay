<section class="overlape">
    <div class="block no-padding">
        <div data-velocity="-.1" style="background: url(images/resource/mslider1.jpg) repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div>
        <!-- PARALLAX BACKGROUND IMAGE -->
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
                        <li class="breadcrumb-item active" aria-current="page">Add Product</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<?php $this->load->view('sidebar');?>
<div class="col-md-12 col-sm-12 display-table-cell v-align">
    <div class="user-dashboard">
        <form class="form" action="<?= $action; ?>" method="post" id="registrationForm" enctype="multipart/form-data">
            <div class="row row-sm">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="cardak">
                        <span class="text-success f-20"><?=$this->session->flashdata('success');  ?></span>
                        <!-- <div class="container bootstrap snippet">
                            <div class="new-pro">
                                <a href="#" class="pull-right">
                                </a>
                            </div>
                        </div> -->
                        <div class="profile-dsd">
                            <div class="tab-content">
                                <div class="tab-pane active" style="padding: 0px;">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="new-pro">
                                                <?php
                                                if(!empty($userinfo->profilePic)) {
                                                    if(!file_exists('uploads/users/'.$userinfo->profilePic)) {
                                                ?>
                                                <img class="img-circle img-responsive" src="<?php echo base_url('uploads/no_image.png')?>" style="width:60px;height: 60px;" />
                                                </a>
                                                <?php } else { ?>
                                                <img class="img-circle img-responsive" src="<?php echo base_url('uploads/users/'.$userinfo->profilePic); ?>" style="width:60px;height: 60px;" />
                                                <?php } } else { ?>
                                                <img class="img-circle img-responsive" src="<?php echo base_url('uploads/no_image.png')?>" style="width:60px;height: 60px;" />
                                                <?php } ?>
                                                <input type="hidden" name="old_image" value="<?=$userinfo->profilePic ?>">
                                                <input type="hidden" name="id" value="<?=$userinfo->userId  ?>">
                                                <div class="profile-ak">
                                                    <h6>Upload a different photo...</h6>
                                                    <input type="file" name="prod_image[]" multiple class="text-center center-block file-upload" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label for="first_name">
                                                    <h4>Product Name <span style="color: red">*</span></h4>
                                                </label>
                                                <input type="text" class="form-control" name="prod_name" placeholder="Product Name"  value="<?= @$prod_name; ?>" required/>
                                            </div>
                                            <div class="col-lg-12"><br>
                                                <label for="first_name"><h4>Product Description </h4></label>
                                                <textarea type="text" class="form-control" name="prod_description" id="prod_description" value="<?= $prod_description;?>" ><?= @$prod_description; ?></textarea>
                                            </div>
                                            <input type="hidden" name="id" value="<?= @$id; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-12 aksek">
                                            <button class="post-job-btn pull-right" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
CKEDITOR.replace('prod_description');
</script>
