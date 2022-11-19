<?php include(__DIR__.'/../common/_header.php'); ?>
<?php include(__DIR__.'/../common/_sidebar.php'); ?>
<!-- page wise css -->
<link href="<?= base_url('back-end') ?>/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?= base_url('back-end') ?>/libs/%40chenfengyuan/datepicker/datepicker.min.css">
<!-- page wise css -->
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Pages</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active">Page</li>
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
                        <h4 class="card-title">Pages</h4>
                    </div>
                     <div class="col-md-4 text-right">
                        <div class="card-footer bg-transparent" style="margin-top: -15px;">
                            <div class="text-center">
                                <a href="<?= site_url('admin/page/create') ?>" class="btn btn-outline-success btn-sm align-middle me-2" title="New Pages" style="float: right;">
                                    <i class="fas fa-plus"></i> New Pages
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                  <div class="table-responsive">
                     <table class="table align-middle table-nowrap table-check">
                        <thead class="table-light">
                           <tr>
                              <th class="align-middle">Sr.</th>
                              <th class="align-middle">title</th>
                              <th class="align-middle">Date</th>
                              <th class="align-middle">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php foreach($pages->result() as $key => $data) { ?>
                           <tr>
                              <td><a href="javascript: void(0);" class="text-body fw-bold">#<?= $key + 1 ?></a> </td>
                              <td><?= $data->page_title ?></td>
                              <td><?= $data->page_create_at ?></td>
                              <td>
                                 <div class="d-flex gap-3">
                                    <a href="<?= site_url('admin/page/edit/'.$data->page_id) ?>" class="btn btn-outline-secondary btn-sm"><i class="mdi mdi-pencil font-size-13"></i></a>
                                    <input type="checkbox" class="page-status" data-id="<?= $data->page_id ?>"  <?= $data->page_delete_at =="0" ? "checked" : "" ?> id="pages<?= $key + 1 ?>" switch="danger"/>
                                 <label for="pages<?= $key + 1 ?>" data-on-label="delete" data-off-label="Del"></label></div>
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
<script type="text/javascript">
   /*for currency active*/
   $(document).on('change','.page-status',function(){
    var _this = $(this),_data_id,_data_status;
    _data_id = _this.data('id');
    _data_status = '1';
    if (_this.prop('checked') == true){ 
       _data_status = '0';
    }

      $.ajax({
        method: "POST",
        url: "<?= base_url('admin/page/page_delete') ?>",
        data: { page_id: _data_id, status: _data_status }
      }).done(function(response) {
         console.log(response);
      }).fail(function(errors){
         console.log(errors);
      });
   })
</script>