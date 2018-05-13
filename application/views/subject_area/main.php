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
            <h3 class="color-black">Subject Area Management</h3>
        </blockquote>
    </div>
    <div class="col s4"></div>
    <div class="col s4"></div>
</div>
<div class="row container">
    <pre>
        <?php // print_r($year_holder); ?>
    </pre>
    <?php if (isset($year_holder) && !empty($year_holder)): ?>
        <table class="data-table" id="tbl-feedback">
            <thead>
                <tr>
                    <th>Year Level</th>
                    <th>Subject Area</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($year_holder as $idkey => $subyear_holder): ?>
                    <?php foreach ($subyear_holder as $key => $res): ?>
                        <tr class="bg-color-white">
                            <td><?= $key ?></td>
                            <td><?= implode("<br>", $res); ?></td>
                            <td><a data-id="<?= $idkey ?>" class="waves-effect waves-dark btn bg-primary-green btn_view_a">View</a></td>
                            <td><a class="waves-effect waves-dark btn bg-primary-yellow btn_vedit_a">Edit</a></td>
                            <td><a class="waves-effect waves-dark btn red btn_delete_a">Delete</a></td>
                        </tr>
                    <?php endforeach ?>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php else: ?>
        <center style="margin-top:20vh;">
            <h3>No data to show</h3>
        </center>
    <?php endif; ?>
</div>

<div class="row container">
    <div class="col s4">
        <blockquote class="color-primary-green">
            <h3 class="color-black">Topic Management</h3>
        </blockquote>
    </div>
    <div class="col s4"></div>
    <div class="col s4"></div>
</div>
<div class="row container">
    <pre>
        <?php //print_r($topic_holder); ?>
    </pre>
    <?php if (isset($year_holder) && !empty($year_holder)): ?>
        <table class="data-table" id="tbl-feedback"">
            <thead>
                <tr>
                    <th>Topic Name</th>
                    <th>Topic Description</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($topic_holder as $idkey => $subyear_holder): ?>
                    <tr class="bg-color-white">
                        <td><?=$subyear_holder->topic_list_name?></td>
                        <td><?=$subyear_holder->topic_list_description?></td>
                        <td><a data-id="<?= $idkey ?>" class="waves-effect waves-dark btn bg-primary-green btn_view_b">View</a></td>
                        <td><a class="waves-effect waves-dark btn bg-primary-yellow btn_edit_b">Edit</a></td>
                        <td><a class="waves-effect waves-dark btn red btn_delete_b">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <center style="margin-top:20vh;">
            <h3>No data to show</h3>
        </center>
    <?php endif; ?>
</div>

<div class="row container container1">
    <button class="waves-effect waves-dark btn green add_form_field">Add new field &nbsp;</button>
    <form method="post">
        <div class="row new_field_here">
            <div class="input-field row">
                <div class="col s12">
                    <label class="color-black" for="input_fields">Subject Area</label>
                    <input name="input_fields[]" type="text">
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $(".btn_view_a").click(function () {
            $data = $(this).data('id');
            window.location.href = "<?= base_url() . "SubjectArea/view/" ?>" + $data;
        });

    });
</script>
<script>
    $(document).ready(function() {
        var max_fields      = 10;
        var wrapper         = $(".new_field_here");
        var add_button      = $(".add_form_field");

        var x = 1;
        $(add_button).click(function(e){
            e.preventDefault();
            if(x < max_fields){
                x++;
            $(wrapper).append('<div class="input-field row"><div class="col s10"><label class="color-black" for="input_fields">Subject Area</label><input name="input_fields[]" type="text"></div><div class="col s2"><a href="#" class="waves-effect waves-dark btn red delete_field">Delete</a></div>'); //add input box
        } else {
          alert('You Reached the limits')
      }
  });

        $(wrapper).on("click",".delete_field", function(e){
            e.preventDefault(); $(this).parent('div').remove(); x--;
        });
    });
</script>