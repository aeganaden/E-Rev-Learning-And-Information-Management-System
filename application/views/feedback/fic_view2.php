<!--====================================
=            Navigation Top            =
=====================================-->

<?php $this->load->view('includes/home-navbar'); ?>

<!--====  End of Navigation Top  ====<--></-->
<?php $this->load->view('includes/home-sidenav'); ?>
<!--ABOVE IS PERMA-->
<div class="container">
    <form method="post" action="<?= base_url() ?>feedback/content">
        <div class="row">
            <div class="input-field col s6">
                <select name="section">
                    <option value="" disabled selected>Section</option>
                    <option value="1">Option 1</option>
                </select>
            </div>
            <div class="input-field col s6">
                <select name="section">
                    <option value="" disabled selected>Lecturer</option>
                    <option value="1">Option 1</option>
                </select>
            </div>
        </div>
        <div class="center-align">
            <button class="btn waves-effect waves-light" type="submit" name="action">
                Show Feedback
                <i class="material-icons right">send</i>
            </button>
        </div>
    </form>

    <?php
    if (isset($feedback)) {
        echo $feedback;
    }
    ?>
</div>