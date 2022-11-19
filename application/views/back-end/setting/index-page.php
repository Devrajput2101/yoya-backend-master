<?php include(__DIR__.'/../common/_header.php'); ?>
<?php include(__DIR__.'/../common/_sidebar.php'); ?>
<!--page wise css-->
<link href="<?= base_url('back-end') ?>/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<!--page wise css-->
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Setting</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active">Setting</li>
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
                  <a class="nav-link" id="v-pills-confir-tab" data-bs-toggle="pill" href="#v-pills-confir" role="tab" aria-controls="v-pills-confir" aria-selected="false">
                     <i class= "bx bx-badge-check d-block check-nav-icon mt-4 mb-2"></i>
                     <p class="fw-bold mb-4">Seo Content</p>
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
                              <?= form_open('admin/setting/update') ?>
                              <div class="row mb-2 mt-2">
                                 <div class="col-md-12">
                                    <label>Application Name</label>
                                    <div class="input-group" id="web_appname">
                                       <input type="text" class="form-control" placeholder="App name" name="web_appname" value="<?= set_value('web_appname',@$this->data['config']['web_appname']) ?>">
                                       <span class="input-group-text"><i class="bx bx-application"></i></span>
                                    </div>
                                    <?= form_error('web_appname', '<div class="error">', '</div>'); ?>
                                 </div>
                              </div>
                              <div class="row mb-2 mt-2">
                                 <div class="col-md-6">
                                    <label>Application logo</label>
                                    <div class="input-group" id="sale">
                                       <div class="input-group" data-toggle="aizuploader" data-type="image">
                                          <div class="input-group-prepend">
                                             <div class="input-group-text bg-soft-secondary font-weight-medium">Browse</div>
                                          </div>
                                          <div class="form-control file-amount">Choose File</div>
                                          <input type="hidden" name="web_app_logo" class="selected-files" value="<?= set_value('seo_image',@$this->data['config']['web_app_logo']) ?>">
                                       </div>
                                       <div class="file-preview box sm">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <label>Application icon</label>
                                    <div class="input-group" id="sale">
                                       <div class="input-group" data-toggle="aizuploader" data-type="image">
                                          <div class="input-group-prepend">
                                             <div class="input-group-text bg-soft-secondary font-weight-medium">Browse</div>
                                          </div>
                                          <div class="form-control file-amount">Choose File</div>
                                          <input type="hidden" name="web_app_icon" class="selected-files" value="<?= set_value('seo_image',@$this->data['config']['web_app_icon']) ?>">
                                       </div>
                                       <div class="file-preview box sm">
                                       </div>
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
                        <div class="tab-pane fade" id="v-pills-confir" role="tabpanel" aria-labelledby="v-pills-confir-tab">
                           <div class="card shadow-none border mb-0">
                              <div class="card-body">
                                 <h4 class="card-title mb-4">SEO Feilds</h4>
                                 <?= form_open('admin/setting/update') ?>
                                 <div class="col-md-12">
                                    <label>Title</label>
                                    <div class="input-group" id="title">
                                       <input type="text" class="form-control" placeholder="title" name="web_meta_title" value="<?= set_value('title',@$this->data['config']['web_meta_title']) ?>">
                                       <span class="input-group-text"><i class="bx bx-title"></i></span>
                                    </div>
                                    <?= form_error('title','<div class="error">', '</div>'); ?>
                                    <div class="mb-3">
                                       <label class="form-label">Meta description</label>
                                       <div>
                                          <textarea id="web_description" name="web_meta_description" placeholder="Description" required class="form-control" rows="3"><?= set_value('web_description',@$this->data['config']['web_description']) ?></textarea>
                                       </div>
                                    </div>
                                    <div class="row mt-4">
                                       <div class="col-md-6">
                                          <button type="submit" class="btn btn-primary waves-effect waves-light">
                                          <i class="bx bx-save font-size-16 align-middle me-2"></i>submit
                                          </button>
                                       </div>
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
   </div>
</div>
<?php include(__DIR__.'/../common/_footer.php'); ?>
<script src="<?= base_url('back-end') ?>/ckeditor/ckeditor.js" type="text/javascript"></script>
<script> CKEDITOR.replace( 'web_description' ); </script>