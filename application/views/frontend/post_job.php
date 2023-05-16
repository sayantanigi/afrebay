
<?php
 if(!empty($get_banner->image) && file_exists('uploads/banner/'.$get_banner->image)){
     $banner_img=base_url("uploads/banner/".$get_banner->image);
            } else{
       $banner_img=base_url("assets/images/resource/mslider1.jpg");
        } ?>
            <section class="overlape">
                <div class="block no-padding">
                    <div data-velocity="-.1" style="background: url('<?php $banner_img ?>') repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div>
                    <!-- PARALLAX BACKGROUND IMAGE -->
                    <div class="container fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="inner-header">
                                    <h3>Post Jobs</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="block no-padding">
                    <div class="container">
                        <div class="row no-gape">
                            <div class="col-lg-12 column">
                                <div class="padding-left">
                                    <div class="profile-title">
                                        <h3>Post a New Job</h3>
                                    </div>
                                    <div class="profile-form-edit">
                                        <form method="post" action="<?php echo base_url('Welcome/save_postjob')?>" enctype="multipart/form-data" >
                                            <div class="row">
                                                <div class="col-lg-12">
                                             <span class="pf-title">Job Title<span style="color:red;">*</span></span>
                                                    <div class="pf-field">
                                                       <input type="text" placeholder="Enter Job Title" name="post_title" id="post_title" class="form-control " value="" data-role="tagsinput" required/>
                                                    </div>
                                                </div>
                                                  <div class="col-lg-12">
                                                    <span class="pf-title">Description</span>
                                                    <div class="pf-field">
                                                        <textarea name="description" id="description" placeholder="Enter Description"></textarea>

                                                    </div>
                                                </div>
                                                 <div class="col-lg-6">
                                             <span class="pf-title">Duration<span style="color:red;">*</span></span>
                                                    <div class="pf-field">
                                                        <input type="text" placeholder="Enter Duration" name="duration" class="form-control " value=""  required/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                             <span class="pf-title">Charges<span style="color:red;">*</span></span>
                                                    <div class="pf-field">
                                                        <input type="text" placeholder="Enter Charges" name="charges" class="form-control " value="" required/>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <span class="pf-title">Categories<span style="color:red;">*</span></span>
                                                    <div class="pf-field">
                                                        <select data-placeholder="Please Select Category" class="form-control" name="category_id" onchange="get_subcategory(this.value)" required>
                                                            <option value="">Select Category</option>
                                                            <?php foreach($category as $key) {?>
                                                            <option value="<?= $key->id; ?>"><?php echo $key->category_name;?></option>
                                                           <?php }?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <span class="pf-title">Sub Categories<span style="color:red;">*</span></span>
                                                    <div class="pf-field">
                                                        <select data-placeholder="Please Select " class="form-control" name="subcategory_id" value="" id="subcategory_id" required>
                                                            <option>Select Subcategory</option>

                                                        </select>
                                                    </div>
                                                </div>
                                               <!--  <div class="col-lg-6">
                                                    <span class="pf-title">Offerd Salary</span>
                                                    <div class="pf-field">
                                                        <select data-placeholder="Please Select Specialism" class="chosen">
                                                            <option>Web Development</option>
                                                            <option>Web Designing</option>
                                                            <option>Art & Culture</option>
                                                            <option>Reading & Writing</option>
                                                        </select>
                                                    </div>
                                                </div> -->

                                                <div class="col-lg-12">
                                                    <span class="pf-title">Application Deadline Date<span style="color:red;">*</span></span>
                                                    <div class="pf-field">
                                                        <input type="date" placeholder="Enter Complete Address" name="appli_deadeline" class="form-control datepicker" required/>
                                                    </div>
                                                </div>
                                               <!--  <div class="col-lg-12">
                                                    <span class="pf-title">Skill Requirments</span>
                                                    <div class="pf-field">
                                                        <ul class="tags">
                                                            <li class="addedTag">Photoshop<span onclick="$(this).parent().remove();" class="tagRemove">x</span><input type="hidden" name="tags[]" value="Web Deisgn" /></li>
                                                            <li class="tagAdd taglist">
                                                                <input type="text" id="search-field" />
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div> -->
                                               <!--  <div class="col-lg-6">
                                                    <span class="pf-title">Country</span>
                                                    <div class="pf-field">
                                                        <select data-placeholder="Please Select Specialism" class="chosen">
                                                            <option>Web Development</option>
                                                            <option>Web Designing</option>
                                                            <option>Art & Culture</option>
                                                            <option>Reading & Writing</option>
                                                        </select>
                                                    </div>
                                                </div> -->
                                                <!-- <div class="col-lg-6">
                                                    <span class="pf-title">City</span>
                                                    <div class="pf-field">
                                                        <select data-placeholder="Please Select Specialism" class="chosen">
                                                            <option>Web Development</option>
                                                            <option>Web Designing</option>
                                                            <option>Art & Culture</option>
                                                            <option>Reading & Writing</option>
                                                        </select>
                                                    </div>
                                                </div> -->
                                                <div class="col-lg-12">
                                                    <span class="pf-title">Complete Address</span>
                                                    <div class="pf-field">
                                                        <textarea id="complete_address"  name="complete_address" placeholder="Enter Address"></textarea>
                                                    </div>
                                                </div>

                                            </div>

                                    </div>
                                    <div class="contact-edit">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <span class="pf-title">Find On Map<span style="color:red;">*</span></span>
                                                    <div class="pf-field">
                                                        <input type="text" placeholder="Collins Street West, Victoria 8007, Australia." name="location" value="" id="location"  required autocomplete="off"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <span class="pf-title">Latitude</span>
                                                    <div class="pf-field">
                                                        <input type="text" id="search_lat" name="latitude"  placeholder="41.1589654" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <span class="pf-title">Longitude</span>
                                                    <div class="pf-field">
                                                        <input type="text" id="search_lon"   placeholder="21.1589654" name="longitude" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <button type="button" class="srch-lctn" onclick="return show_location();">Search Location</button>
                                                </div>
                                                <div class="col-lg-12">
                                                    <span class="pf-title">Maps</span>
                                                    <div class="pf-map" id="map">

                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <button type="submit">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/taginput.css')?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg==" crossorigin="anonymous" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js" integrity="sha512-VvWznBcyBJK71YKEKDMpZ0pCVxjNuKwApp4zLF3ul+CiflQi6aIJR+aZCP/qWsoFBA28avL5T5HA+RE+zrGQYg==" crossorigin="anonymous"></script>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
      CKEDITOR.replace('description');

   </script>
<script>

function show_location()
{
   var location=$('#location').val();
   $('#map').html('<iframe src="https://maps.google.it/maps?q='+location+'&output=embed"></iframe>');
   $('#complete_address').val(location);
}
</script>
