<?php date_default_timezone_set("Asia/Manila")?>
<div class='container'>
    <br><br>
    <?php
if (!empty($error)) {
	echo "<span class=\"red-text\" >" . $error . "</span>";
}
?>
   <br><br>
   <a href="<?=base_url()?>importdata" class="waves-effect waves-light btn left red">back</a>
   <br>
   <center>
    <h4>For Overall data insertion</h4>
</center>
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
<div style="margin-top: 120px;">
    <center>
        <h4>For attendance data only</h4>
    </center>
    <form id="attendanceForm" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="input-field col s6">
                <select id="sel_sched" name="sched">
                    <option value="" disabled selected>Select the Schedule</option>
                    <?php
foreach ($lects as $lect) {
	echo "<option value='$lect->sched_id'>$lect->fullname — $lect->lec_id " . date('(D g:iA-', $lect->start_time) . date('g:iA)', $lect->end_time) . "</option>";
}
?>
               </select>
           </div>
           <div class="file-field input-field col s6">
            <div class="btn">
                <span>File</span>
                <input type="file" name="userfile"/> <!-- put required -->
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
            </div>

            <!-- Modal Trigger -->
            <div class="input-field">
                <a class="waves-effect waves-light btn modal-trigger right" href="#modal2">Next</a>
            </div>

            <!-- Modal Structure -->
            <div id="modal2" class="modal">
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
    </div>
</form>
</div>
</div>
