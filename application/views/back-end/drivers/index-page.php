<?php include(__DIR__.'/../common/_header.php'); ?>
<?php include(__DIR__.'/../common/_sidebar.php'); ?>
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Drivers</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active">Drivers</li>
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
                        <h4 class="card-title">Drivers</h4>
                    </div>
                     <div class="col-md-4 text-right">
                        <div class="card-footer bg-transparent" style="margin-top: -15px;">
                            <!--<div class="text-center">-->
                            <!--    <a href="<?= site_url('admin/drivers/create') ?>" class="btn btn-outline-success btn-sm align-middle me-2" title="New Drivers" style="float: right;">-->
                            <!--        <i class="fas fa-plus"></i> New Drivers-->
                            <!--    </a>-->
                            <!--</div>-->
                        </div>
                    </div>
                </div>
                  <!-- <div class="row mb-4">
                     <div class="col-lg-12">
                        <form class="row gy-2 gx-3 align-items-center">
                           <div class="col-sm-auto">
                              <input type="text" class="form-control" id="Name" placeholder="K.K ADIL KHAN AJAD" name="name">
                           </div>
                           <div class="col-sm-auto">
                              <div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                 <input type="text" class="form-control" name="start" placeholder="Start Date" />
                                 <input type="text" class="form-control" name="end" placeholder="End Date" />
                              </div>
                           </div>
                           <div class="col-sm-auto">
                              <button type="button" class="btn btn-primary waves-effect waves-light">
                              <i class="bx bx-search font-size-16 align-middle me-2"></i> Search
                              </button>
                           </div>
                        </form>
                     </div>
                  </div> -->
                  <!-- end row -->
                  <div class="table-responsive">
                     <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                        <thead class="table-light">
                           <tr>
                              <th class="align-middle">Sr.</th>
                              <th class="align-middle">Name</th>
                              <th class="align-middle">Email</th>
                              <th class="align-middle">Phone</th>
                              <th class="align-middle">Date</th>
                              <th class="align-middle">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php foreach($drivers->result() as $key => $data) { ?>
                           <tr>
                              <td><a href="javascript: void(0);" class="text-body fw-bold">#<?= $key + 1 ?></a> </td>
                              <td><?= $data->user_name ?></td>
                              <td><?= $data->user_email ?></td>
                              <td><?= '+'.$data->user_country_code.'-'.$data->user_phone ?></td>
                              <td><?= dateFormat($data->driver_create_at) ?></td>
                              <td>
                                 <div class="d-flex gap-1">
                                    <a href="<?= site_url('admin/drivers/dashboard/'.$data->user_id) ?>" class="btn btn-outline-secondary btn-sm"><i class="mdi mdi-eye"></i></a>
                                    <a href="<?= site_url('admin/drivers/edit/'.$data->user_id) ?>" class="btn btn-outline-secondary btn-sm"><i class="mdi mdi-pencil"></i></a>
                                    <a href="<?= site_url('admin/document/uploads/'.$data->user_id) ?>" class="btn btn-outline-secondary btn-sm"><i class="mdi mdi-file"></i></a>
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
   <!-- container-fluid -->
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
