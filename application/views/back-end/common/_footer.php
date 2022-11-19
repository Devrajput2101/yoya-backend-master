   <footer class="footer">
      <div class="container-fluid">
         <div class="row">
            <div class="col-sm-6">
               <script>document.write(new Date().getFullYear())</script> © <?= @$this->data['config']['web_appname'] ?>.
            </div>
            <div class="col-sm-6">
               <div class="text-sm-end d-none d-sm-block">
                  Design & Develop by Digital Kranti
               </div>
            </div>
         </div>
      </div>
   </footer>
</div>
<!-- end main content-->
</div>
<?php include(__DIR__.'/../uploader/aiz-uploads-model.php'); ?>
<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>
<!-- JAVASCRIPT -->
<script src="<?= base_url('back-end') ?>/libs/jquery/jquery.min.js"></script>
<script src="<?= base_url('back-end') ?>/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('back-end') ?>/libs/metismenu/metisMenu.min.js"></script>
<script src="<?= base_url('back-end') ?>/libs/simplebar/simplebar.min.js"></script>
<script src="<?= base_url('back-end') ?>/libs/node-waves/waves.min.js"></script>
<!-- App js -->
<script src="<?= base_url('back-end') ?>/libs/select2/js/select2.min.js"></script>
<script src="<?= base_url('back-end') ?>/js/app.js"></script>
<script src="https://transloadit.edgly.net/releases/uppy/v1.6.0/uppy.min.js"></script>
<script src="<?= base_url('back-end') ?>/js/aiz-core.js"></script>
</body>
</html>