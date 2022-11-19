<?php include(__DIR__.'/../../common/_header.php'); ?>
<?php include(__DIR__.'/../../common/_sidebar.php'); ?>
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Driver</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active">Driver Document</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
          <?php if($status == false){ ?>
         <div class="col-md-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
               <i class="mdi mdi-block-helper me-2"></i>
               Your KYC Verification Still pending after upload your documents and wait some time for KYC update Process !
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
         </div>
         <?php } ?>
         <div class="col-xl-12">
            <?php include(__DIR__.'/../../common/_message.php'); ?>
            <div class="card">
               <div class="card-body">
                  <div class="row mb-4">
                     <div class="col-md-8">
                        <h4 class="card-title">KYC Verification Document</h4>
                     </div>
                     <div class="col-md-4 text-right">
                        <div class="card-footer bg-transparent" style="margin-top: -15px;">
                           <div class="text-center">
                              <a href="<?= site_url('admin/drivers/dashboard/'.$this->uri->segment(4)) ?>" class="btn btn-outline-dark btn-sm align-middle me-2" title="Back" style="float: right;">
                              <i class="fas fa-back"></i> Back
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <?php foreach($requireddocument->result() as $key => $data){ ?>
                     <?php if($data->document_front_image == 1){ ?>
                     <div class="col-md-6">
                        <div class="row">
                           <div class="col-md-6">
                              <h4 class="card-title"><?= $data->document_label ?> (Front)</h4>
                              <p class="badge badge-soft-dark font-size-12 p-2">
                                  <?= @$data->document_uploads->doc_id_number ?>
                              </p>
                           </div>
                           <div class="col-md-6">
                              <div class="dropdown float-end">
                                 <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false">
                                 <i class="bx bx-menu m-0 font-size-18"></i>
                                 </a>
                                 <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item deletetask" href="<?= site_url('admin/document/status/1/'.@$data->document_uploads->doc_id) ?>">Approved</a>
                                    <a class="dropdown-item deletetask" href="<?= site_url('admin/document/status/2/'.@$data->document_uploads->doc_id) ?>">Reject</a>
                                 </div>
                              </div>
                              <div class="mr-10">
                                 <?php if(@$data->document_uploads->doc_status == 1){ ?>
                                 <span class="badge badge-soft-success font-size-12" id="task-status">Approved</span>
                                 <?php }elseif(@$data->document_uploads->doc_status == 2){ ?>
                                 <span class="badge badge-soft-danger font-size-12" id="task-status">Cancel</span>
                                 <?php }elseif(@$data->document_uploads->doc_status == 0){ ?>
                                 <span class="badge badge-soft-info font-size-12" id="task-status">Pending</span>
                                 <?php } ?>
                              </div>
                           </div>
                        </div>
                        <?php if(!empty($data->document_uploads)){ ?>
                            <img class="rounded me-2" alt="200x200" width="300" src="<?= $data->document_uploads->doc_front_image ?>" data-holder-rendered="true">
                        <?php }else{ ?>
                            <img class="rounded me-2" alt="200x200" width="300" src="<?= $data->document_placeholder ?>" data-holder-rendered="true">
                        <?php } ?>
                        
                     </div>
                     <?php } ?>
                     <?php if($data->document_back_image == 1){ ?>
                     <div class="col-md-6">
                        <div class="row">
                           <div class="col-md-6">
                              <h4 class="card-title"><?= $data->document_label ?> (Back)</h4>
                              <p class="card-title-desc">
                              </p>
                           </div>
                        </div>
                        <?php if(!empty($data->document_uploads)){ ?>
                            <img class="rounded me-2" alt="200x200" width="300" src="<?= $data->document_uploads->doc_back_image ?>" data-holder-rendered="true">
                        <?php }else{ ?>
                            <img class="rounded me-2" alt="200x200" width="300" src="<?= $data->document_placeholder ?>" data-holder-rendered="true">
                        <?php } ?>
                     </div>
                     <?php } ?>
                     <hr class="mt-3">
                     <?php } ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php include(__DIR__.'/../../common/_footer.php'); ?>