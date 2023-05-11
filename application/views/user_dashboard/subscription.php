 <section class="overlape">
     <div class="block no-padding">
         <div data-velocity="-.1"
             style="background: url('<?= base_url('assets/images/resource/mslider1.jpg')?>') repeat scroll 50% 422.28px transparent;"
             class="parallax scrolly-invisible no-parallax"></div>
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
                         <li class="breadcrumb-item active" aria-current="page">Subscription</li>
                     </ol>
                 </nav>
             </div>
         </div>
     </div>
 </section>

 <?php $this->load->view('sidebar');?>
 <div class="col-md-12 col-md-12 col-sm-12 display-table-cell v-align">
     <div class="user-dashboard">
         <div class="row row-sm">
             <div class="col-xl-12 col-lg-12 col-md-12">
                 <div class="cardak" style="background: #f2f2f2 !important;">
                     <div class="container">
                         <div class="row text-center align-items-end">
                             <!-- Pricing Table-->
                             <?php  if(!empty($subcriber_pack)) { foreach ($subcriber_pack as $key) {
                                                    $subcripe_pack=$this->Crud_model->get_single('subscription',"id='".$key->subscription_id."'");
                                                    $get_service=$this->Crud_model->GetData('subscription_service','',"subscription_id='".$subcripe_pack->id."'");

                                                    ?>
                             <div class="col-lg-4 mb-5 mb-lg-0">
                                 <div class="bg-white p-5 rounded-lg shadow" style="height: 500px;">
                                     <h1 class="h6 text-uppercase font-weight-bold mb-4">
                                         <?= $subcripe_pack->subscription_name; ?></h1>
                                     <h2 class="h1 font-weight-bold">
                                         $<?= ' '.$subcripe_pack->subscription_amount; ?><span
                                             class="text-small font-weight-normal ml-2">/ month</span></h2>

                                     <div class="custom-separator my-4 mx-auto bg-primary"></div>

                                     <ul class="list-unstyled my-5 text-small text-left" style="height: 100px;">
                                         <?php if(!empty($get_service)){ foreach ($get_service as $row) {?>
                                         <li class="mb-3"><i class="fa fa-check mr-2 text-primary"></i>
                                             <?= $row->service; ?></li>
                                         <?php }}?>

                                         <!--                                                             <li class="mb-3 text-muted">
                                                                <i class="fa fa-times mr-2"></i>
                                                                <del>Nam libero tempore</del>
                                                            </li>
                                                            <li class="mb-3 text-muted">
                                                                <i class="fa fa-times mr-2"></i>
                                                                <del>Sed ut perspiciatis</del>
                                                            </li> -->
                                     </ul>
                                     <a href="#" class="btn btn-primary btn-block p-2 shadow rounded-pill">Subscribe</a>
                                 </div>
                             </div>
                             <?php }} else{?>
                             <div class="col-lg-4 mb-5 mb-lg-0">
                                 <div class="bg-white p-5 rounded-lg shadow" style="height: 500px;">
                                     <h1 class="h6 text-uppercase font-weight-bold mb-4">No Data Found</h1>
                                 </div>
                             </div>
                             <?php } ?>
                             <!-- END -->

                             <!-- Pricing Table-->

                             <!-- END -->
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