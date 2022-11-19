<?php include(__DIR__.'/../common/_header.php'); ?>
<?php include(__DIR__.'/../common/_sidebar.php'); ?>
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <?php include(__DIR__.'/../common/_message.php'); ?>
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Jobprocess</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active">Jobprocess Create</li>
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
                        <h4 class="card-title">Jobprocess Create</h4>
                     </div>
                     <div class="col-md-4 text-right">
                        <div class="card-footer bg-transparent" style="margin-top: -15px;">
                           <div class="text-center">
                              <a href="<?= site_url('admin/jobprocess') ?>" class="btn btn-outline-dark btn-sm align-middle me-2" title="Pages" style="float: right;">
                              <i class="bx bx-arrow-back"></i>Jobprocess
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?= form_open() ?>
                  <div class="row mb-2 mt-2">
                     <div class="col-md-4">
                        <label>Job process Name</label>
                        <div class="input-group" id="name">
                           <input type="text" class="form-control" placeholder="Job process name" name="job_process_name" value="<?= set_value('job_process_name') ?>">
                           <span class="input-group-text"><i class="bx bx-user"></i></span>
                        </div>
                        <?= form_error('job_process_name', '<div class="error">', '</div>'); ?>
                     </div>
                     <div class="col-md-4">
                        <label>Job process icon</label>
                        <div class="input-group" id="sale">
                           <div class="input-group" data-toggle="aizuploader" data-type="image">
                              <div class="input-group-prepend">
                                 <div class="input-group-text bg-soft-secondary font-weight-medium">Browse</div>
                              </div>
                              <div class="form-control file-amount">Choose File</div>
                              <input type="hidden" name="icon" class="selected-files" value="<?= set_value('job_process_icon') ?>">
                           </div>
                           <div class="file-preview box sm">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <label>Job process Screen</label>
                        <div class="input-group" id="name">
                           <?php $process = array(''=>'--Select Application Screen--','cab'=>'Cab','outstation'=>'Outstations','rental'=>'Rental','package'=>'Package','transport'=>'Transport',); ?>
                           <?= form_dropdown('job_process_screen',$process,set_value('job_process_screen'),'class="form-control" id="job_process_screen"') ?>
                        </div>
                        <small><span class="text-danger">Note:</span> This screen use for mobile appliction only !</small>
                        <?= form_error('job_process_screen', '<div class="error">', '</div>'); ?>
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
<script> CKEDITOR.replace( 'page_description' ); </script>
<script src="<?= base_url('back-end') ?>/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<!-- form advanced init -->
<script src="<?= base_url('back-end') ?>/js/pages/form-advanced.init.js"></script>
<script src="<?= base_url('back-end') ?>/libs/simplebar/simplebar.min.js"></script>
<script src="https://transloadit.edgly.net/releases/uppy/v1.6.0/uppy.min.js"> </script>
<script src="<?= base_url('back-end') ?>/js/aiz-core.js"></script>