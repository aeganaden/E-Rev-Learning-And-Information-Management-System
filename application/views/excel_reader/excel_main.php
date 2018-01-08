
<div class='container'>
    <?php echo form_open_multipart('excel_import/import_data'); ?>
    <input type="file" name="userfile"/>
    <br><br>
    <input type="submit" value="upload" />
</form>
</div>

<?php
if (!empty($error)) {
    print($error);
}

//echo form_open_multipart('excel_import/import_data');
//echo form_upload('file');
//echo '<br>';
//echo form_submit(null, 'Upload');
//echo form_close();
?>