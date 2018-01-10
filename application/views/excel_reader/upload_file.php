
<div class='container'>
    <br><br>
    <?php
    if (!empty($error)) {
        echo "<span class=\"red-text\" >" . $error . "</span>";
    }
    ?>
    <br><br>
    <?php echo form_open_multipart('Importdata/filecheck'); ?>
    <div class="file-field input-field">
        <div class="btn">
            <span>File</span>
            <input type="file" name="userfile" required/>
        </div>
        <div class="file-path-wrapper">
            <input class="file-path validate" type="text">
        </div>
        <!-- Modal Trigger -->
        <div class="input-field">
            <a class="waves-effect waves-light btn modal-trigger right" href="#modal1">Next</a>
        </div>

        <!-- Modal Structure -->
        <div id="modal1" class="modal">
            <div class="modal-content">
                <h4><span class='red-text'>WARNING</span></h4>
                <p>Are you sure you want to upload this </p>
            </div>
            <div class="modal-footer">
                <button type="submit" value="upload" class="modal-action modal-close waves-effect waves-light btn right">
                    proceed
                </button>
                <button type="button" class="modal-action modal-close waves-effect red waves-light btn">
                    cancel
                </button>
            </div>
        </div>
    </div>
</form>
</div>
