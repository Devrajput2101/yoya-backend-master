<?php include(__DIR__.'/../common/_header.php'); ?>
<?php include(__DIR__.'/../common/_sidebar.php'); ?>
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18"><?= $drivers->user_name ?> Profile</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active"><?= $drivers->user_name ?> Profile</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
               <i class="mdi mdi-block-helper me-2"></i>
               Your KYC Verification Still pending after upload your documents and wait some time for KYC update Process !
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
         </div>
         <div class="col-xl-4">
            <div class="card overflow-hidden">
               <div class="bg-primary bg-soft">
                  <div class="row">
                     <div class="col-7">
                        <div class="text-primary p-3">
                           <h5 class="text-primary"> Welcome Back <?= $drivers->user_name ?> !</h5>
                           <p> <?= $drivers->user_name ?> Dashboard</p>
                        </div>
                     </div>
                     <div class="col-5 align-self-end">
                        <img src="<?= base_url('back-end') ?>/images/profile-img.png" alt="" class="img-fluid">
                     </div>
                  </div>
               </div>
               <div class="card-body pt-0">
                  <div class="row">
                     <div class="col-sm-4">
                        <div class="avatar-md profile-user-wid mb-4">
                           <img src="<?= uploads_image($drivers->user_image); ?>" alt="" class="img-thumbnail rounded-circle avatar-md">
                        </div>
                        <h5 class="font-size-15 text-truncate"><?= $drivers->user_name ?></h5>
                        <p class="text-muted mb-0 text-truncate"><?= $drivers->user_type ?></p>
                     </div>
                     <div class="col-sm-8">
                        <div class="pt-4">
                           <div class="mt-4">
                              <a href="<?= site_url('admin/drivers/document/'.$drivers->user_id) ?>" class="btn btn-primary waves-effect waves-light btn-sm">Check Kyc<i class="mdi mdi-arrow-right ms-1"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xl-8">
            <div class="row">
               <div class="col-md-4">
                  <div class="card mini-stats-wid">
                     <div class="card-body">
                        <div class="d-flex">
                           <div class="flex-grow-1">
                              <p class="text-muted fw-medium">Complete Ride</p>
                              <h5 class="mb-0"><?= number_format($completeBookings) ?></h5>
                           </div>
                           <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                              <span class="avatar-title">
                              <i class="bx bx-car font-size-24"></i>
                              </span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="card mini-stats-wid">
                     <div class="card-body">
                        <div class="d-flex">
                           <div class="flex-grow-1">
                              <p class="text-muted fw-medium">Cancel Ride</p>
                              <h5 class="mb-0"><?= number_format($cancelBookings) ?></h5>
                           </div>
                           <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                              <span class="avatar-title rounded-circle bg-primary">
                              <i class="bx bx-car font-size-24"></i>
                              </span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="card mini-stats-wid">
                     <div class="card-body">
                        <div class="d-flex">
                           <div class="flex-grow-1">
                              <p class="text-muted fw-medium">Ongoing Ride</p>
                              <h5 class="mb-0"><?= number_format($ongoingBookings) ?></h5>
                           </div>
                           <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                              <span class="avatar-title rounded-circle bg-primary">
                              <i class="bx bx-car font-size-24"></i>
                              </span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="card mini-stats-wid">
                     <div class="card-body">
                        <div class="d-flex">
                           <div class="flex-grow-1">
                              <p class="text-muted fw-medium">Payout</p>
                              <h5 class="mb-0">0</h5>
                           </div>
                           <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                              <span class="avatar-title">
                              <i class="bx bx-copy-alt font-size-24"></i>
                              </span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="card mini-stats-wid">
                     <div class="card-body">
                        <div class="d-flex">
                           <div class="flex-grow-1">
                              <p class="text-muted fw-medium"><?= $config['web_appname'] ?> charges</p>
                              <h5 class="mb-0"><?= number_format($serviceCharge) ?></h5>
                           </div>
                           <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                              <span class="avatar-title rounded-circle bg-primary">
                              <i class="bx bx-wallet font-size-24"></i>
                              </span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="card mini-stats-wid">
                     <div class="card-body">
                        <div class="d-flex">
                           <div class="flex-grow-1">
                              <p class="text-muted fw-medium">Wallet balance</p>
                              <h5 class="mb-0"><?= number_format($walletsBlance) ?></h5>
                           </div>
                           <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                              <span class="avatar-title rounded-circle bg-primary">
                              <i class="bx bx-wallet font-size-24"></i>
                              </span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-xl-12">
         <div class="card">
            <div class="card-body">
               <h4 class="card-title"><?= $drivers->user_name ?> Transaction And details</h4>
               <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                  <li class="nav-item">
                     <a class="nav-link active" data-bs-toggle="tab" href="#wallet" role="tab">
                     <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                     <span class="d-none d-sm-block">Wallet</span>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" data-bs-toggle="tab" href="#booking" role="tab">
                     <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                     <span class="d-none d-sm-block">Booking</span>
                     </a>
                  </li>
               </ul>
               <div class="tab-content p-3 text-muted">
                  <div class="tab-pane active" id="wallet" role="tabpanel">
                     <div class="col-12">
                        <table class="table table-bordered dt-responsive nowrap w-100 datatable">
                           <thead>
                              <tr>
                                 <th class="align-middle">Sr.</th>
                                 <th class="align-middle">Amount</th>
                                 <th class="align-middle">Remark</th>
                                 <th class="align-middle">Transaction ID</th>
                                 <th class="align-middle">Credit/Debit</th>
                                 <th class="align-middle">Date</th>
                              </tr>
                           </thead>
                           <tbody>
                           <?php foreach($wallets->result() as $key => $data){ ?>
                              <tr>
                                 <td><?= $key + 1 ?></td>
                                 <td><?= $data->wallet_amount ?></td>
                                 <td><?= $data->wallet_description ?></td>
                                 <td><?= $data->wallet_transaction_id ?></td>
                                 <td>
                                    <?php if($data->wallet_transaction_type == '1'){ ?> 
                                       <span class="badge badge-pill badge-soft-success font-size-11">CR</span>
                                    <?php }else{ ?>
                                       <span class="badge badge-pill badge-soft-danger font-size-11">DR</span>
                                    <?php } ?>
                                    </td>
                                 <td><?= dateFormat($data->wallet_create_at) ?></td>
                              </tr>
                              <?php } ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <div class="tab-pane" id="booking" role="tabpanel">
                     <div class="col-12">
                        <table class="table table-bordered dt-responsive nowrap w-100 datatable">
                           <thead>
                              <tr>
                                 <th class="align-middle">Sr.</th>
                                 <th class="align-middle">Order ID</th>
                                 <th class="align-middle">Vehicle</th>
                                 <th class="align-middle">User</th>
                                 <th class="align-middle">Amount</th>
                                 <th class="align-middle">Setteld Amount</th>
                                 <th class="align-middle">Pickup Address</th>
                                 <th class="align-middle">Distance</th>
                                 <th class="align-middle">Time</th>
                                 <th class="align-middle">Booking Date</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php foreach($bookings->result() as $key => $data){ ?>
                              <tr>
                                 <td><?= $key + 1 ?></td>
                                 <td><?= $data->booking_order_id ?></td>
                                 <td><?= $data->vehicle_name ?></td>
                                 <td><?= $data->user_name ?></td>
                                 <td><?= $data->booking_total_amount ?></td>
                                 <td><?= $data->booking_amount_settled ?></td>
                                 <td><?= $data->booking_pickup_address ?></td>
                                 <td><?= $data->booking_distance_text ?></td>
                                 <td><?= $data->booking_time_text ?></td>
                                 <td><?= dateFormat($data->booking_create_at) ?></td>
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
</div>
<?php include(__DIR__.'/../common/_footer.php'); ?>
<script src="<?= base_url('back-end/libs/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('back-end/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('back-end/js/pages/datatables.init.js') ?>"></script>
<script>
   $(document).ready(function(){
      $('a[data-bs-toggle="tab"]').click(function (e) {
         e.preventDefault();
         $(this).tab('show');
      });

      $('a[data-bs-toggle="tab"]').on("shown.bs.tab", function (e) {
         var id = $(e.target).attr("href");
         localStorage.setItem('selectedTab', id)
      });

      var selectedTab = localStorage.getItem('selectedTab');
      if (selectedTab != null) {
         $('a[data-bs-toggle="tab"][href="' + selectedTab + '"]').tab('show');
      }
   });
</script>