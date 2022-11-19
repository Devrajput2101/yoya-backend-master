<?php include(__DIR__.'/../common/_header.php'); ?>
<?php include(__DIR__.'/../common/_sidebar.php'); ?>
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <?php include(__DIR__.'/../common/_message.php'); ?>
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Vehicle Transport Fare update</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active">Vehicle Transport Fare</li>
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
                        <h4 class="card-title">Vehicle Transport Fare update</h4>
                     </div>
                     <div class="col-md-4 text-right">
                        <div class="card-footer bg-transparent" style="margin-top: -15px;">
                           <div class="text-center">
                              <a href="<?= site_url('admin/transport') ?>" class="btn btn-outline-dark btn-sm align-middle me-2" title="Pages" style="float: right;">
                              <i class="bx bx-arrow-back"></i>Vehicle Transport Fare update
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
                           <?= form_dropdown('country_id',$country,set_value('country_id',$transport->fare_country_id),'class="form-control" id="country_id"') ?>
                        </div>
                        <?= form_error('fare_country_id', '<div class="error">', '</div>'); ?>
                     </div>
                     <div class="col-md-6">
                        <label>Select State</label>
                        <div class="input-group" id="state">
                           <?= form_dropdown('state_id',$states,set_value('state_id',$transport->fare_state_id),'class="form-control" id="state_id" placeholder="Select State"') ?>
                        </div>
                        <?= form_error('fare_state_id', '<div class="error">', '</div>'); ?>
                     </div>
                  </div>
                  <div class="row mb-2 mt-2">
                     <div class="col-md-6">
                        <label>Select City</label>
                        <div class="input-group" id="city_id">
                           <?= form_dropdown('city_id',$cities,set_value('city_id',$transport->fare_city_id),'class="form-control" id="city_id" placeholder="Select city" ') ?>
                        </div>
                        <?= form_error('fare_city_id', '<div class="error">', '</div>'); ?>
                     </div>
                     <div class="col-md-6">
                        <label>Select Vehicle</label>
                        <div class="input-group" id="vehicle_id">
                           <?= form_dropdown('vehicle_id',$vehicles,set_value('vehicle_id',$transport->fare_vehicle_id),'class="form-control"') ?>
                        </div>
                        <?= form_error('vehicle_id', '<div class="error">', '</div>'); ?>
                     </div>
                  </div>
                  <div class="row mb-2 mt-2">
                     <div class="col-md-6">
                        <label>base price</label>
                        <div class="input-group" id="fare_base_price">
                           <input type="text" class="form-control" placeholder="base price" name="fare_base_price" value="<?= set_value('fare_base_price',$transport->fare_base_price) ?>">
                        </div>
                        <?= form_error('fare_base_price', '<div class="error">', '</div>'); ?>
                     </div>
                     <div class="col-md-6">
                        <label>General Price</label>
                        <div class="input-group" id="fare_general_price">
                           <input type="text" class="form-control" placeholder="general price" name="fare_general_price" value="<?= set_value('fare_general_price',$transport->fare_general_price) ?>">
                        </div>
                        <?= form_error('fare_general_price', '<div class="error">', '</div>'); ?>
                     </div>
                  </div>
                  <div class="row mb-2 mt-2">
                     <div class="col-md-6">
                        <label>Fare Business</label>
                        <div class="input-group" id="fare_business_price">
                           <input type="text" class="form-control" placeholder="Fare Business Price" name="fare_business_price" value="<?= set_value('fare_business_price',$transport->fare_business_price) ?>">
                        </div>
                        <?= form_error('fare_business_price', '<div class="error">', '</div>'); ?>
                     </div>
                     <div class="col-md-6">
                        <label>Fare Night Price</label>
                        <div class="input-group" id="fare_night_price">
                           <input type="text" class="form-control" placeholder="Fare Night Price" name="fare_night_price" value="<?= set_value('fare_night_price',$transport->fare_night_price) ?>">
                        </div>
                        <?= form_error('fare_night_price', '<div class="error">', '</div>'); ?>
                     </div>
                  </div>
                  <div class="row mb-2 mt-2">
                     <div class="col-md-6">
                        <label>Fare Extra Waiting Price</label>
                        <div class="input-group" id="fare_extra_waiting_price">
                           <input type="text" class="form-control" placeholder="Fare Extra Waiting Price" name="fare_extra_waiting_price" value="<?= set_value('fare_extra_waiting_price',$transport->fare_extra_waiting_price) ?>">
                        </div>
                        <?= form_error('fare_extra_waiting_price', '<div class="error">', '</div>'); ?>
                     </div>
                     <div class="col-md-6">
                        <label>Fare Stop Price</label>
                        <div class="input-group" id="fare_stop_price">
                           <input type="text" class="form-control" placeholder="Fare Stop Price" name="fare_stop_price" value="<?= set_value('fare_stop_price',$transport->fare_stop_price) ?>">
                        </div>
                        <?= form_error('fare_stop_price', '<div class="error">', '</div>'); ?>
                     </div>
                  </div>
                  <div class="row mb-2 mt-2">
                     <div class="col-md-6">
                        <label>Fare Commission</label>
                        <div class="input-group" id="fare_commission">
                           <input type="text" class="form-control" placeholder="Fare Commission" name="fare_commission" value="<?= set_value('fare_commission',$transport->fare_commission) ?>">
                        </div>
                        <?= form_error('fare_commission', '<div class="error">', '</div>'); ?>
                     </div>
                     <div class="col-md-6">
                        <label>Fare Time Free</label>
                        <div class="input-group" id="fare_stop_price">
                           <input type="text" class="form-control" placeholder="Fare Time Free" name="fare_time_free" value="<?= set_value('fare_time_free',$transport->fare_time_free) ?>">
                        </div>
                        <?= form_error('fare_time_free', '<div class="error">', '</div>'); ?>
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