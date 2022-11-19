<!doctype html>
<html lang="en">
   <head>
      <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title><?= @$this->data['config']['web_meta_title'] ?> | <?= @$this->data['config']['web_appname'] ?> </title>
      <meta name="csrf-token" content="">
      <meta name="app-url" content="<?= base_url() ?>">
      <meta name="file-base-url" content="<?= base_url() ?>">
      <meta content="<?= @$this->data['config']['web_description'] ?>" name="description" />
      <link rel="shortcut icon" href="<?= image_assets(@$this->data['config']['web_app_icon']) ?>">
      <link href="<?=base_url('back-end/')?>/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
      <link href="<?=base_url('back-end/')?>/css/icons.min.css" rel="stylesheet" type="text/css" />
      <link href="<?=base_url('back-end/')?>/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
   </head>
   <body>
      <div class="account-pages my-5 pt-sm-5">
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-md-8 col-lg-6 col-xl-5">
                  <div class="card overflow-hidden">
                     <div class="bg-primary bg-soft">
                        <div class="row">
                           <div class="col-7">
                              <div class="text-primary p-4">
                                 <h5 class="text-primary">Welcome Back !</h5>
                                 <p>Sign in to continue to Skote.</p>
                              </div>
                           </div>
                           <div class="col-5 align-self-end">
                              <img src="<?=base_url('back-end/')?>/images/profile-img.png" alt="" class="img-fluid">
                           </div>
                        </div>
                     </div>
                     <div class="card-body pt-0">
                        <div class="auth-logo">
                           <a href="<?= base_url() ?>" class="auth-logo-light">
                              <div class="avatar-md profile-user-wid mb-4">
                                 <span class="avatar-title rounded-circle bg-light">
                                 <img src="<?=base_url('back-end/')?>/images/logo-light.svg" alt="" class="rounded-circle" height="34">
                                 </span>
                              </div>
                           </a>
                           <a href="<?= base_url() ?>" class="auth-logo-dark">
                              <div class="avatar-md profile-user-wid mb-4">
                                 <span class="avatar-title rounded-circle bg-light">
                                 <img src="<?=base_url('back-end/')?>/images/logo.svg" alt="" class="rounded-circle" height="34">
                                 </span>
                              </div>
                           </a>
                        </div>
                        <div class="p-2">
                            <?= form_open('','class="form-horizontal"') ?>
                              <div class="mb-3">
                                 <label for="username" class="form-label">Username</label>
                                 <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" value="<?= set_value('username'); ?>">
                                 <?php echo form_error('username', '<div class="error">', '</div>'); ?>
                              </div>
                              <div class="mb-3">
                                 <label class="form-label">Password</label>
                                 <div class="input-group auth-pass-inputgroup">
                                    <input type="password" class="form-control" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon" name="password" value="<?= set_value('password'); ?>" >
                                    <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                 </div>
                                 <?php echo form_error('password', '<div class="error">', '</div>'); ?>
                              </div>
                              <div class="form-check">
                                 <input class="form-check-input" type="checkbox" id="remember-check">
                                 <label class="form-check-label" for="remember-check">
                                 Remember me
                                 </label>
                              </div>
                              <div class="mt-3 d-grid">
                                 <button class="btn btn-primary waves-effect waves-light" type="submit">Log In</button>
                              </div>
                              <div class="mt-4 text-center">
                                 <h5 class="font-size-14 mb-3">Sign in with</h5>
                                 <ul class="list-inline">
                                    <li class="list-inline-item">
                                       <a href="javascript::void()" class="social-list-item bg-primary text-white border-primary">
                                       <i class="mdi mdi-facebook"></i>
                                       </a>
                                    </li>
                                    <li class="list-inline-item">
                                       <a href="javascript::void()" class="social-list-item bg-info text-white border-info">
                                       <i class="mdi mdi-twitter"></i>
                                       </a>
                                    </li>
                                    <li class="list-inline-item">
                                       <a href="javascript::void()" class="social-list-item bg-danger text-white border-danger">
                                       <i class="mdi mdi-google"></i>
                                       </a>
                                    </li>
                                 </ul>
                              </div>
                              <div class="mt-4 text-center">
                                 <a href="auth-recoverpw.html" class="text-muted"><i class="mdi mdi-lock me-1"></i> Forgot your password?</a>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
                  <div class="mt-5 text-center">
                     <div>
                        <p>Don't have an account ? <a href="" class="fw-medium text-primary"> Signup now </a> </p>
                        <p>
                           © <script>
                              document.write(new Date().getFullYear())
                           </script> Skote. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand
                        </p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script src="<?=base_url('back-end/')?>/libs/jquery/jquery.min.js"></script>
      <script src="<?=base_url('back-end/')?>/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="<?=base_url('back-end/')?>/libs/metismenu/metisMenu.min.js"></script>
      <script src="<?=base_url('back-end/')?>/libs/simplebar/simplebar.min.js"></script>
      <script src="<?=base_url('back-end/')?>/libs/node-waves/waves.min.js"></script>
      <script src="<?=base_url('back-end/')?>/js/app.js"></script>
   </body>
</html>