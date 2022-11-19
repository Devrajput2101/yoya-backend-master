<?php include(__DIR__.'/../common/_header.php'); ?>
<?php include(__DIR__.'/../common/_sidebar.php'); ?>
<!-- page wise css -->
<script src="<?= base_url('back-end') ?>/ckeditor/ckeditor.js" type="text/javascript"></script>
<link href="<?= base_url('back-end') ?>/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?= base_url('back-end') ?>/libs/%40chenfengyuan/datepicker/datepicker.min.css">
<!-- page wise css -->
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <?php include(__DIR__.'/../common/_message.php'); ?>
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Vehicles</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active">Vehicle Update</li>
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
                        <h4 class="card-title">Vehicle Update</h4>
                     </div>
                     <div class="col-md-4 text-right">
                        <div class="card-footer bg-transparent" style="margin-top: -15px;">
                           <div class="text-center">
                              <a href="<?= site_url('admin/vehicle') ?>" class="btn btn-outline-dark btn-sm align-middle me-2" title="pages" style="float: right;">
                              <i class="bx bx-arrow-back"></i> vehicles
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
                   <?= form_open() ?>
                        <div class="col-md-12">
                           <label>Vehicle Name</label>
                           <div class="input-group" id="name">
                              <input type="text" class="form-control" placeholder="vehicle name" name="vehicle_name" value="<?= set_value('vehicle_name',$vehicle_data->vehicle_name) ?>">
                              <span class="input-group-text"><i class="bx bx-user"></i></span>
                           </div>
                           <?= form_error('vehicle_name', '<div class="error">', '</div>'); ?>
                        </div>
                        <div class="col-md-12">
                           <label>Vahicle type Select</label>
                           <div class="input-group" id="Phone">
                               <?= form_dropdown('vehicle_type_id',$vehicle_type,set_value('vehicle_type_id',$vehicle_data->vehicle_vehicle_type_id),'class="form-control"') ?>
                          </div>
                           <?= form_error('vehicle_type_id', '<div class="error">', '</div>'); ?>
                         </div>
                       <div class="col-md-12">
                            <label>Job process icon</label>
                            <div class="input-group" id="sale">
                                  <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">Browse</div>
                                    </div>
                                    <div class="form-control file-amount">Choose File</div>
                                    <input type="hidden" name="icon" class="selected-files" value="<?= set_value('icon',$vehicle_data->vehicle_icon) ?>">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                            </div>
                       </div>
                         <div class="col-md-12">
                           <label>Vahicle Description</label>
                           <div class="input-group" id="Description">
                             <textarea id="vehicle_description" name="vehicle_description" placeholder="Description" required class="form-control" rows="4"><?= set_value('vehicle_description',$vehicle_data->vehicle_description) ?></textarea>
                          </div>
                           <?= form_error('vehicle_description', '<div class="error">', '</div>'); ?>
                         </div>
                     <div class="row mt-4">
                        <div class="col-md-6">
                           <button type="submit" class="btn btn-primary waves-effect waves-light">
                           <i class="bx bx-save font-size-16 align-middle me-2"></i>Update
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
<script> CKEDITOR.replace( 'page_description' ); </script>
<script src="<?= base_url('back-end') ?>/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url('back-end') ?>/js/pages/form-advanced.init.js"></script>
<script src="<?= base_url('back-end') ?>/libs/simplebar/simplebar.min.js"></script>

