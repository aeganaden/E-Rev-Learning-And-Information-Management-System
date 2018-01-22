<nav class="a-navbar">
    <div class="nav-wrapper bg-primary-yellow" style="height: 100%;">
        <a href="<?=base_url()?>" class="brand-logo center"><img src="<?= base_url() ?>assets/img/feu-header.png" style="width: 40vh; margin-top: 2%;"></a>
        <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
        <ul id="nav-mobile" class="right hide-on-med-and-down a-nav-elements">
            <li><a class="waves-effect waves-light btn bg-primary-green modal-trigger" href="#a-login-modal">Login</a></li>
        </ul>
        <ul class="side-nav" id="mobile-demo">
            <li><a class="waves-effect waves-light btn bg-primary-green modal-trigger"  href="#a-login-modal">Login</a></li>
        </ul>
    </div>

</nav>

<!--========================================
=            Navigation Buttons            =
=========================================-->

<div class="fixed-action-btn">
    <a class="btn-floating btn-large bg-primary-yellow">
      <i class="large material-icons">list</i>
  </a>
  <ul>
      <li>
         <a class="btn-floating bg-primary-green tooltipped" 
         data-position="left"  
         data-delay="10"
         data-tooltip="Features"> <i class="material-icons">details</i>  </a>
     </li>
     <li><a class="btn-floating bg-primary-green tooltipped" data-position="left"  
         data-delay="10"
         data-tooltip="Benefits"><i class="material-icons">trending_up</i></a></li>
         <li><a class="btn-floating green"><i class="material-icons">publish</i></a></li>
         <li><a class="btn-floating blue"><i class="material-icons">attach_file</i></a></li>
     </ul>
 </div>

 <!--====  End of Navigation Buttons  ====-->

