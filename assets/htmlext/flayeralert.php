<?php
  require_once("_init_hext.php");

?>


<link rel="stylesheet" href="<?php echo $baseURL ?>assets/css/utils.css">
<link rel="stylesheet" href="<?php echo $baseURL ?>assets/css/flayers.css?v=7">
  <div class="over-flalert" id="gd-fancy-box">
    
    <div class="gdalert fancy-box">
      <div class="flayercontent">
        <p class="font-gold-pusab" id="fllayertitle-fancy">TEST ALERT</p>
        <p class="font-helvetica" id="fllayerdesc-fancy">TEST ALERT 123</p>
        <div class="flayeroptions-fancy" id="options-fl-layer-fancy"></div>
        <button class="gdbtn-close fancy-0" id="gdclose-fancy-btn"></button>
      </div>
    </div>
  </div>
  <div class="over-flalert" id="gd-brown-box">
    <div class="gdalert brown-box">
      <div class="flayercontent">
        <p class="font-gold-pusab" id="fllayertitle-brown">TEST ALERT</p>
        <p class="font-helvetica" id="fllayerdesc-brown">TEST ALERT 123</p>
        <img src="<?php echo $baseURL ?>assets/loading.png" alt="Loading" class="fllayeriframe-brown-rotating-img" id="fllayeriframe-brown-rotating-img">
        <iframe class="iframe-brown" id="fllayeriframe-brown" src="" frameborder="0"></iframe>
        <button class="gdbtn-close brown-0" id="gdclose-brown-btn"></button>
      </div>
    </div>
  </div>
<script src="<?php echo $baseURL ?>assets/js/utils.js?v=2"></script>
<script src="<?php echo $baseURL ?>assets/js/securityParser.js?v=7"></script>
<script src="<?php echo $baseURL ?>assets/js/flayers.js?v=9"></script>


