<?php include(__DIR__.'/../common/_header.php'); ?>
<?php include(__DIR__.'/../common/_sidebar.php'); ?>
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <?php include(__DIR__.'/../common/_message.php'); ?>
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Package fare update</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active">Package fare update</li>
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
                        <h4 class="card-title">Package fare update</h4>
                     </div>
                     <div class="col-md-4 text-right">
                        <div class="card-footer bg-transparent" style="margin-top: -15px;">
                           <div class="text-center">
                              <a href="<?= site_url('admin/packagefare') ?>" class="btn btn-outline-dark btn-sm align-middle me-2" title="Pages" style="float: right;">
                              <i class="bx bx-arrow-back"></i>Package fare
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?= form_open() ?>
                  <div class="row mb-2 mt-2">
                     <div class="col-md-6">
                        <label>Select Country</label>
                        <div class="input-group" id="country">
                           <?= form_dropdown('country_id',$country,set_value('country_id',$single->fare_country_id),'class="form-control" id="country_id"') ?>
                        </div>
                        <?= form_error('country_id', '<div class="error">', '</div>'); ?>
                     </div>
                     <div class="col-md-6">
                        <label>Select State</label>
                        <div class="input-group" id="state">
                           <?= form_dropdown('state_id',$states,set_value('state_id',$single->fare_state_id),'class="form-control" id="state_id" placeholder="Select State"') ?>
                        </div>
                        <?= form_error('state_id', '<div class="error">', '</div>'); ?>
                     </div>
                  </div>
                  <div class="row mb-2 mt-2">
                     <div class="col-md-6">
                        <label>Select City</label>
                        <div class="input-group" id="city_id">
                           <?= form_dropdown('city_id',$cities,set_value('city_id',$single->fare_city_id),'class="form-control" id="city_id" placeholder="Select city"') ?>
                        </div>
                        <?= form_error('city_id', '<div class="error">', '</div>'); ?>
                     </div>
                     <div class="col-md-6">
                        <label>Select Vehicle</label>
                        <div class="input-group" id="vehicle_id">
                           <?= form_dropdown('vehicle_id',$vehicles,set_value('vehicle_id',$single->fare_vehicle_id),'class="form-control"') ?>
                        </div>
                        <?= form_error('vehicle_id', '<div class="error">', '</div>'); ?>
                     </div>
                  </div>
                  <div class="row mb-2 mt-2">
                     <div class="col-md-6">
                        <label>Base Price</label>
                        <div class="input-group" id="fare_base_price">
                           <input type="text" class="form-control" placeholder="base price" name="fare_base_price" value="<?= set_value('fare_base_price',$single->fare_base_price) ?>">
                        </div>
                        <?= form_error('fare_base_price', '<div class="error">', '</div>'); ?>
                     </div>
                     <div class="col-md-6">
                        <label>General Price(Per Km.)</label>
                        <div class="input-group" id="fare_kilometre_price">
                           <input type="text" class="form-control" placeholder="general price" name="fare_kilometre_price" value="<?= set_value('fare_kilometre_price',$single->fare_base_price) ?>">
                        </div>
                        <?= form_error('fare_kilometre_price', '<div class="error">', '</div>'); ?>
                     </div>
                  </div>
                  <div class="row mb-2 mt-2">
                     <div class="col-md-6">
                        <label>Km.(From)</label>
                        <div class="input-group" id="fare_kilometre_from">
                           <input type="text" class="form-control"  name="fare_kilometre_from" value="<?= set_value('fare_kilometre_from',$single->fare_kilometre_from) ?>">
                        </div>
                        <?= form_error('fare_kilometre_from', '<div class="error">', '</div>'); ?>
                     </div>
                     <div class="col-md-6">
                        <label>Km.(To)</label>
                        <div class="input-group" id="fare_kilometre_to">
                           <input type="text" class="form-control" name="fare_kilometre_to" value="<?= set_value('fare_kilometre_to',$single->fare_kilometre_to) ?>">
                        </div>
                        <?= form_error('fare_kilometre_to', '<div class="error">', '</div>'); ?>
                     </div>
                  </div>
                  <div class="row mb-2 mt-2">
                     <div class="col-md-6">
                        <label><?= $config['web_appname'] ?> Service charges</label>
                        <div class="input-group" id="fare_commission">
                           <input type="text" class="form-control" placeholder="<?= $config['web_appname'] ?> Service charges" name="fare_commission" value="<?= set_value('fare_commission',$single->fare_commission) ?>">
                        </div>
                        <small><span class="text-danger">Note:</span> When user complete ride or booking then <?= $config['web_appname'] ?> service charges applicable from driver collected amount</small>
                        <?= form_error('fare_commission', '<div class="error">', '</div>'); ?>
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
<?php include(__DIR__.'/../common/_footer.php'); ?>
<?php include(__DIR__.'/../common/_get_dependent_location.php'); ?>