<?php include(__DIR__.'/../common/_header.php'); ?>
<?php include(__DIR__.'/../common/_sidebar.php'); ?>
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <?php include(__DIR__.'/../common/_message.php'); ?>
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Countrys</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active">Countrys Create</li>
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
                        <h4 class="card-title">Countrys Create</h4>
                     </div>
                     <div class="col-md-4 text-right">
                        <div class="card-footer bg-transparent" style="margin-top: -15px;">
                           <div class="text-center">
                              <a href="<?= site_url('admin/countrys') ?>" class="btn btn-outline-dark btn-sm align-middle me-2" title="Citys" style="float: right;">
                              <i class="bx bx-arrow-back"></i> countrys
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
                   <?= form_open() ?>
                     <div class="row mb-2 mt-2">
                        <div class="col-md-6">
                           <label>Country Name</label>
                           <div class="input-group" id="Country">
                              <input type="text" class="form-control" placeholder="Country name" name="country_name" value="<?= set_value('country_name') ?>">
                              <span class="input-group-text"><i class="bx bx-user"></i></span>
                           </div>
                           <?= form_error('country_name','<div class="error">','</div>'); ?>
                        </div>
                        <div class="col-md-6">
                           <label>Country Code</label>
                           <div class="input-group">
                              <input type="text" class="form-control" placeholder="Country code" name="country_code" value="<?= set_value('country_code') ?>">
                              <span class="input-group-text"><i class="bx bx-user"></i></span>
                           </div>
                           <?= form_error('country_code','<div class="error">','</div>'); ?>
                        </div>
                     </div>
                     <div class="row mb-2 mt-2">
                        <div class="col-md-6">
                           <label>Country ISO(code)</label>
                           <div class="input-group" id="Country">
                              <input type="text" class="form-control" placeholder="Country iso code" name="country_iso_code" value="<?= set_value('country_iso_code') ?>">
                              <span class="input-group-text"><i class="bx bx-user"></i></span>
                           </div>
                           <?= form_error('country_iso_code','<div class="error">','</div>'); ?>
                        </div>
                        <div class="col-md-6">
                            <label>Country icon</label>
                            <div class="input-group" id="sale">
                                  <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">Browse</div>
                                    </div>
                                    <div class="form-control file-amount">Choose icon</div>
                                    <input type="hidden" name="country_icon" class="selected-files" value="<?= set_value('country_icon') ?>">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                            </div>
                       </div>
                     </div>
                     <div class="row mb-2 mt-2">
                        <div class="col-md-6">
                           <label>Currency symbols</label>
                           <div class="input-group" id="Country">
                              <input type="text" class="form-control" placeholder="Country iso code" name="currency_symbols" value="<?= set_value('currency_symbols') ?>">
                              <span class="input-group-text"><i class="bx bx-user"></i></span>
                           </div>
                           <?= form_error('currency_symbols','<div class="error">','</div>'); ?>
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