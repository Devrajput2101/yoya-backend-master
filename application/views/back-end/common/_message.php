<div class="col-12 mt-2 mb-2">
    <?php if($this->session->flashdata('error')){ ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="mdi mdi-block-helper me-2"></i>
        <?= $this->session->flashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php } ?>
    <?php if($this->session->flashdata('warning')){ ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="mdi mdi-alert-outline me-2"></i>
        <?= $this->session->flashdata('warning') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php } ?>
    <?php if($this->session->flashdata('success')){ ?>
    <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
        <i class="mdi mdi-alert-circle-outline me-2"></i>
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php } ?>
</div>