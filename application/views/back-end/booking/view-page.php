<?php include(__DIR__.'/../common/_header.php'); ?>
<?php include(__DIR__.'/../common/_sidebar.php'); ?>
   <!-- ============================================================== -->
   <!-- Start right Content here -->
   <!-- ============================================================== -->
   <?php $user = json_decode($details->booking_user_details,true);  ?>
   <?php $book = $details; ?>
   
      <div class="page-content">
         <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
               <div class="col-12">
                  <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                     <h4 class="mb-sm-0 font-size-18">Booking Detail</h4>
                     <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                           <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                           <li class="breadcrumb-item active">Booking Detail</li>
                        </ol>
                     </div>
                  </div>
               </div>
            </div>
            <!-- end page title -->
            <div class="row">
               <div class="col-lg-12">
                  <div class="card">
                     <div class="card-body" >
                        <div class="invoice-title">
                           <h4 class="float-end font-size-16">Order # <?php echo isset($book->booking_order_id) ? $book->booking_order_id : ""; ?></h4>
                           <div class="mb-4" >
                              <img src="<?= $user['user_image'] ?>" alt="logo" height="70" style ="border-radius: 10px;"/>
                           </div>
                        </div>
                        <hr>
                        <div class="row">
                           <div class="col-sm-6">
                              <address>
                                 <strong>User Name :   </strong><?php echo isset($user['user_name']) ? $user['user_name'] : ""; ?><br>
                                 <strong>User mobile : </strong><?php echo isset($user['user_phone']) ? $user['user_phone'] : ""; ?><br>
                                 <strong>User email :  </strong><?php echo isset($user['user_email']) ? $user['user_email'] : ""; ?><br>
                              </address>
                           </div>
                           <div class="col-sm-6 text-sm-end">
                              <address class="mt-2 mt-sm-0">
                                 <strong>Pickup City : </strong><?php echo isset($book->booking_pickup_city) ? $book->booking_pickup_city : ""; ?><br>
                                 <strong>Pickup Address : </strong><?php echo isset($book->booking_pickup_address) ? $book->booking_pickup_address : ""; ?><br>
                                 <strong>Distance : </strong><?php echo isset($book->booking_distance_text) ? $book->booking_distance_text : ""; ?><br>
                                 <strong>Time : </strong><?php echo isset($book->booking_time_text) ? $book->booking_time_text : ""; ?><br>
                              </address>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-6 mt-3">
                              <address>
                                 <strong>Payment Method:</strong><br>
                                 Visa ending **** 4242<br>
                                 jsmith@email.com
                              </address>
                           </div>
                           <div class="col-sm-6 mt-3 text-sm-end">
                              <address>
                                 <strong>Order Date : </strong><?php echo dateFormat('d-M-Y',$book->booking_booking_date); ?><br>
                              </address>
                           </div>
                        </div>
                        <div class="py-2 mt-3">
                           <h3 class="font-size-15 fw-bold">Order summary</h3>
                        </div>
                        <div class="table-responsive">
                           <table class="table table-nowrap">
                              <thead>
                                 <tr>
                                    <th style="width: 70px;">No.</th>
                                    <th>Item</th>
                                    <th class="text-end">Price</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr>
                                    <td>01</td>
                                    <td>Skote - Admin Dashboard Template</td>
                                    <td class="text-end">$499.00</td>
                                 </tr>
                                 <tr>
                                    <td>02</td>
                                    <td>Skote - Landing Template</td>
                                    <td class="text-end">$399.00</td>
                                 </tr>
                                 <tr>
                                    <td>03</td>
                                    <td>Veltrix - Admin Dashboard Template</td>
                                    <td class="text-end">$499.00</td>
                                 </tr>
                                 <tr>
                                    <td colspan="2" class="text-end">Sub Total</td>
                                    <td class="text-end">$1397.00</td>
                                 </tr>
                                 <tr>
                                    <td colspan="2" class="border-0 text-end">
                                       <strong>Shipping</strong>
                                    </td>
                                    <td class="border-0 text-end">$13.00</td>
                                 </tr>
                                 <tr>
                                    <td colspan="2" class="border-0 text-end">
                                       <strong>Total</strong>
                                    </td>
                                    <td class="border-0 text-end">
                                       <h4 class="m-0">$1410.00</h4>
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                        <!--<div class="d-print-none">-->
                        <!--   <div class="float-end">-->
                        <!--      <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i class="fa fa-print"></i></a>-->
                        <!--      <a href="#" class="btn btn-primary w-md waves-effect waves-light">Send</a>-->
                        <!--   </div>-->
                        <!--</div>-->
                     </div>
                  </div>
               </div>
            </div>
            <!-- end row -->
         </div>
         <!-- container-fluid -->
      </div>
      <!-- End Page-content -->
<?php include(__DIR__.'/../common/_footer.php'); ?>