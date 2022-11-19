<?php include(__DIR__.'/../common/_header.php'); ?>
<?php include(__DIR__.'/../common/_sidebar.php'); ?>
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Vehicles</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active">Vehicles</li>
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
                        <h4 class="card-title">Vehicles</h4>
                    </div>
                     <div class="col-md-4 text-right">
                        <div class="card-footer bg-transparent" style="margin-top: -15px;">
                            <div class="text-center">
                                <a href="<?= site_url('admin/vehicle/create') ?>" class="btn btn-outline-success btn-sm align-middle me-2" title="Vehicle" style="float: right;">
                                    <i class="fas fa-plus"></i> New vehicle
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
                              <th class="align-middle">Vehicle Type</th>
                              <th class="align-middle">Vehicle Name</th>
                              <th class="align-middle">Status</th>
                              <th class="align-middle">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php foreach($vehicle->result() as $key => $data) { ?>
                           <tr>
                              <td><a href="javascript: void(0);" class="text-body fw-bold">#<?= $key + 1 ?></a> </td>
                              <td><?= $data->vehicle_type_name ?></td>
                              <td><?= $data->vehicle_name ?></td>
                               <td>
                                 <input type="checkbox" class="vehicle-ststus" data-id="<?= $data->vehicle_id ?>"<?= $data->vehicle_status =="1" ? "checked" : "" ?> id="vehicle<?= $key + 1 ?>" switch="info"/>
                                 <label for="vehicle<?= $key + 1 ?>" data-on-label="Yes" data-off-label="No"></label>
                              </td>
                              <td>
                                 <div class="d-flex gap-3">
                                    <a href="<?= site_url('admin/vehicle/edit/'.$data->vehicle_id) ?>" class="btn btn-outline-secondary btn-sm"><i class="mdi mdi-pencil font-size-13"></i></a>
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

<script type="text/javascript">
   /*for vehicle active*/
   $(document).on('change','.vehicle-ststus',function(){
    var _this = $(this),_data_id,_data_status;
    _data_id = _this.data('id');
    _data_status = '0';
    if (_this.prop('checked') == true){ 
       _data_status = '1';
    }
      $.ajax({
        method: "POST",
        url: "<?= base_url('admin/vehicle/vehiclestatus') ?>",
        data: { vehicle_id: _data_id, status: _data_status }

      }).done(function(response) {
         console.log(response);
      }).fail(function(errors){
         console.log(errors);
      });
   })
   </script>
