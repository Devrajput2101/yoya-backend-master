<?php include(__DIR__.'/../common/_header.php'); ?>
<?php include(__DIR__.'/../common/_sidebar.php'); ?>
<!-- page wise css -->
<link href="<?= base_url('back-end') ?>/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?= base_url('back-end') ?>/libs/%40chenfengyuan/datepicker/datepicker.min.css">
<!-- page wise css -->
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <?php include(__DIR__.'/../common/_message.php'); ?>
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Customers</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active">Customers Create</li>
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
                        <h4 class="card-title">Customers Create</h4>
                     </div>
                     <div class="col-md-4 text-right">
                        <div class="card-footer bg-transparent" style="margin-top: -15px;">
                           <div class="text-center">
                              <a href="<?= site_url('admin/customer/create') ?>" class="btn btn-outline-dark btn-sm align-middle me-2" title="New Customers" style="float: right;">
                              <i class="bx bx-arrow-back"></i> New Customers
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
                   <?= form_open() ?>
                     <div class="row mb-2 mt-2">
                        <div class="col-md-6">
                           <label>Name</label>
                           <div class="input-group" id="Name">
                              <input type="text" class="form-control" placeholder="Enter name" name="user_name" value="<?= set_value('user_name') ?>">
                              <span class="input-group-text"><i class="bx bx-user"></i></span>
                           </div>
                           <?= form_error('user_name', '<div class="error">', '</div>'); ?>
                        </div>
                        <div class="col-md-6">
                           <label>Email</label>
                           <div class="input-group" id="Email">
                              <input type="email" class="form-control" placeholder="Enter email" name="user_email" value="<?= set_value('user_email') ?>">
                              <span class="input-group-text"><i class="bx bx-voicemail"></i></span>
                           </div>
                           <?= form_error('user_email', '<div class="error">', '</div>'); ?>
                        </div>
                     </div>
                     <div class="row mb-2 mt-2">
                        <div class="col-md-6">
                           <label>Phone</label>
                           <div class="input-group" id="Phone">
                              <input type="text" class="form-control" placeholder="Enter phone" name="user_phone" value="<?= set_value('user_phone') ?>">
                              <span class="input-group-text"><i class="bx bx-phone"></i></span>
                           </div>
                           <?= form_error('user_phone', '<div class="error">', '</div>'); ?>
                        </div>
                        <div class="col-md-6">
                           <label>Password</label>
                           <div class="input-group" id="Password">
                              <input type="password" class="form-control" placeholder="Enter password" name="user_password">
                              <span class="input-group-text"><i class="bx bx-code-alt"></i></span>
                           </div>
                           <?= form_error('user_password', '<div class="error">', '</div>'); ?>
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
<script src="<?= base_url('back-end') ?>/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<!-- form advanced init -->
<script src="<?= base_url('back-end') ?>/js/pages/form-advanced.init.js"></script>