<?php include(__DIR__.'/../common/_header.php'); ?>
<?php include(__DIR__.'/../common/_sidebar.php'); ?>
<div class="page-content">
<div class="container-fluid">
   <div class="row">
      <?php include(__DIR__.'/../common/_message.php'); ?>
      <div class="col-12">
         <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Vehicle Rental fare</h4>
            <div class="page-title-right">
               <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                  <li class="breadcrumb-item active">Vehicle Rental Fare update</li>
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
                     <h4 class="card-title">Vehicle Rental Fare update</h4>
                  </div>
                  <div class="col-md-4 text-right">
                     <div class="card-footer bg-transparent" style="margin-top: -15px;">
                        <div class="text-center">
                           <a href="<?= site_url('admin/rental') ?>" class="btn btn-outline-dark btn-sm align-middle me-2" title="Pages" style="float: right;">
                           <i class="bx bx-arrow-back"></i>Vehicle Rental fare
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
                        <?= form_dropdown('country_id',$country,set_value('country_id',$single->country_id),'class="form-control" id="country_id"') ?>
                     </div>
                     <?= form_error('country_id', '<div class="error">', '</div>'); ?>
                  </div>
                  <div class="col-md-6">
                     <label>Select State</label>
                     <div class="input-group" id="state">
                        <?= form_dropdown('state_id',$states,set_value('state_id',$single->state_id),'class="form-control" id="state_id" placeholder="Select State"') ?>
                     </div>
                     <?= form_error('state_id', '<div class="error">', '</div>'); ?>
                  </div>
               </div>
               <div class="row mb-2 mt-2">
                  <div class="col-md-6">
                     <label>Select City</label>
                     <div class="input-group" id="city_id">
                        <?= form_dropdown('city_id',$cities,set_value('city_id',$single->city_id),'class="form-control" id="city_id" placeholder="Select city" ') ?>
                     </div>
                     <?= form_error('city_id', '<div class="error">', '</div>'); ?>
                  </div>
                  <div class="col-md-6">
                     <label>Select Vehicle</label>
                     <div class="input-group" id="vehicle_id">
                        <?= form_dropdown('vehicle_id',$vehicles,set_value('vehicle_id',$single->vehicle_id),'class="form-control"') ?>
                     </div>
                     <?= form_error('vehicle_id', '<div class="error">', '</div>'); ?>
                  </div>
               </div>
               <div class="row mb-2 mt-2">
                  <div class="col-md-6">
                     <label>Per Minutes</label>
                     <div class="input-group" id="fare_base_price">
                        <input type="text" class="form-control" placeholder="base price" name="fare_base_price" value="<?= set_value('fare_base_price',$single->fare_base_price) ?>">
                     </div>
                     <?= form_error('fare_base_price', '<div class="error">', '</div>'); ?>
                  </div>
                  <div class="col-md-6">
                     <label>General Price</label>
                     <div class="input-group" id="fare_general_price">
                        <input type="text" class="form-control" placeholder="general price" name="fare_general_price" value="<?= set_value('fare_general_price',$single->fare_general_price) ?>">
                     </div>
                     <?= form_error('fare_general_price', '<div class="error">', '</div>'); ?>
                  </div>
                  </div>
                  <div class="row mb-2 mt-2">
                    <div class="col-md-6">
                        <label>Per Minutes</label>
                        <div class="input-group" id="fare_per_minutes">
                            <input type="text" class="form-control" placeholder="Per Minutes" name="fare_per_minutes" value="<?= set_value('fare_per_minutes',$single->fare_per_minutes) ?>">
                        </div>
                        <?= form_error('fare_per_minutes', '<div class="error">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                        <label>Select Package</label>
                        <div class="input-group" id="fare_rental_id">
                            <?= form_dropdown('fare_rental_id',$rentalpakages,set_value('fare_rental_id',$single->fare_rental_id),'class="form-control"') ?>
                        </div>
                        <?= form_error('fare_rental_id', '<div class="error">', '</div>'); ?>
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








