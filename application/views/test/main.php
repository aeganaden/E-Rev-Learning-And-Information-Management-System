<?php echo form_open_multipart('Importdata/filecheck'); ?>
<div class="file-field input-field">
    <div class="btn">
        <span>File</span>
        <input type="file" name="excel_file" required/>
    </div>
    <div class="file-path-wrapper">
        <input class="file-path validate" type="text">
    </div>
    <button class="btn waves-effect waves-light" type="submit" name="action">Submit
        <i class="material-icons right">send</i>
    </button>
</div>

</form>