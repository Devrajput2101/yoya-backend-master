<?php include(__DIR__.'/../common/_header.php'); ?>
<?php include(__DIR__.'/../common/_sidebar.php'); ?>
<!-- page wise css -->
<script src="<?= base_url('back-end') ?>/ckeditor/ckeditor.js" type="text/javascript"></script>
<link href="<?= base_url('back-end') ?>/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?= base_url('back-end') ?>/libs/%40chenfengyuan/datepicker/datepicker.min.css">
<!-- page wise css -->
<div class="page-content">
<div class="container-fluid">
   <div class="row">
      <?php include(__DIR__.'/../common/_message.php'); ?>
      <div class="col-12">
         <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Discount</h4>
            <div class="page-title-right">
               <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                  <li class="breadcrumb-item active">Discount Update</li>
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
                     <h4 class="card-title">Discount Update</h4>
                  </div>
                  <div class="col-md-4 text-right">
                     <div class="card-footer bg-transparent" style="margin-top: -15px;">
                        <div class="text-center">
                           <a href="<?= site_url('admin/discount') ?>" class="btn btn-outline-dark btn-sm align-middle me-2" title="Pages" style="float: right;">
                           <i class="bx bx-arrow-back"></i> Discount
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
               <?= form_open() ?>
               <div class="row mb-2 mt-2">
                  <div class="col-md-6">
                     <label>Select Country</label>
                     <div class="input-group" id="country_id">
                        <?= form_dropdown('country_id',$country,set_value('country_id',$discounts->discount_country_id),'class="form-control" id="country_id"') ?>
                     </div>
                     <?= form_error('country_id', '<div class="error">', '</div>'); ?>
                  </div>
                  <div class="col-md-6">
                     <label>Select State</label>
                     <div class="input-group" id="state">
                        <?= form_dropdown('state_id','',set_value('state_id',$discounts->discount_state_id),'class="form-control" id="state_id" placeholder="Select State"') ?>
                     </div>
                     <?= form_error('state_id', '<div class="error">', '</div>'); ?>
                  </div>
               </div>
               <div class="row mb-2 mt-2">
                  <div class="col-md-6">
                     <label>Select City</label>
                     <div class="input-group" id="city">
                        <?= form_dropdown('city_id','',set_value('city_id',$discounts->discount_city_id),'class="form-control" id="city_id" placeholder="Select city" ') ?>
                     </div>
                     <?= form_error('city_id', '<div class="error">', '</div>'); ?>
                  </div>
                   <div class="col-md-6">
                     <label>Discount Code</label>
                     <div class="input-group" id="discount_code">
                        <input type="text" class="form-control" placeholder="discount code" name="discount_code" value="<?= set_value('discount_code',$discounts->discount_code) ?>">
                     </div>
                     <?= form_error('discount_code', '<div class="error">', '</div>'); ?>
                  </div>
               </div>
               <div class="row mb-2 mt-2">
                  <div class="col-md-6">
                     <label>Start date</label>
                     <div class="input-group" id="discount_start_date">
                        <input type="text" class="form-control" placeholder="start date" name="discount_start_date" value="<?= set_value('discount_start_date',$discounts->discount_start_date) ?>">
                     </div>
                     <?= form_error('discount_start_date', '<div class="error">', '</div>'); ?>
                  </div>
                  <div class="col-md-6">
                     <label>End Date </label>
                     <div class="input-group" id="discount_end_date">
                        <input type="text" class="form-control" placeholder="end date" name="discount_end_date" value="<?= set_value('discount_end_date',$discounts->discount_end_date) ?>">
                     </div>
                     <?= form_error('discount_end_date', '<div class="error">', '</div>'); ?>
                  </div>
                  </div>
                   <div class="row mb-2 mt-2">
                  <div class="col-md-6">
                     <label>Minimum  Amount</label>
                     <div class="input-group" id="discount_minimum_amount">
                        <input type="text" class="form-control" placeholder="Minimum Amount" name="discount_minimum_amount" value="<?= set_value('discount_minimum_amount',$discounts->discount_minimum_amount) ?>">
                     </div>
                     <?= form_error('discount_minimum_amount', '<div class="error">', '</div>'); ?>
                  </div>
                  <div class="col-md-6">
                     <label>User At Time Use</label>
                     <div class="input-group" id="discount_user_uses_at_time">
                        <input type="number" class="form-control" placeholder="User Uses" name="discount_user_uses_at_time" value="<?= set_value('discount_user_uses_at_time',$discounts->discount_user_uses_at_time) ?>">
                     </div>
                     <?= form_error('discount_user_uses_at_time', '<div class="error">', '</div>'); ?>
                  </div>
                  </div>
                  <div class="col-md-12">
                     <label>Discount Description</label>
                     <div class="input-group" id="fare_base_price">
                       <textarea  class="form-control" placeholder="dicount description" name="discount_description" value=""> <?= set_value('discount_description',$discounts->discount_description) ?></textarea>
                     </div>
                     <?= form_error('discount_description', '<div class="error">', '</div>'); ?>
                  </div>
                  <div class="row mt-4">
                     <div class="col-md-6">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-save font-size-16 align-middle me-2"></i>update
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
<script> CKEDITOR.replace( 'page_description' ); </script>
<script src="<?= base_url('back-end') ?>/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<!-- form advanced init -->
<script src="<?= base_url('back-end') ?>/js/pages/form-advanced.init.js"></script>
<script src="<?= base_url('back-end') ?>/libs/simplebar/simplebar.min.js"></script>
<script src="https://transloadit.edgly.net/releases/uppy/v1.6.0/uppy.min.js"> </script>
<script src="<?= base_url('back-end') ?>/js/aiz-core.js"></script>


<script>
// get state 
$(document).on('change', 'select#country_id', function (e) {
    e.preventDefault();
    var CountryID = $(this).val();
    getstatelist(CountryID);
});
function getstatelist(CountryID) {
    $.ajax({
        url:  "<?= base_url("admin/vehiclefare/getState") ?>",
        type: 'POST',
        data: {CountryID: CountryID},
        dataType: 'json',
        beforeSend: function (){
            $('select#state_id').find("option:eq(0)").html("Please wait..");
        },
        success: function (json){
            var options = '';
            options +='<option value="">Select State</option>';
            for (var i = 0; i < json.length; i++) {
                options += '<option value="' + json[i].state_id + '">' + json[i].state_name + '</option>';
            }
            $("select#state_id").html(options);
 
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}
</script>

<script>
// get city
$(document).on('change', 'select#state_id', function (e) {
    e.preventDefault();
    var StateID = $(this).val();
    getcitylist(StateID);
});
function getcitylist(StateID) {
    $.ajax({
        url:  "<?= base_url("admin/vehiclefare/getCity") ?>",
        type: 'POST',
        data: {StateID: StateID},
        dataType: 'json',
        beforeSend: function (){
            $('select#city_id').find("option:eq(0)").html("Please wait..");
        },
        success: function (json){
            var options = '';
            options +='<option value="">Select City</option>';
            for (var i = 0; i < json.length; i++) {
                options += '<option value="' + json[i].city_id + '">' + json[i].city_name + '</option>';
            }
            $("select#city_id").html(options);
 
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}
</script>











