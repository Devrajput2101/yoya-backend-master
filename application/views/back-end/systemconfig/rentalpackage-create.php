<?php include(__DIR__.'/../common/_header.php'); ?>
<?php include(__DIR__.'/../common/_sidebar.php'); ?>
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <?php include(__DIR__.'/../common/_message.php'); ?>
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Vehicle Rental Package</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active">Vehicle Rental Package</li>
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
                        <h4 class="card-title">Rental Package Create</h4>
                     </div>
                     <div class="col-md-4 text-right">
                        <div class="card-footer bg-transparent" style="margin-top: -15px;">
                           <div class="text-center">
                              <a href="<?= site_url('admin/rentalpackage') ?>" class="btn btn-outline-dark btn-sm align-middle me-2" title="Pages" style="float: right;">
                              <i class="bx bx-arrow-back"></i> Rental Package
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?= form_open() ?>
                  <div class="row mb-2 mt-2">
                     <div class="col-md-4">
                        <label>Rental Name</label>
                        <div class="input-group" id="Rental Name">
                           <input type="text" class="form-control" placeholder="Rental Name" name="rental_name" value="<?= set_value('rental_name') ?>">
                        </div>
                        <?= form_error('rental_name', '<div class="error">', '</div>'); ?>
                     </div>
                     <div class="col-md-4">
                        <label>Rental Hour Value</label>
                        <div class="input-group" id="rental_hour_value">
                           <input type="text" class="form-control" placeholder="Rental Hour Value" name="rental_hour_value" value="<?= set_value('rental_hour_value') ?>">
                        </div>
                        <?= form_error('rental_hour_value', '<div class="error">', '</div>'); ?>
                     </div>
                     <div class="col-md-4">
                        <label>Rental Distance Value</label>
                        <div class="input-group" id="Rental Distance Value">
                           <input type="text" class="form-control" placeholder="Rental Distance Value" name="rental_distance_value" value="<?= set_value('rental_distance_value') ?>">
                        </div>
                        <?= form_error('rental_distance_value', '<div class="error">', '</div>'); ?>
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