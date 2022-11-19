<?php include(__DIR__.'/../common/_header.php'); ?>
<?php include(__DIR__.'/../common/_sidebar.php'); ?>
<link href="<?= base_url('back-end/') ?>/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
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
         <div class="col-md-12"> 
            <div class="card border border-primary">
                <div class="card-header bg-transparent border-primary">
                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>Information</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Here is merged job process cities wise and find that application and esy to filter for vehicle search</p>
                </div>
            </div>
         </div>
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
                              <a href="<?= site_url('admin/Jobprocesscites') ?>" class="btn btn-outline-dark btn-sm align-middle me-2" title="Pages" style="float: right;">
                              <i class="bx bx-arrow-back"></i>Jobprocess
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?= form_open() ?>
                  <div class="row mb-2 mt-2">
                     <div class="col-lg-6">
                       <div class="mb-3">
                           <label class="form-label">Cities</label>
                           <?= form_dropdown('cities_id',$cities,set_value('cities_id',$process_data->cities_id),'class="form-control"') ?>
                           <?= form_error('cities_id', '<div class="error">', '</div>'); ?>
                       </div>
                     </div>
                     <div class="col-lg-6">
                       <div class="mb-3">
                           <label class="form-label">Job Process</label>
                           <?= form_dropdown('process_id',$process,set_value('process_id',$process_data->job_process_id),'class="form-control"') ?>
                           <?= form_error('process_id', '<div class="error">', '</div>'); ?>
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
<script src="https://transloadit.edgly.net/releases/uppy/v1.6.0/uppy.min.js"> </script>
<script src="<?= base_url('back-end') ?>/js/aiz-core.js"></script>
