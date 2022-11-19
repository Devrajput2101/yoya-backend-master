<?php include(__DIR__.'/../common/_header.php'); ?>
<?php include(__DIR__.'/../common/_sidebar.php'); ?>
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <?php include(__DIR__.'/../common/_message.php'); ?>
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Out of Station fare</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active">Out of Station fare Update</li>
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
                        <h4 class="card-title">Out of Station fare Update</h4>
                     </div>
                     <div class="col-md-4 text-right">
                        <div class="card-footer bg-transparent" style="margin-top: -15px;">
                           <div class="text-center">
                              <a href="<?= site_url('admin/documentrequire') ?>" class="btn btn-outline-dark btn-sm align-middle me-2" title="Pages" style="float: right;">
                              <i class="bx bx-arrow-back"></i>Out of Station fare
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?= form_open() ?>
                  <div class="row mb-2 mt-2">
                     <div class="col-md-6">
                        <label>Select Document Country</label>
                        <div class="input-group" id="country">
                           <?= form_dropdown('country_id',$country,set_value('country_id',$documents->document_country_id),'class="form-control" id="country_id"') ?>
                        </div>
                        <?= form_error('country_id', '<div class="error">', '</div>'); ?>
                     </div>
                     <div class="col-md-6">
                        <label>Document Label</label>
                        <div class="input-group" id="document_label">
                           <input type="text" class="form-control" placeholder="Document Label" name="document_label" value="<?= set_value('document_label',$documents->document_label) ?>">
                        </div>
                        <?= form_error('document_label', '<div class="error">', '</div>'); ?>
                     </div>
                  </div>

                  <div class="row mb-2 mt-2">
                     <div class="col-md-6">
                        <label>Document Placehoder</label>
                        <div class="input-group" id="document_placeholder">
                           <input type="text" class="form-control" placeholder="Document Placehoder" name="document_placeholder" value="<?= set_value('document_placeholder',$documents->document_placeholder) ?>">
                        </div>
                        <?= form_error('document_placeholder', '<div class="error">', '</div>'); ?>
                     </div>
                     <div class="col-md-6">
                        <label>Document Description</label>
                        <div class="input-group" id="document_description">
                           <input type="text" class="form-control" placeholder="Document Description" name="document_description" value="<?= set_value('document_description',$documents->document_description) ?>">
                        </div>
                        <?= form_error('document_description', '<div class="error">', '</div>'); ?>
                     </div>
                  </div>

                  <div class="row mb-2 mt-2">
                     <div class="col-md-6">
                        <label>Document Minimum Character</label>
                        <div class="input-group" id="document_minimum_char">
                           <input type="text" class="form-control" placeholder="Document Minimum" name="document_minimum_char" value="<?= set_value('document_minimum_char',$documents->document_minimum_char) ?>">
                        </div>
                        <?= form_error('document_minimum_char', '<div class="error">', '</div>'); ?>
                     </div>
                     <div class="col-md-6">
                        <label>Document Maximum Character</label>
                        <div class="input-group" id="document_maximum_char">
                           <input type="text" class="form-control" placeholder="Document Maximum" name="document_maximum_char" value="<?= set_value('document_maximum_char',$documents->document_maximum_char) ?>">
                        </div>
                        <?= form_error('document_maximum_char', '<div class="error">', '</div>'); ?>
                     </div>
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
<?php include(__DIR__.'/../common/_get_dependent_location.php'); ?>