<?php
 if(!empty($get_banner->image) && file_exists('uploads/banner/'.$get_banner->image)){
     $banner_img=base_url("uploads/banner/".$get_banner->image);
            } else{
       $banner_img=base_url("assets/images/resource/mslider1.jpg");
        } ?>

<section class="overlape">
    <div class="block no-padding">
        <div data-velocity="-.1" style="background: url('<?= $banner_img ?>') repeat scroll 50% 422.28px transparent;"
            class="parallax scrolly-invisible no-parallax"></div>
        <!-- PARALLAX BACKGROUND IMAGE -->
        <div class="container fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-header">
                        <h3>Worker Detail</h3>
                    </div>
                    <!-- <div class="inner-header">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="skills-btn" style="text-transform: uppercase;">
                                        <a href="javascript:void(0)" title=""><?= @$user_detail->skills?></a> -->
                    <!--  <a href="javascript:void(0)" title="">Designers</a>
                                                    <a href="javascript:void(0)" title="">Illustrator</a> -->
                    <!-- </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="action-inner"> -->
                    <!--  <a href="javascript:void(0)" title=""><i class="la la-paper-plane"></i>Save Resume</a>
                                                    <a href="javascript:void(0)" title=""><i class="la la-envelope-o"></i>Contact David</a> -->
                    <!-- </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section>

<section class="overlape">
    <div class="block remove-top Worker_Detail">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- <div class="cand-single-user"> -->
                    <div class="worker_cand-single-user">
                        <div class="row m-0">
                            <div class="col-lg-2 col-md-4 col-sm-12">
                                <div class="can-detail-s">
                                    <div class="cst">
                                        <?php if(!empty($user_detail->profilePic)&& file_exists('uploads/users/'.@$user_detail->profilePic)){?>
                                        <img src="<?= base_url('uploads/users/'.@$user_detail->profilePic)?>" alt="" />
                                        <?php } else{?>
                                        <img src="<?= base_url('uploads/users/user.png')?>" alt="" />
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-4 col-sm-12 Worker_Head_Text">
                                <div class="Worker_Head_Text_Data">
                                    <h3><?php if(!empty($user_detail->firstname)){ echo $user_detail->firstname.' '.$user_detail->lastname;} else { echo $user_detail->username; }?>
                                    </h3>
                                    <span><i>UX / UI Designer</i> at Atract Solutions</span>
                                    <p><?= @$user_detail->email?></p>
                                    <p>Member Since, <?= date('Y',strtotime(@$user_detail->created))?></p>
                                    <p><i class="la la-map-marker"></i><?= @$user_detail->address?></p>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 Worker_Head_Social">
                                <div class="Worker_Head_Social_Data">
                                    <!-- <div class="share-bar circle">
                                        <a href="javascript:void(0)" title="" class="share-google">
                                            <i class="la la-google"></i>
                                        </a>
                                        <a href="javascript:void(0)" title="" class="share-fb">
                                            <i class="fa fa-facebook"></i>
                                        </a>
                                        <a href="javascript:void(0)" title="" class="share-twitter">
                                            <i class="fa fa-twitter"></i>
                                        </a>
                                    </div> -->
                                    <div class="download-cv">
                                        <a class="btn btn-info" href="<?= base_url('uploads/users/resume/'.@$user_detail->resume)?>" title="" download>Download CV <i class="la la-download"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- </div> -->
                    <ul class="cand-extralink">
                        <li><a href="#about" title="">About</a></li>
                        <li><a href="#education" title="">Education</a></li>
                        <li><a href="#experience" title="">Work Experience</a></li>
                        <li><a href="#skills" title="">Professional Skills</a></li>
                    </ul>
                    <div class="cand-details-sec">
                        <div class="row">
                            <div class="col-lg-8 column">
                                <div class="cand-details" id="about">
                                    <h2>Candidates About</h2>
                                    <p>
                                        <?= @$user_detail->short_bio;?>
                                    </p>

                                    <div class="edu-history-sec" id="education">
                                        <h2>Education</h2>
                                        <?php if(!empty($user_education)){ foreach($user_education as $edu){?>
                                        <div class="edu-history">
                                            <i class="la la-graduation-cap"></i>
                                            <div class="edu-hisinfo">
                                                <h3><?= ucfirst($edu->education)?></h3>
                                                <i><?= $edu->passing_of_year?></i>
                                                <span><?= $edu->college_name?><i><?= $edu->department?></i></span>
                                                <p><?= $edu->description?></p>
                                            </div>
                                        </div>
                                        <?php } }?>
                                        <!--  <div class="edu-history">
                                                        <i class="la la-graduation-cap"></i>
                                                        <div class="edu-hisinfo">
                                                            <h3>High School</h3>
                                                            <i>2008 - 2012</i>
                                                            <span>Tomms College <i>Bachlors in Fine Arts</i></span>
                                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin a ipsum tellus. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
                                                        </div>
                                                    </div> -->
                                    </div>
                                    <div class="edu-history-sec" id="experience">
                                        <h2>Work & Experience</h2>
                                        <?php if(!empty($user_work)){ foreach($user_work as $row){?>
                                        <div class="edu-history style2">
                                            <i></i>
                                            <div class="edu-hisinfo">
                                                <h3><?= ucfirst($row->designation)?><span><?= $row->company_name ?></span>
                                                </h3>
                                                <i><?= $row->duration?></i>
                                                <p><?= $row->description?></p>
                                            </div>
                                        </div>
                                        <?php } }?>
                                        <!--  <div class="edu-history style2">
                                                        <i></i>
                                                        <div class="edu-hisinfo">
                                                            <h3>CEO Founder <span>Inwave Studio</span></h3>
                                                            <i>2008 - 2012</i>
                                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin a ipsum tellus. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
                                                        </div>
                                                    </div> -->
                                    </div>

                                    <div class="progress-sec" id="skills">
                                        <h2>Professional Skills</h2>
                                        <div class="progress-sec" style="text-transform: uppercase;">
                                            <span><?= @$user_detail->skills ?></span>
                                            <!--  <div class="progressbar">
                                                              <div class="progress" style="width: 80%;"><span>80%</span></div>
                                                          </div> -->
                                        </div>

                                    </div>


                                </div>
                            </div>
                            <div class="col-lg-4 column">
                                <div class="job-overview">
                                    <h3>Job Overview</h3>
                                    <ul>
                                        <li>
                                            <i class="la la-mars-double"></i>
                                            <h3>Gender</h3>
                                            <span><?= @$user_detail->gender?></span>
                                        </li>
                                        <li>
                                            <i class="la la-shield"></i>
                                            <h3>Experience</h3>
                                            <span><?= @$user_detail->experience?></span>
                                        </li>
                                        <li>
                                            <i class="la la-line-chart"></i>
                                            <h3>Qualification</h3>
                                            <span><?= @$user_detail->qualification?></span>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Job Overview -->
                                <div class="quick-form-job">
                                    <h3>Rate This Freelancer</h3>

                                    <form method="post" action="<?= base_url('user/dashboard/save_employer_rating')?>">
                                        <div class="row m-0">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <span class="star-rating star-5">
                                                    <input type="radio" name="rating" value="1"><i></i>
                                                    <input type="radio" name="rating" value="2"><i></i>
                                                    <input type="radio" name="rating" value="3"><i></i>
                                                    <input type="radio" name="rating" value="4"><i></i>
                                                    <input type="radio" name="rating" value="5"><i></i>
                                                </span>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 Form_Subject">
                                                <input type="text" placeholder="Enter Subject" name="subject"
                                                    required />
                                                <input type="hidden" value="<?= @$user_detail->userId ?>"
                                                    name="user_id">
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 Form_Textarea">
                                                <textarea placeholder="Enter review" name="review"></textarea>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 Form_Btn">
                                                <?php if(!empty($_SESSION['afrebay']['userId'])&& $_SESSION['afrebay']['userType']==2){?>
                                                <button class="submit btn btn-info">Submit</button>
                                                <?php } else {?>
                                                <!-- <button type="button" class="submit btn btn-info" style=" pointer-events:none;">Submit</button> -->
                                                <a href="<?php echo base_url('login')?>" class="submit btn btn-info" style=" pointer-events:none;">Submit</a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <!--  <span>You accepts our <a href="javascript:void(0)" title="">Terms and Conditions</a></span> -->
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
