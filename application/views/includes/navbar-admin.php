<!-- Dropdown Structure -->
<ul id="dropdown1" class="dropdown-content">
  <li class="bg-color-white"><a href="<?=base_url()?>Enrollment" class="color-black">Enrollment</a></li>
  <li class="divider"></li>
  <li class="bg-color-white"><a href="<?=base_url()?>Login/logout " class="color-black">Log Out</a></li>
</ul>
<nav class="bg-primary-yellow">
  <div class="nav-wrapper nav-admin">
    <a href="#" class="brand-logo center"><img src="<?=base_url()?>assets/img/feu-header.png" style="width: 40vh; margin-top: 2%;"></a>
    <ul class="right hide-on-med-and-down ">
      <li><a class="color-black" href="<?=base_url()?>Admin">Home</a></li>
      <li><a class="color-black" href="<?=base_url()?>Archive">Archive</a></li>
      <li><a class="color-black" href="<?=base_url()?>Admin/Announcements ">Announcements</a></li>
      <!-- Dropdown Trigger -->
      <li><a class="dropdown-button color-black" href="#!" data-activates="dropdown1">Settings<i class="material-icons right">arrow_drop_down</i></a></li>
    </ul>
  </div>
</nav>