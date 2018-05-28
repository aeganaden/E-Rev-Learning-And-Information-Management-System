<?php $this->load->view('includes/navbar-admin'); ?>

<?php
$enrollment = $this->Crud_model->fetch("enrollment");
?>
<div class="container row">
    <div class="col s12">
        <blockquote class="color-primary-green" style="margin-top: 5%;">
            <h5 class="color-black valign-wrapper">Manage Term/Sy
                <i class="material-icons color-primary-green modal-trigger" href="#modal1" style="padding-left: 1%; cursor: pointer;">add_circle</i>
            </h5>
        </blockquote>
        <div class="row" style="padding-top: 5%;">
            <?php if (isset($enrollment) && !empty($enrollment)): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Enrollment S.Y</th>
                        <th>Enrollment Term</th>
                        <th>Actions</th>
                        <th>Based Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($enrollment as $key => $value): ?>
                        <tr>
                            <td><?= $value->enrollment_id ?></td>
                            <td><?= $value->enrollment_sy ?></td>
                            <td><?= $value->enrollment_term == 4 ? "Summer" : $value->enrollment_term ?></td>
                            <td>
                                <?php
                                $checked = $value->enrollment_is_active == 1 ? "checked" : "";
                                ?>
                                <div class="switch">
                                    <label>
                                        Deactivated
                                        <input type="checkbox" class="chk_admin" data-id="<?= $value->enrollment_id ?>" <?= $checked ?> >
                                        <span class="lever"></span>
                                        Activated
                                    </label>
                                </div>
                            </td>
                            <td>
                               <?php if ($checked): ?>
                                <p class="range-field" id="range<?= $value->enrollment_id ?>">
                                    <input type="range" id="slider<?= $value->enrollment_id ?>" value="<?= $value->passingPercentage?>" data-id="<?= $value->enrollment_id ?>" min="0" max="100" />
                                </p>
                                <?php else: ?>
                                   <p class="range-field" style="display: none;" id="range<?= $value->enrollment_id ?>">
                                    <input type="range" id="slider<?= $value->enrollment_id ?>" value="<?= $value->passingPercentage?>" data-id="<?= $value->enrollment_id ?>" min="0" max="100" />
                                </p>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <?php else: ?>
            <center><h3>No data to show.</h3></center>
        <?php endif; ?>
    </div>
</div>
</div>

<div id="modal1" class="modal bg-color-white  modal-fixed-footer">
    <div class="modal-content">
        <blockquote class="color-primary-green"><h4 class="color-black">ADD TERM SY</h4></blockquote>
        <div class="row" style="margin-top: 3%;">
            <div class="col s4">
                <label>Term Year</label>
                <select id="startYear">
                    <option value="" disabled selected>Choose Starting Term Year</option>
                </select>
            </div>
            <div class="col s4">
                <div class="input-field col s12">
                    <label for="endYear"  id="endYear">End Term Year</label>
                    <input disabled value="" type="text" class="validate">
                </div>
            </div>
            <div class="col s4">
                <label>Term</label>
                <select id="term">
                    <option value="" disabled selected>Choose Term </option>
                    <option value="1">1st Term</option>
                    <option value="2">2nd Term</option>
                    <option value="3">3rd Term</option>
                    <option value="4">Summer</option>
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-color-white">
        <a href="#!" id="add_termsy" class=" waves-effect waves-green btn bg-primary-green">ADD</a>
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn teal left">CANCEL</a>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        // Grade SLider
        $defGrade = 0;
        $("[type=range]").on("mousedown", function () { 
            $defGrade = $(this).val();
        });

        $("[type=range]").on("mouseup", function () { 
            $currGrade = $(this).val();
            $id = $(this).data('id');
            if ($defGrade != $currGrade) {
                // console.log($id);

                swal({
                    title: "Change passing grade?",
                    text: "This will change the passing percentage of practice exams!",
                    icon: "info",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "<?= base_url() ?>Enrollment/changeGradePercentage",
                            type: "post",
                            dataType: "json",
                            data: {
                                id: $id,
                                value: $currGrade
                            },
                            success: function (data) {
                               if (data == true) {
                                 swal("Success! Passing Percentage has been changed!", {
                                    icon: "success",
                                }).then(function () {
                                    // window.location.reload(true);
                                    $(this).val($currGrade);

                                });
                            }else{

                                $toast = "<span>Error Updating Passing Percentage!</span>";
                                Materialize.toast($toast, 2000);
                            }
                        },
                        error: function (data) {

                        }

                    });
                    }else{
                        $(this).val($defGrade);
                    }
                });
            }
        });
        



        /*============================
         =            year            =
         ============================*/

         var min = new Date().getFullYear(),
         max = min + 4,
         select = document.getElementById('startYear');

         for (var i = min; i <= max; i++) {
            var opt = document.createElement('option');
            opt.value = i;
            opt.innerHTML = i;
            select.appendChild(opt);
        }


        /*=====  End of year  ======*/


        $("#startYear").change(function (event) {
            // alert();
            $year = $(this).val();
            $("#endYear").html(parseInt($year) + 1);
        });



        $(document).on('click', '.chk_admin', function () {
            $('.chk_admin').prop('checked', false);
            $(this).prop('checked', true);
            
            $data = $(this).data("id");

            $('.range-field').hide('fast');
            $('#range'+$data).show('fast');
            // console.log($data);
            $.ajax({
                url: '<?= base_url() ?>Enrollment/updateEnrollment ',
                type: 'post',
                dataType: 'json',
                data: {
                    e_id: $data,
                },
                success: function (data) {
                    if (data == true) {
                        $toast = "<span>Active Enrollment Updated!</span>";
                        Materialize.toast($toast, 2000);
                    } else {
                        $toast = "<span>" + data + "</span>";
                        Materialize.toast($toast, 2000);
                    }
                }
            });

        });

        $("#add_termsy").click(function (event) {
            $year = $("#startYear").val();
            $term = $("#term").val();
            $.ajax({
                url: '<?= base_url() ?>Enrollment/insertEnrollment ',
                type: 'post',
                dataType: 'json',
                data: {
                    year: $year,
                    term: $term,
                },
                success: function (data) {
                    if (data == true) {
                        swal("Done!", "Successfully added", "success").then(function () {
                            window.location.reload(true);
                        });
                    } else {
                        $toast = '<span>' + data + '</span>';
                        Materialize.toast($toast, 2000);
                    }
                }
            });

        });

    });
</script>