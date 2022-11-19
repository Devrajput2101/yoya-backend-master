<?php include(__DIR__.'/../common/_header.php'); ?>
<?php include(__DIR__.'/../common/_sidebar.php'); ?>
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <?php include(__DIR__.'/../common/_message.php'); ?>
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Cancellation Charges Create</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active">Cancellation Charges Create
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-12">
            <div class="card">
               <div class="card-body">
                  <div class="row mb-4">
                     <div class="col-md-8">
                        <h4 class="card-title">Cancellation Charges Create</h4>
                     </div>
                     <div class="col-md-4 text-right">
                        <div class="card-footer bg-transparent" style="margin-top: -15px;">
                           <div class="text-center">
                              <a href="<?= site_url('admin/cancelation') ?>" class="btn btn-outline-dark btn-sm align-middle me-2" title="Pages" style="float: right;">
                              <i class="bx bx-arrow-back"></i>Cancellation Charges
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?= form_open() ?>
                  <div class="row mb-2 mt-2">
                     <div class="col-md-6">
                        <label>Select Country</label>
                        <div class="input-group" id="country">
                           <?= form_dropdown('country_id',$country,set_value('country_id'),'class="form-control" id="country_id"') ?>
                        </div>
                        <?= form_error('country_id', '<div class="error">', '</div>'); ?>
                     </div>
                     <div class="col-md-6">
                        <label>Select State</label>
                        <div class="input-group" id="state">
                           <?= form_dropdown('state_id',[''=>'--Select State--'],set_value('state_id'),'class="form-control" id="state_id" placeholder="Select State"') ?>
                        </div>
                        <?= form_error('state_id', '<div class="error">', '</div>'); ?>
                     </div>
                  </div>
                  <div class="row mb-2 mt-2">
                     <div class="col-md-6">
                        <label>Select City</label>
                        <div class="input-group" id="city_id">
                           <?= form_dropdown('city_id',[''=>'--Select City--'],set_value('city_id'),'class="form-control" id="city_id" placeholder="Select city" ') ?>
                        </div>
                        <?= form_error('city_id', '<div class="error">', '</div>'); ?>
                     </div>
                     <div class="col-md-6">
                        <label>Cancel Applied User<small>&nbsp Applied Charge For Cancelled Booking.</small></label>
                        <div class="input-group" id="cancel_applied_user">
                           <input type="text" class="form-control" placeholder="Cancel Applied User" name="cancel_applied_user" value="<?= set_value('cancel_applied_user') ?>">
                        </div>
                        <?= form_error('cancel_applied_user', '<div class="error">', '</div>'); ?>
                     </div>
                  </div>
                  <div class="row mb-2 mt-2">
                     <div class="col-md-6">
                        <label>Cancel Applied Driver <small>&nbsp Applied Charge After Cancelled Booking.</small></label>
                        <div class="input-group" id="cancel_applied_driver">
                           <input type="text" class="form-control" placeholder="Cancel Applied Driver" name="cancel_applied_driver" value="<?= set_value('cancel_applied_driver') ?>">
                        </div>
                        <?= form_error('cancel_applied_driver', '<div class="error">', '</div>'); ?>
                     </div>
                     <div class="col-md-6">
                        <label>Cancel Applied Amount</label>
                        <div class="input-group" id="cancel_applied_amount">
                           <input type="text" class="form-control" placeholder="Cancel Applied Amount" name="cancel_applied_amount" value="<?= set_value('cancel_applied_amount') ?>">
                        </div>
                        <?= form_error('cancel_applied_amount', '<div class="error">', '</div>'); ?>
                     </div>
                  </div>



                  <div class="row mt-4">
                     <div class="col-md-6">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-save font-size-16 align-middle me-2"></i>submit
                        </button>
                     </div>
                  </div>
                  <?= form_close() ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- End Page-content -->
<?php include(__DIR__.'/../common/_footer.php'); ?>
<?php include(__DIR__.'/../common/_get_dependent_location.php'); ?>
