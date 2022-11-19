<?php include(__DIR__.'/../common/_header.php'); ?>
<?php include(__DIR__.'/../common/_sidebar.php'); ?>
<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col-md-6">
			<h1 class="h3">All uploaded files</h1>
		</div>
		<div class="col-md-6 text-md-right">
			<a href="uploaded-files.create" class="btn btn-primary">
				<span>Upload New File</span>
			</a>
		</div>
	</div>
</div>
<div class="card">
    <div class="card-body">
    	<div class="row gutters-5">
    		<?php foreach($uploads->result() as $key => $file) {
				if($file->file_original_name == null){
				    $file_name = translate('Unknown');
				}else{
					$file_name = $file->file_original_name;
    			}
    		 ?>
    			<div class="col-auto w-140px w-lg-220px">
    				<div class="aiz-file-box">
    					<div class="dropdown-file" >
    						<a class="dropdown-link" data-toggle="dropdown">
    							<i class="la la-ellipsis-v"></i>
    						</a>
    						<div class="dropdown-menu dropdown-menu-right">
    							<a href="javascript:void(0)" class="dropdown-item" onclick="detailsInfo(this)" data-id="<?= $file->id ?>">
    								<i class="las la-info-circle mr-2"></i>
    								<span>Details Info</span>
    							</a>
    							<a href="" target="_blank" download="<?=$file_name ?>.<?=$file->extension ?>" class="dropdown-item">
    								<i class="la la-download mr-2"></i>
    								<span>Download</span>
    							</a>
    							<a href="javascript:void(0)" class="dropdown-item" onclick="copyUrl(this)" data-url="">
    								<i class="las la-clipboard mr-2"></i>
    								<span>Copy Link</span>
    							</a>
    							<a href="javascript:void(0)" class="dropdown-item confirm-alert" data-href="uploaded-files.destroy', $file->id" data-target="#delete-modal">
    								<i class="las la-trash mr-2"></i>
    								<span>Delete</span>
    							</a>
    						</div>
    					</div>
    					<div class="card card-file aiz-uploader-select c-default" title="<?=$file_name ?>.<?=$file->extension ?>">
    						<div class="card-file-thumb">
    							<?php if($file->type == 'image'){ ?>
    								<img src="" class="img-fit">
    							<?php } ?>
    							<?php if( $file->type == 'video'){ ?>
    								<i class="las la-file-video"></i>
    							<?php }else{ ?>
    								<i class="las la-file"></i>
    							<?php } ?>
    						</div>
    						<div class="card-body">
    							<h6 class="d-flex">
    								<span class="text-truncate title"><?= $file_name ?></span>
    								<span class="ext">.<?= $file->extension ?></span>
    							</h6>
    							<p><?= $file->file_size ?></p>
    						</div>
    					</div>
    				</div>
    			</div>
    		<?php } ?>
    	</div>
    </div>
</div>
<?php include(__DIR__.'/aiz-uploads-model.php'); ?>
<?php include(__DIR__.'/../common/_footer.php'); ?>