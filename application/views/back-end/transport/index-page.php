<?php include(__DIR__.'/../common/_header.php'); ?>
<?php include(__DIR__.'/../common/_sidebar.php'); ?>
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Vehicle Fare</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active">Vehicle Transport Fare</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <?php include(__DIR__.'/../common/_message.php'); ?>
         <div class="col-12">
            <div class="card">
               <div class="card-body">
                  <div class="row mb-4">
                     <div class="col-md-8">
                        <h4 class="card-title">Vehicle Transport Fare</h4>
                     </div>
                     <div class="col-md-4 text-right">
                        <div class="card-footer bg-transparent" style="margin-top: -15px;">
                           <div class="text-center">
                              <a href="<?= site_url('admin/transport/create') ?>" class="btn btn-outline-success btn-sm align-middle me-2" title="Vehicle" style="float: right;">
                              <i class="fas fa-plus"></i> New Transport fare
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="table-responsive">
                     <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                        <thead class="table-light">
                           <tr>
                              <th class="align-middle">Sr.</th>
                              <th class="align-middle">Country</th>
                              <th class="align-middle">State</th>
                              <th class="align-middle">City</th>
                              <th class="align-middle">Vehicle</th>
                              <th class="align-middle">Base Price</th>
                              <th class="align-middle">General Price</th>
                              <th class="align-middle">Business Price</th>
                              <th class="align-middle">Fare Night Price</th>
                              <th class="align-middle">Fare Extra Waiting Price</th>
                              <th class="align-middle">Stop Price</th>
                              <th class="align-middle">Fare Commission</th>
                              <th class="align-middle">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php foreach($transport->result() as $key => $data) { ?>
                           <tr>
                              <td><a href="javascript: void(0);" class="text-body fw-bold">#<?= $key + 1 ?></a> </td>
                              <td><?= $data->country_name ?></td>
                              <td><?= $data->state_name ?></td>
                              <td><?= $data->city_name ?></td>
                              <td><?= $data->vehicle_name ?></td>
                              <td><?= $data->fare_base_price?></td>
                              <td><?= $data->fare_general_price ?></td>
                              <td><?= $data->fare_business_price ?></td>
                              <td><?= $data->fare_night_price ?></td>
                              <td><?= $data->fare_extra_waiting_price ?></td>
                              <td><?= $data->fare_stop_price ?></td>
                              <td><?= $data->fare_commission ?></td>
                              <td>
                                 <div class="d-flex gap-3">
                                    <a href="<?= site_url('admin/transport/update/'.$data->fare_id) ?>" class="btn btn-outline-secondary btn-sm"><i class="mdi mdi-pencil font-size-13"></i></a>
                                    <a href="<?= site_url('admin/transport/remove/'.$data->fare_id) ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to remove this fare ?');"><i class="mdi mdi-delete font-size-13"></i></a>
                                 </div>
                              </td>
                           </tr>
                           <?php } ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- End Page-content -->
<?php include(__DIR__.'/../common/_footer.php'); ?>
<script src="<?= base_url('back-end/libs/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('back-end/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<!-- Buttons examples -->
<script src="<?= base_url('back-end/libs/datatables.net-buttons/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('back-end/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('back-end/libs/jszip/jszip.min.js') ?>"></script>
<script src="<?= base_url('back-end/libs/pdfmake/build/pdfmake.min.js') ?>"></script>
<script src="<?= base_url('back-end/libs/pdfmake/build/vfs_fonts.js') ?>"></script>
<script src="<?= base_url('back-end/libs/datatables.net-buttons/js/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url('back-end/libs/datatables.net-buttons/js/buttons.print.min.js') ?>"></script>
<script src="<?= base_url('back-end/libs/datatables.net-buttons/js/buttons.colVis.min.js') ?>"></script>
<!-- Datatable init js -->
<script src="<?= base_url('back-end/js/pages/datatables.init.js') ?>"></script>