<!--====================================
=            Navigation Top            =
=====================================-->

<?php $this->load->view('includes/home-navbar'); ?>

<!--====  End of Navigation Top  ====<-->
<?php $this->load->view('includes/home-sidenav'); ?>
<!--ABOVE IS PERMA-->

<div class="row container">
    <div class="col s4">
        <blockquote class="color-primary-green">
            <h4 class="color-black">Import Questions</h4>
        </blockquote>
    </div>
    <div class="col s4"></div>
    <div class="col s4"></div>
</div>
<div class="row container">
    <form enctype="multipart/form-data" action="<?= base_url() ?>ImportQuestions/uploadquestions" method="POST">
        <blockquote class="color-red">
            <?php if (isset($error_message)): ?>
                <h6><b>ERROR:</b></h6>
                <?php foreach ($error_message as $err): ?>
                    <h6 class="color-red">
                        <?php echo $err; ?>
                    </h6>
                <?php endforeach; ?>
            <?php endif; ?>
        </blockquote>
        <div class="row">
            <div class="file-field input-field">
                <?php if ("" == form_error('excel_file') && !empty(form_error('excel_file'))): ?>
                    <div class="btn">
                        <span>File</span>
                        <input type="file" id="input_excel" name="excel_file" required>
                    </div>
                    <div class="file-path-wrapper">
                        <input style="border-bottom: 1px solid #e24646;box-shadow: none;" class="file-path validate" type="text" name="excel_text" required>
                    </div>
                    <span class="red-text"><?php echo form_error('excel_text'); ?></span>
                <?php else: ?>
                    <div class="btn">
                        <span>File</span>
                        <input type="file" id="input_excel" name="excel_file" required>
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" name="excel_text" required>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="input-field">
            <button class="btn waves-effect waves-light right green" type="submit" name="submit">UPLOAD</button>
            <a href="<?= base_url() ?>ImportQuestions" class="waves-effect waves-light btn left red">CANCEL</a>
        </div>
    </form>
</div>