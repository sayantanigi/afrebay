<section class="overlape">
               <div class="block no-padding">
                   <div data-velocity="-.1" style="background: url('<?= base_url('assets/images/resource/mslider1.jpg')?>') repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div>
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
                                   <li class="breadcrumb-item active" aria-current="page">My Job</li>
                               </ol>
                           </nav>
                       </div>
                   </div>
               </div>
           </section>

            <?php $this->load->view('sidebar');?>
                       <div class="col-md-10 col-sm-11 display-table-cell v-align">
                           <div class="user-dashboard">
                               <div class="row row-sm">
                                   <div class="col-xl-12 col-lg-12 col-md-12">
                                       <div class="cardak">
                                           <table class="table table-bordered">
                                             <thead>
                                               <tr>
                                                 <th scope="col">#</th>
                                                 <th scope="col">Post Title</th>
                                                 <th scope="col">Duration</th>
                                                 <th scope="col">Bid Amount</th>
                                                 <th scope="col">Date</th>
                                                <th scope="col">Status</th>
                                               </tr>
                                             </thead>
                                             <tbody>
                                                 <?php

                                                   if(!empty($get_postjob)){
                                                     $i=1;
                                                     foreach ($get_postjob as $key)
                                                       {

                                                         ?>
                                                 <tr>
                                                   <th scope="row"><?= $i; ?></th>
                                                   <td><?=$key->post_title; ?></td>
                                                   <td><?=$key->duration; ?></td>
                                                   <td><?="USD"." ".$key->bid_amount; ?></td>

                                                   <td><?= date('d-M-Y',strtotime($key->created_date)); ?></td>
                                                   <td>
                                                     <?php if(@$key->bidding_status=='Pending'){?>
                                                     <a href="#" onclick="change_biddingstatus('<?= $key->id?>');"><span class="badge badge-warning" >
                                                       <?= @$key->bidding_status; ?></span></a>
                                                   <?php } else if(@$key->bidding_status=='Accept'){ ?>
                                                      <span class="badge badge-success"><?= @$key->bidding_status; ?></span>
                                                  <?php } else if(@$key->bidding_status=='Reject'){?>
                                                      <span class="badge badge-danger"><?= @$key->bidding_status; ?></span>
                                                  <?php } ?>
                                                   </td>

                                                 </tr>
                                                   <?php $i++; }}else{?>
                                               <tr>
                                                 <td colspan="5"><center>No Data Found</center></td>
                                               </tr>
                                             <?php } ?>
                                               </tbody>
                                           </table>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>

           </section>

           <script type="text/javascript">
             function change_biddingstatus(jobbid_id)
             {
               var cnf = confirm('Are you sure to change the status?');
  if(cnf==true)
  {
    $.ajax({
        type:"POST",
        url:'<?= base_url('user/dashboard/changebiddingstatus')?>',
        data:{jobbid_id:jobbid_id},
        success:function(returndata)
        {
          if(returndata==1){
          location.reload();
        }
        }
      });
  }
             }
           </script>
