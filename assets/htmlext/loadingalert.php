<?php
    require_once("_init_hext.php");
?>


<link rel="stylesheet" href="<?php echo $baseURL ?>assets/css/utils.css?v=<?= $_OBEYGDBROWSER_FILEVERSION; ?>">
<link rel="stylesheet" href="<?php echo $baseURL ?>assets/css/loadingalert.css?v=<?= $_OBEYGDBROWSER_FILEVERSION; ?>">
<div class="loading-main" id="loading-main">
    <div class="rotating-loadermain-image">
      <img src="<?php echo $baseURL ?>assets/loading.png" alt="Loading" id="rotating-img">
    </div>
</div>

<!-- Mini Alert (Loading for default) buttom -->

<div class="loading-alert-buttom-display" id="loading-alert-buttom-display">
  <div class="alert-loadermain-image">
    <img src="<?php echo $baseURL ?>assets/loading.png" class="load" id="alert-buttom-icon" alt="Alert Image">
    <p class="gdfont-Pusab small" id="loading-alert-buttom-display-text">Loading...</p>
  </div>
</div>
<script src="<?php echo $baseURL ?>assets/js/loadingalert.js?v=<?= $_OBEYGDBROWSER_FILEVERSION; ?>"></script>