
<div class='container'>
    <?php echo form_open_multipart('Importdata/1'); ?>
    <input type="file" name="userfile"/>
    <br><br>
    <input type="submit" value="upload" />
</form>
</div>

<?php
if (!empty($error)) {
    print($error);
}