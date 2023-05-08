<?php
if(!empty($get_banner->image) && file_exists('uploads/banner/'.$get_banner->image)){
    $banner_img=base_url("uploads/banner/".$get_banner->image);
} else{
    $banner_img=base_url("assets/images/resource/mslider1.jpg");
} ?>
<section class="overlape">
    <div class="block no-padding">
        <div data-velocity="-.1" style="background: url('<?= $banner_img ?>') repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div>
        <!-- PARALLAX BACKGROUND IMAGE -->
        <div class="container fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-header">
                        <h3>Employer Detail</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="block Employer_Details">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 column">
                    <div class="job-single-sec style3">
                        <div class="job-head-wide">
                            <div class="row">
                                <div class="col-lg-10 col-md-12 col-sm-12">
                                    <div class="job-single-head3 emplye">
                                        <div class="job-thumb">
                                            <?php if (@$userdata->profilePic && file_exists('uploads/users/'.@$userdata->profilePic)) { ?>
                                            <img id="profile-img" src="<?= base_url('uploads/users/'.@$userdata->profilePic)?>" class="online" alt="" />
                                            <?php } else { ?>
                                            <img id="profile-img" src="<?= base_url('uploads/users/user.png')?>" class="online" alt="" />
                                            <?php } ?>
                                        </div>
                                        <div class="job-single-info3">
                                            <h3>
                                                <?php
                                                $fullname=$userdata->firstname.' '.$userdata->lastname;
                                                if(!empty($fullname)){echo $fullname;} else{ echo $userdata->username; }?>
                                            </h3>
                                            <span><i class="la la-map-marker"></i><?= @$userdata->address;?></span>
                                            <!--<span class="job-is ft">Full time</span>-->
                                            <ul class="tags-jobs">
                                                <li><i class="la la-file-text"></i> Applications <?= count($get_post);?></li>
                                                <li><i class="la la-calendar-o"></i>
                                                    <?php $getdate=$this->Crud_model->get_single('postjob',"user_id='".$userdata->userId."'");
                                                    if(!empty($getdate->appli_deadeline)) { ?>
                                                    Post Date: <?= date('M d,Y',strtotime(@$getdate->appli_deadeline));
                                                    } ?>
                                                </li>
                                                <li><i class="la la-eye"></i> Views <?= @$userdata->view_count?></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- Job Head -->
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12">
                                    <div class="share-bar">
                                        <!--<a href="javascript:void(0)" title="" class="share-google"><i class="la la-google"></i></a><a href="javascript:void(0)" title="" class="share-fb"><i class="fa fa-facebook"></i></a>-->
                                        <!--<a href="javascript:void(0)" title="" class="share-twitter"><i class="fa fa-twitter"></i></a>-->
                                        <!-- ShareThis BEGIN -->
                                        <div class="sharethis-inline-share-buttons"></div>
                                        <!-- ShareThis END -->
                                    </div>
                                    <div class="emply-btns">
                                        <a class="seemap" id="ShowMap"><i class="la la-map-marker"></i> See On Map</a>
                                        <!-- <a class="seemap" href="javascript:void(0)" title=""
                                            onclick="show_map()"><i class="la la-map-marker"></i> See On Map</a> -->
                                        <!--<a class="followus" href="javascript:void(0)" title=""><i class="la la-paper-plane"></i> Follow us</a>-->
                                        <?php if(!empty(@$userdata->address)){?>
                                        <p style="display:none;" id="show_maping">
                                            <iframe width="260" height="100px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.it/maps?q=<?= @$userdata->address?>&output=embed"></iframe>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="job-wide-devider">
                            <div class="row">
                                <div class="col-lg-8 col-md-12 col-sm-12 column">
                                    <div class="job-details">
                                        <h3>About Business Network</h3>
                                        <p><?= @$userdata->short_bio;?></p>
                                    </div>
                                    <div class="recent-jobs">
                                        <h3>Jobs from Business Network</h3>
                                        <div class="job-list-modern">
                                            <div class="job-listings-sec no-border">
                                                <?php
                                                $total_post=count($get_post);
                                                if(!empty($get_post)){
                                                foreach ($get_post as $key) {
                                                ?>
                                                <div class="job-listing wtabs noimg">
                                                    <div class="job-title-sec">
                                                        <h3 style="text-transform: uppercase;"><a href="javascript:void(0)" title=""><?= $key->post_title; ?></a></h3>
                                                        <span>Massimo Artemisis</span>
                                                        <div class="job-lctn"><i class="la la-map-marker"></i><?= $key->location; ?></div>
                                                    </div>
                                                    <div class="job-style-bx">
                                                        <span class="fav-job"><i class="la la-heart-o"></i></span>
                                                        <i>
                                                        <?php
                                                            $insertdate=date('Y-m-d',strtotime($key->created_date));
                                                            $date1 = new DateTime($insertdate);
                                                            $current_date=date('Y-m-d');
                                                            $date2 = new DateTime($current_date);
                                                            $interval = $date1->diff($date2);
                                                            echo $interval->y . " years, " . $interval->m." months, ".$interval->d." days ";
                                                        ?>
                                                        </i>
                                                    </div>
                                                </div>
                                                <?php } }?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 column">
                                    <div class="job-overview">
                                        <h3>Company Information</h3>
                                        <ul>
                                            <li>
                                                <i class="la la-eye"></i>
                                                <h3>Viewed</h3>
                                                <span><?= @$userdata->view_count?></span>
                                            </li>
                                            <li>
                                                <i class="la la-file-text"></i>
                                                <h3>Posted Jobs</h3>
                                                <span><?= @$total_post;?></span>
                                            </li>
                                            <li>
                                                <i class="la la-map"></i>
                                                <h3>Locations</h3> <span><?= @$userdata->address;?></span>
                                            </li>
                                            <li>
                                                <i class="la la-bars"></i>
                                                <h3>Categories</h3>
                                                <span>Arts, Design, Media</span>
                                            </li>
                                            <li>
                                                <i class="la la-clock-o"></i>
                                                <h3>Since</h3>
                                                <span>2002</span>
                                            </li>
                                            <li>
                                                <i class="la la-users"></i>
                                                <h3>Team Size</h3>
                                                <span>15</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 column">
                                    <div class="Product_Details">
                                        <h3 class="mt-5 mb-5">Products</h3>
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-sm-12 column">
                                                <div class="Product">
                                                    <div class="Product_Img">
                                                        <img src="https://cdn.shopify.com/s/files/1/0070/7032/files/trending-products_c8d0d15c-9afc-47e3-9ba2-f7bad0505b9b.png?format=jpg&quality=90&v=1614559651">
                                                    </div>
                                                    <div class="Product_Data">
                                                        <p class="mt-2 mb-2"><span>Test Product</span></p>
                                                        <p><span>In publishing and graphic design, Lorem ipsum is a
                                                                placeholder text commonly used to demonstrate.</span>
                                                        </p>
                                                        <a href="<?php echo base_url()?>productdetail" type="button" class="btn btn-info">Contact Seller</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12 column">
                                                <div class="Product">
                                                    <div class="Product_Img">
                                                        <img
                                                            src="https://static.doofinder.com/main-files/uploads/2018/01/Top6Sales.png">
                                                    </div>
                                                    <div class="Product_Data">
                                                        <p class="mt-2 mb-2"><span>Test Product</span></p>
                                                        <p><span>In publishing and graphic design, Lorem ipsum is a
                                                                placeholder text commonly used to demonstrate.</span>
                                                        </p>
                                                        <a href="<?php echo base_url()?>productdetail" type="button" class="btn btn-info">Contact Seller</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12 column">
                                                <div class="Product">
                                                    <div class="Product_Img">
                                                        <img src="https://queue-it.com/media/ppcp1twv/product-drop.jpg">
                                                    </div>
                                                    <div class="Product_Data">
                                                        <p class="mt-2 mb-2"><span>Test Product</span></p>
                                                        <p><span>In publishing and graphic design, Lorem ipsum is a
                                                                placeholder text commonly used to demonstrate.</span>
                                                        </p>
                                                        <a href="<?php echo base_url()?>productdetail" type="button" class="btn btn-info">Contact Seller</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="Map_Viwe" id="MapView">
    <div class="Map_Module">
        <span class="Close_Icon" id="MapClose"><i class="fa fa-times" aria-hidden="true"></i></span>
        <div class="Map_Container">
            <iframe src="https://maps.google.it/maps?q=<?= @$userdata->address?>&output=embed" height="70%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</div>
<script>
    function show_map() {
        $('#show_maping').show();
    }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script type="text/javascript" async="" src="<?php echo base_url();?>assets/js/Map_Modal.js"></script>
