<!--====================================
=            Navigation Top            =
=====================================-->

<?php $this->load->view('includes/home-navbar'); ?>

<!--====  End of Navigation Top  ====<--></-->
<?php $this->load->view('includes/home-sidenav'); ?>
<!--ABOVE IS PERMA-->

<div class="row container">
    <div class="col s4">
        <blockquote class="color-primary-green">
            <h3 class="color-black">Section Details<a href="<?= base_url() ?>Sections/add/<?php echo $this->uri->segment(3); ?>" class="waves-effect waves-light btn"><i class="material-icons left">add</i>Add Student</a></h3>
        </blockquote>
    </div>
    <div class="col s4"></div>
    <div class="col s4"></div>
</div>
<div class="row container">
    <center><h2>LIST OF STUDENTS WITH REMOVE BUTTON</h2></center>
</div>

<script>
    $(document).ready(function () {
        $(".btn_view").click(function () {
            $data = $(this).data('id');
            window.location.href = "<?= base_url() . "Sections/section_detail/" ?>" + $data;
        });

    });

</script>