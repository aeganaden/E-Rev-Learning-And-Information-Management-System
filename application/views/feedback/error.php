<!--====================================
=            Navigation Top            =
=====================================-->

<?php $this->load->view('includes/home-navbar'); ?>

<!--====  End of Navigation Top  ====<--></-->
<?php $this->load->view('includes/home-sidenav'); ?>
<!--ABOVE IS PERMA-->
<div class="container">
    <div class="col s12" style="margin-top: 20vh">
        <center>
            <h5  class="color-red">
                <span id="error_message"></span>
            </h5>
        </center>
    </div>
</div>

<script>document.getElementById("error_message").innerHTML = "It seems like you already sent feedback to<br>this professor in the past term/school year."</script>