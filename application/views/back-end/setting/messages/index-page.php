<?php include(__DIR__.'/../../common/_header.php'); ?>
<?php include(__DIR__.'/../../common/_sidebar.php'); ?>
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Message Setting</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active">Message Setting</li>
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
                     <p class="fw-bold mb-4">Geez Sms</p>
                  </a>
                  <a class="nav-link" id="v-pills-msg91-tabs" data-bs-toggle="pill" href="#v-pills-msg91" role="tab" aria-controls="v-pills-msg91">
                     <i class= "bx bx-photo-album d-block check-nav-icon mt-4 mb-2"></i>
                     <p class="fw-bold mb-4">MSG91 Sms</p>
                  </a>
               </div>
            </div>
            <div class="col-xl-10 col-sm-9">
               <div class="card">
                  <div class="card-body">
                     <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-shipping" role="tabpanel" aria-labelledby="v-pills-shipping-tab">
                           <div>
                              <h4 class="card-title">Geez SMS Api information</h4>
                              <p class="card-title-desc">Fill all information below</p>
                              <?= form_open('admin/setting/update') ?>
                              <div class="row mb-2 mt-2">
                                 <div class="col-md-12">
                                    <label>GeeZ API Token</label>
                                    <div class="input-group" id="geez_api_token">
                                       <input type="text" class="form-control" placeholder="Token" name="geez_api_token" value="<?= set_value('geez_api_token',@$this->data['config']['geez_api_token']) ?>">
                                       <span class="input-group-text">Token</span>
                                    </div>
                                    <?= form_error('geez_api_token', '<div class="error">', '</div>'); ?>
                                 </div>
                              </div>
                              <div class="row mb-2 mt-2">
                                 <div class="col-md-6">
                                    <label>Active Geez</label>
                                    <p class="card-title-desc">If you want to active geez sms service </p>
                                    <div class="form-group" id="web_appname">
                                        <input type="hidden" class="checkedSwitch"  value="<?= @$this->data['config']['geez_sms_is_active'] ?>" name="geez_sms_is_active">
                                        <input type="checkbox" class="page-status switch" id="switchgeez" switch="success" <?php if(@$this->data['config']['geez_sms_is_active'] == 1){ echo "checked"; } ?>>
                                       <label for="switchgeez" data-on-label="on" data-off-label="off"></label>
                                    </div>
                                    <?= form_error('geez_sms_is_active', '<div class="error">', '</div>'); ?>
                                 </div>
                              </div>
                              <div class="float-end mt-3">
                                 <button type="submit" class="btn btn-primary w-md">Submit</button>
                              </div>
                              <?= form_close() ?>
                           </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-msg91" role="tabpanel" aria-labelledby="v-pills-msg91-tab">
                           <div>
                              <h4 class="card-title">MSG 91 SMS Api information</h4>
                              <p class="card-title-desc">Fill all information below</p>
                              <?= form_open('admin/setting/update') ?>
                              <div class="row mb-2 mt-2">
                                 <div class="col-md-6">
                                    <label>MSG 91 API Token</label>
                                    <div class="input-group" id="msg91_auth_key">
                                       <input type="text" class="form-control" placeholder="Token" name="msg91_auth_key" value="<?= set_value('msg91_auth_key',@$this->data['config']['msg91_auth_key']) ?>">
                                       <span class="input-group-text">Token</span>
                                    </div>
                                    <?= form_error('msg91_auth_key', '<div class="error">', '</div>'); ?>
                                 </div>
                                 <div class="col-md-6">
                                    <label>MSG 91 Sender ID</label>
                                    <div class="input-group" id="msg91_sender_id">
                                       <input type="text" class="form-control" placeholder="Token" name="msg91_sender_id" value="<?= set_value('msg91_sender_id',@$this->data['config']['msg91_sender_id']) ?>">
                                       <span class="input-group-text">SENDER</span>
                                    </div>
                                    <?= form_error('msg91_sender_id', '<div class="error">', '</div>'); ?>
                                 </div>
                              </div>
                              <div class="row mb-2 mt-2">
                                 <div class="col-md-6">
                                    <label>Active MSG91</label>
                                    <p class="card-title-desc">If you want to active MSG91 sms service </p>
                                    <div class="form-group" id="web_appname">
                                       <input type="hidden" class="checkedSwitch"  value="<?= @$this->data['config']['msg91_sms_is_active'] ?>" name="msg91_sms_is_active">
                                       <input type="checkbox" class="page-status switch" id="switchmsg91" switch="success" <?php if(@$this->data['config']['msg91_sms_is_active'] == 1){ echo "checked"; } ?>>
                                       <label for="switchmsg91" data-on-label="on" data-off-label="off"></label>
                                    </div>
                                    <?= form_error('msg91_sms_is_active', '<div class="error">', '</div>'); ?>
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
</div>
<?php include(__DIR__.'/../../common/_footer.php'); ?>
<script>
    $('.switch').change(function() {
        if($(this).is(":checked")) {
            $(".checkedSwitch").val(1);
        }else{
            $(".checkedSwitch").val(0);
        }    
    });
</script>