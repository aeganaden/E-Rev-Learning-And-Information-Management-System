<?php $this->load->view('includes/navbar-admin'); ?>
<div class="row">
    <div class="col s3"></div>
    <div class="col s6" style='padding-top:50px;'>
        <h5 class='center'>Please fill-up the form to check your credentials.</h5>
        <span class='red-text center'>
            <?php
            if (!empty($error)) {
                echo $error;
            }
            ?>
        </span>
        <form action="<?= base_url() ?>importdata/credentialcheck/" method='post'>
            <div class="input-field">
                <input type="text" class="validate" name='username' autofocus required>
                <label for="username">Username</label>
            </div>
            <div class="input-field">
                <input name="password" type="password" class="validate" required>
                <label for="password">Password</label>
            </div>
            <div class="input-field">
                <a href="<?= base_url() ?>admin" class="waves-effect waves-light btn left red">return</a>
                <button type="submit" value="upload" class="waves-effect waves-light btn right">
                    next
                </button>
            </div>
        </form>
    </div>
    <div class="col s3"></div>
</div>