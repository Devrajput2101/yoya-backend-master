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
                  <i class= "bx bx-map d-block check-nav-icon mt-4 mb-2"></i>
                  <p class="fw-bold mb-4">Google Map setup</p>
               </a>
            </div>
         </div>
         <div class="col-xl-10 col-sm-9">
             <?php include(__DIR__.'/../../common/_message.php'); ?>
            <div class="card">
               <div class="card-body">
                  <div class="tab-content" id="v-pills-tabContent">
                     <div class="tab-pane fade show active" id="v-pills-shipping" role="tabpanel" aria-labelledby="v-pills-shipping-tab">
                        <div>
                           <h4 class="card-title">Google Map</h4>
                           <p class="card-title-desc">Fill all information below</p>
                           <?= form_open("admin/setting/update") ?>
                           <div class="row mb-2 mt-2">
                              <div class="col-md-12">
                                 <label>Google Api Key</label>
                                 <div class="input-group" id="google_key">
                                    <input type="text" class="form-control" placeholder="Google Key" name="google_key" value="<?= set_value('google_key',@$this->data['config']['google_key']) ?>">
                                    <span class="input-group-text">Api Key</span>
                                 </div>
                                 <?= form_error('google_key', '<div class="error">', '</div>'); ?>
                              </div>
                           </div>
                           <div class="row mb-2 mt-2">
                              <div class="col-md-12">
                                 <label>Fcm server Key</label>
                                 <div class="input-group" id="google_fcm_key">
                                    <input type="text" class="form-control" placeholder="Fcm Key" name="google_fcm_key" value="<?= set_value('google_fcm_key',@$this->data['config']['google_fcm_key']) ?>">
                                    <span class="input-group-text">Fcm Key</span>
                                 </div>
                                 <?= form_error('google_fcm_key', '<div class="error">', '</div>'); ?>
                              </div>
                           </div>
                           <div class="float-end mt-3">
                                <button type="submit" class="btn btn-primary w-md">Submit</button>
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