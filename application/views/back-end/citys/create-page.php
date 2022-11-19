<?php include(__DIR__.'/../common/_header.php'); ?>
<?php include(__DIR__.'/../common/_sidebar.php'); ?>
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <?php include(__DIR__.'/../common/_message.php'); ?>
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Citys</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active">Citys Create</li>
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
                        <h4 class="card-title">Citys Create</h4>
                     </div>
                     <div class="col-md-4 text-right">
                        <div class="card-footer bg-transparent" style="margin-top: -15px;">
                           <div class="text-center">
                              <a href="<?= site_url('admin/citys') ?>" class="btn btn-outline-dark btn-sm align-middle me-2" title="Citys" style="float: right;">
                              <i class="bx bx-arrow-back"></i> citys
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?= form_open() ?>
                  <div class="row mb-2 mt-2">
                     <div class="col-md-6">
                        <label>Select Country</label>
                        <div class="input-group" id="Country">
                           <?= form_dropdown('country_id',$country,set_value('country_id'),'class="form-control" id="country_id"') ?>
                        </div>
                        <?= form_error('country_id', '<div class="error">', '</div>'); ?>
                     </div>
                     <div class="col-md-6">
                        <label>Select State</label>
                        <div class="input-group" id="state_id">
                           <?= form_dropdown('state_id','',set_value('state_id'),'class="form-control" id="state_id"') ?>
                        </div>
                        <?= form_error('state_id', '<div class="error">', '</div>'); ?>
                     </div>
                  </div>
                  <div class="row mb-2 mt-2">
                     <div class="col-md-6">
                        <label>City Name</label>
                        <div class="input-group" id="name">
                           <input type="text" class="form-control" placeholder="City name" name="city_name" value="<?= set_value('city_name') ?>">
                           <span class="input-group-text"><i class="bx bx-user"></i></span>
                        </div>
                        <?= form_error('city_name','<div class="error">', '</div>'); ?>
                     </div>
                     <div class="col-md-6">
                        <label>Vehicle icon</label>
                        <div class="input-group" id="sale">
                           <div class="input-group" data-toggle="aizuploader" data-type="image">
                              <div class="input-group-prepend">
                                 <div class="input-group-text bg-soft-secondary font-weight-medium">Browse</div>
                              </div>
                              <div class="form-control file-amount">Choose File</div>
                              <input type="hidden" name="city_icon" class="selected-files" value="<?= set_value('city_icon') ?>">
                           </div>
                           <div class="file-preview box sm">
                           </div>
                        </div>
                        <?= form_error('city_icon','<div class="error">','</div>'); ?>
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