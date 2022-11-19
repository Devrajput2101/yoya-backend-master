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
               <h4 class="mb-sm-0 font-size-18">States</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active">States Create</li>
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
                        <h4 class="card-title">States Create</h4>
                     </div>
                     <div class="col-md-4 text-right">
                        <div class="card-footer bg-transparent" style="margin-top: -15px;">
                           <div class="text-center">
                              <a href="<?= site_url('admin/states') ?>" class="btn btn-outline-dark btn-sm align-middle me-2" title="states" style="float: right;">
                              <i class="bx bx-arrow-back"></i> states
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
                              <?= form_dropdown('country_id',$country,set_value('country_id'),'class="form-control"') ?>
                          </div>
                           <?= form_error('country_id', '<div class="error">', '</div>'); ?>
                          </div>
                        <div class="col-md-6">
                           <label>State Name</label>
                           <div class="input-group" id="name">
                              <input type="text" class="form-control" placeholder="state name" name="state_name" value="<?= set_value('state_name') ?>">
                              <span class="input-group-text"><i class="bx bx-user"></i></span>
                           </div>
                           <?= form_error('state_name', '<div class="error">', '</div>'); ?>
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
<script src="https://transloadit.edgly.net/releases/uppy/v1.6.0/uppy.min.js"> 
</script>
<script src="<?= base_url('back-end') ?>/js/aiz-core.js"></script>