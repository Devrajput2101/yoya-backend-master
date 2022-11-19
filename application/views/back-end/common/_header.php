<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <title><?= @$this->data['config']['web_meta_title'] ?> | <?= @$this->data['config']['web_appname'] ?> </title>
      <meta name="csrf-token" content="">
      <meta name="app-url" content="<?= base_url() ?>">
      <meta name="file-base-url" content="<?= base_url() ?>">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta content="<?= @$this->data['config']['web_description'] ?>" name="description" />
      <link rel="shortcut icon" href="<?= image_assets(@$this->data['config']['web_app_icon']) ?>">
      <link href="<?= base_url('back-end') ?>/css/bootstrap.min.css?v=<?= time() ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
      <link href="<?= base_url('back-end') ?>/css/icons.min.css?v=<?= time() ?>" rel="stylesheet" type="text/css" />
      <link href="<?= base_url('back-end') ?>/css/app.min.css?v=<?= time() ?>" id="app-style" rel="stylesheet" type="text/css" />
      <style>
        .breadcrumb-item+.breadcrumb-item::before {
            float: left;
            padding-right: 0.5rem;
            color: #74788d;
            content: "/" !important;
        }
      </style>
   </head>
   <script>
        var AIZ = AIZ || {};
        AIZ.local = {
            nothing_selected: 'Nothing selected',
            nothing_found: 'Nothing found',
            choose_file: 'Choose file',
            file_selected: 'File selected',
            files_selected: 'Files selected',
            add_more_files: 'Add more files',
            adding_more_files: 'Adding more files',
            drop_files_here_paste_or: 'Drop files here, paste or',
            browse: 'Browse',
            upload_complete: 'Upload complete',
            upload_paused: 'Upload paused',
            resume_upload: 'Resume upload',
            pause_upload: 'Pause upload',
            retry_upload: 'Retry upload',
            cancel_upload: 'Cancel upload',
            uploading: 'Uploading',
            processing: 'Processing',
            complete: 'Complete',
            file: 'File',
            files: 'Files',
        }
   </script>
   <body data-sidebar="dark" data-layout-scrollable="true">
      <!-- Begin page -->
      <div id="layout-wrapper">
         <header id="page-topbar">
            <div class="navbar-header">
               <div class="d-flex">
                  <!-- LOGO -->
                  <div class="navbar-brand-box">
                     <a href="<?= base_url() ?>" class="logo logo-dark">
                     <span class="logo-sm">
                     <img src="<?= image_assets(@$this->data['config']['web_app_logo']) ?>" alt="" height="22">
                     </span>
                     <span class="logo-lg">
                     <img src="<?= image_assets(@$this->data['config']['web_app_logo']) ?>" alt="" height="17">
                     </span>
                     </a>
                     <a href="<?= base_url() ?>" class="logo logo-light">
                     <span class="logo-sm">
                     <img src="<?= image_assets(@$this->data['config']['web_app_logo']) ?>" alt="" height="22">
                     </span>
                     <span class="logo-lg">
                     <img src="<?= image_assets(@$this->data['config']['web_app_logo']) ?>" alt="" height="19">
                     </span>
                     </a>
                  </div>
                  <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                  <i class="fa fa-fw fa-bars"></i>
                  </button>
               </div>
               <div class="d-flex">
                  <div class="dropdown d-inline-block d-lg-none ms-2">
                     <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <i class="mdi mdi-magnify"></i>
                     </button>
                     <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
                        <form class="p-3">
                           <div class="form-group m-0">
                              <div class="input-group">
                                 <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                 <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
                  <div class="dropdown d-inline-block">
                     <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <img class="rounded-circle header-profile-user" src="<?= base_url('back-end') ?>/images/users/avatar-1.jpg" alt="Header Avatar">
                     <span class="d-none d-xl-inline-block ms-1" key="t-henry"><?= $this->session->userdata('user_name'); ?></span>
                     <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                     </button>
                     <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <a class="dropdown-item" href="<?= site_url('admin/user/profile') ?>"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a>
                        <a class="dropdown-item text-danger" href="auth-login.html"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
                     </div>
                  </div>
               </div>
            </div>
         </header>
         <!-- ========== Left Sidebar Start ========== -->