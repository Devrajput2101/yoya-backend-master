<?php include(__DIR__.'/../../common/_header.php'); ?>
<?php include(__DIR__.'/../../common/_sidebar.php'); ?>
<link href="<?= base_url('back-end') ?>/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<div class="page-content">
<div class="container-fluid">
   <div class="row">
      <div class="col-12">
         <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Application Setting</h4>
            <div class="page-title-right">
               <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                  <li class="breadcrumb-item active">Application Setting</li>
               </ol>
            </div>
         </div>
      </div>
   </div>
   <!-- end page title -->
   <div class="checkout-tabs">
      <div class="row">
         <div class="col-xl-2 col-sm-3">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
               <a class="nav-link active" id="v-pills-shipping-tab" data-bs-toggle="pill" href="#v-pills-shipping" role="tab" aria-controls="v-pills-shipping" aria-selected="true">
                  <i class= "bx bx-photo-album d-block check-nav-icon mt-4 mb-2"></i>
                  <p class="fw-bold mb-4">Website setup</p>
               </a>
            </div>
         </div>
         <div class="col-xl-10 col-sm-9">
            <div class="card">
               <div class="card-body">
                  <div class="tab-content" id="v-pills-tabContent">
                     <div class="tab-pane fade show active" id="v-pills-shipping" role="tabpanel" aria-labelledby="v-pills-shipping-tab">
                        <div>
                           <h4 class="card-title">Web information</h4>
                           <p class="card-title-desc">Fill all information below</p>
                           <?= form_open() ?>
                           <div class="row mb-2 mt-2">
                              <div class="col-md-6">
                                 <label>Application Name</label>
                                 <div class="input-group" id="appname">
                                    <input type="text" class="form-control" placeholder="App name" name="appname" value="<?= set_value('appname') ?>">
                                    <span class="input-group-text"><i class="bx bx-application"></i></span>
                                 </div>
                                 <?= form_error('appname', '<div class="error">', '</div>'); ?>
                              </div>
                              <div class="col-md-6">
                                 <label>Time zone</label>
                                 <div class="input-group" id="timezone">
                                    <input type="email" class="form-control" placeholder="timezone" name="timezone" value="<?= set_value('timezone') ?>">
                                    <span class="input-group-text"><i class="bx bx-time"></i></span>
                                 </div>
                                 <?= form_error('timezone', '<div class="error">', '</div>'); ?>
                              </div>
                           </div>
                           <div class="row mb-2 mt-2">
                              <div class="col-md-6">
                                 <label>Application Logo</label>
                                 <input class="form-control" type="file" id="formFile">
                              </div>
                              <div class="col-md-6">
                                 <label>Application Icon</label>
                                 <input class="form-control" type="file" id="formFile">
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
      </div>
   </div>
</div>
<?php include(__DIR__.'/../../common/_footer.php'); ?>