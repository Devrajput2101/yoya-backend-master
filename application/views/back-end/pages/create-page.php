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
               <h4 class="mb-sm-0 font-size-18">Pages</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active">Page Create</li>
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
                        <h4 class="card-title">Page Create</h4>
                     </div>
                     <div class="col-md-4 text-right">
                        <div class="card-footer bg-transparent" style="margin-top: -15px;">
                           <div class="text-center">
                              <a href="<?= site_url('admin/page') ?>" class="btn btn-outline-dark btn-sm align-middle me-2" title="Pages" style="float: right;">
                              <i class="bx bx-arrow-back"></i>Pages
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?= form_open() ?>
                  <div class="col-md-11 mt-2">
                     <label>Page Type</label>
                     <div class="input-group" id="page_type">
                    <?php $type = array (""=>"select type","customer"=>"customer","driver"=>"driver"); ?>
                    <?= form_dropdown('page_type',$type,set_value('page_type'),'class="form-control"') ?>
                     </div>
                     <?= form_error('page_title', '<div class="error">', '</div>'); ?>
                  </div>
                  <div class="col-md-11 mt-2">
                     <label>Title</label>
                     <div class="input-group" id="Title">
                        <input type="text" class="form-control" placeholder="Page title" name="page_title" value="<?= set_value('page_title') ?>">
                        <span ></span>
                     </div>
                     <?= form_error('page_title', '<div class="error">', '</div>'); ?>
                  </div>
                     <div class="col-md-11 mt-2">
                     <label class="form-label">Page Description</label>
                     <div class="input-group" id="Description">
                     <textarea id="page_description" name="page_description" placeholder="Description" required class="form-control" rows="3"><?= set_value('page_description') ?></textarea>
                     </div> 
                     <?= form_error('page_description', '<div class="error">', '</div>'); ?>
                     </div> 
                  <div class="col-md-11 mt-2">
                     <label>image</label>
                     <div class="input-group" id="sale">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                           <div class="input-group-prepend">
                              <div class="input-group-text bg-soft-secondary font-weight-medium">Browse</div>
                           </div>
                           <div class="form-control file-amount">Choose File</div>
                           <input type="hidden" name="icon" class="selected-files" value="<?= set_value('page_image') ?>">
                        </div>
                        <div class="file-preview box sm">
                        </div>
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