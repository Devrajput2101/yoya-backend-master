<?php include(__DIR__.'/../common/_header.php'); ?>
<?php include(__DIR__.'/../common/_sidebar.php'); ?>
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <?php include(__DIR__.'/../common/_message.php'); ?>
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Out of Station fare</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active">Out of Station fare Create</li>
                  </ol>
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
                        <h4 class="card-title">Out of Station fare Create</h4>
                     </div>
                     <div class="col-md-4 text-right">
                        <div class="card-footer bg-transparent" style="margin-top: -15px;">
                           <div class="text-center">
                              <a href="<?= site_url('admin/outstation') ?>" class="btn btn-outline-dark btn-sm align-middle me-2" title="Pages" style="float: right;">
                              <i class="bx bx-arrow-back"></i>Out of Station fare
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
                           <?= form_dropdown('state_id','',set_value('state_id'),'class="form-control" id="state_id" placeholder="Select State"') ?>
                        </div>
                        <?= form_error('state_id', '<div class="error">', '</div>'); ?>
                     </div>
                  </div>
                  <div class="row mb-2 mt-2">
                     <div class="col-md-6">
                        <label>Select City</label>
                        <div class="input-group" id="city_id">
                           <?= form_dropdown('city_id','',set_value('city_id'),'class="form-control" id="city_id" placeholder="Select city" ') ?>
                        </div>
                        <?= form_error('city_id', '<div class="error">', '</div>'); ?>
                     </div>
                     <div class="col-md-6">
                        <label>Select Vehicle</label>
                        <div class="input-group" id="vehicle_id">
                           <?= form_dropdown('vehicle_id',$vehicles,set_value('vehicle_id'),'class="form-control"') ?>
                        </div>
                        <?= form_error('vehicle_id', '<div class="error">', '</div>'); ?>
                     </div>
                  </div>
                  <div class="row mb-2 mt-2">
                     <div class="col-md-6">
                        <label>Base Price</label>
                        <div class="input-group" id="fare_base_price">
                           <input type="text" class="form-control" placeholder="base price" name="fare_base_price" value="<?= set_value('fare_base_price') ?>">
                        </div>
                        <?= form_error('fare_base_price', '<div class="error">', '</div>'); ?>
                     </div>
                     <div class="col-md-6">
                        <label>Fare Price Per KM</label>
                        <div class="input-group" id="fare_per_km_price">
                           <input type="text" class="form-control" placeholder="Fare Price Per KM" name="fare_per_km_price" value="<?= set_value('fare_per_km_price') ?>">
                        </div>
                        <?= form_error('fare_general_price', '<div class="error">', '</div>'); ?>
                     </div>
                  </div>
                  <div class="row mb-2 mt-2">
                     <div class="col-md-6">
                        <label>Fare price Per Minute</label>
                        <div class="input-group" id="fare_per_minutes_price">
                           <input type="text" class="form-control" placeholder="Fare price Per Minute" name="fare_per_minutes_price" value="<?= set_value('fare_per_minutes_price') ?>">
                        </div>
                        <?= form_error('fare_per_minutes_price', '<div class="error">', '</div>'); ?>
                     </div>
                     <div class="col-md-6">
                        <label>Night Price</label>
                        <div class="input-group" id="fare_business_price">
                           <input type="text" class="form-control" placeholder="night price" name="fare_night_price" value="<?= set_value('fare_night_price') ?>">
                        </div>
                        <?= form_error('fare_night_price', '<div class="error">', '</div>'); ?>
                     </div>
                  </div>
                  <div class="row mb-2 mt-2">
                     <div class="col-md-6">
                        <label>Fare Drivers Price</label>
                        <div class="input-group" id="fare_driver_allowance">
                           <input type="text" class="form-control" placeholder="Fare Driver Allowance" name="fare_driver_allowance" value="<?= set_value('fare_driver_allowance') ?>">
                        </div>
                        <?= form_error('fare_driver_allowance', '<div class="error">', '</div>'); ?>
                     </div>
                     <div class="col-md-6">
                        <label>Commission</label>
                        <div class="input-group" id="fare_commission">
                           <input type="text" class="form-control" placeholder="fare commission" name="fare_commission" value="<?= set_value('fare_commission') ?>">
                        </div>
                        <?= form_error('fare_commission', '<div class="error">', '</div>'); ?>
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
   <!-- container-fluid -->
</div>
<!-- End Page-content -->
<?php include(__DIR__.'/../common/_footer.php'); ?>
<?php include(__DIR__.'/../common/_get_dependent_location.php'); ?>