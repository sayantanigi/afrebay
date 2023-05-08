<?php
if(!empty($get_banner->image) && file_exists('uploads/banner/'.$get_banner->image)) {
    $banner_img=base_url("uploads/banner/".$get_banner->image);
} else {
    $banner_img=base_url("assets/images/resource/mslider1.jpg");
} ?>
<style>
#register-messages {text-align: center; margin-top: 10px;}
</style>
<section class="overlape">
    <div class="block no-padding">
        <div data-velocity="-.1" style="background: url('<?= $banner_img ?>') repeat scroll 50% 422.28px transparent;"
            class="parallax scrolly-invisible no-parallax"></div>
        <!-- PARALLAX BACKGROUND IMAGE -->
        <div class="container fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-header">
                        <h3>Register</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="block remove-bottom Sign_Up">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-lg-10">
                    <div class="account-popup-area signup-popup-box static">
                        <div class="account-popup">
                            <div class="row m-0">
                                <div class="col-lg-4 col-md-12 col-sm-12 SignUp_Left">
                                    <h3>Sign Up</h3>
                                    <span>Lorem ipsum dolor sit amet consectetur adipiscing elit odio duis risus at
                                        lobortis
                                        ullamcorper</span>
                                    <div class="select-user">
                                        <span class="user-tab" user_type="1" onclick="get_value(1)">Worker</span>
                                        <span class="user-tab" user_type="2" onclick="get_value(2)">Employer</span>
                                    </div>
                                    <div class="error" id="err_usertype"></div>
                                </div>
                                <div class="col-lg-8 col-md-12 col-sm-12 SignUp_Right">
                                    <form action="#" method="post">
                                        <div class="row m-0">
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="cfield cfield_top">
                                                    <label for="" class="form-label">User Name</label>
                                                    <div class="cfield_Input">
                                                        <input type="text" placeholder="User Name" name="username" id="username" onkeypress="only_alphabets(event)" />
                                                        <i class="la la-user"></i>
                                                    </div>
                                                </div>
                                                <div class="error text-left" id="err_username"></div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="cfield cfield_top">
                                                    <label for="" class="form-label">Password</label>
                                                    <div class="cfield_Input">
                                                        <input type="password" placeholder="********" name="password" id="password" />
                                                        <i class="la la-key"></i>
                                                    </div>
                                                </div>
                                                <div class="error text-left" id="err_password"></div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="cfield">
                                                    <label for="" class="form-label">Email</label>
                                                    <div class="cfield_Input">
                                                        <input type="text" placeholder="Email" name="email" id="email" />
                                                        <i class="la la-envelope-o"></i>
                                                    </div>
                                                </div>
                                                <div class="error text-left" id="err_email"></div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="cfield">
                                                    <label for="" class="form-label">Phone Number</label>
                                                    <div class="cfield_Input">
                                                        <input type="text" placeholder="Phone Number" name="mobile" maxlength="10" id="mobile" onkeypress="only_number(event)" />
                                                        <i class="la la-phone"></i>
                                                    </div>
                                                </div>
                                                <div class="error text-left" id="err_mobile"></div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="cfield">
                                                    <label for="" class="form-label">Select Option</label>
                                                    <div class="cfield_Input">
                                                        <div class="dropdown-field">
                                                            <select name="service" class="chosen" id="service" multiple>
                                                                <option value="">Please Select Specialization</option>
                                                                <?php if(!empty($get_category)){
                                                                foreach ($get_category as $key) {?>
                                                                <option value="<?= $key->id?>"><?= $key->category_name?></option>
                                                                <?php  } } ?>
                                                            </select>
                                                        </div>
                                                        <i class="fa fa-angle-down"></i>
                                                    </div>
                                                </div>
                                                <div class="error text-left" id="err_service"></div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 SignUp_Btn">
                                                <input type="hidden" name="user_type" id="user_type">
                                                <button type="button" class="btn btn-info" onclick="return btn_register();">Signup</button>
                                            </div>
                                            <div id="register-messages"></div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="extra-login">
                                                    <span>OR</span>
                                                    <div class="login-social">
                                                        <a class="fb-login" href="#" title=""><i class="fa fa-facebook"></i></a>
                                                        <a class="tw-login" href="#" title=""><i class="fa fa-twitter"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="<?= base_url('assets/js/jquery.min.js')?>" type="text/javascript"></script>
<script type="text/javascript">
    function get_value(id) {
        $('#user_type').val(id);
    }
</script>
<script type="text/javascript" src="<?= base_url('assets/custom_js/register.js')?>"></script>
