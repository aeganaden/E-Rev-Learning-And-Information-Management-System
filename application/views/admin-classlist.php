
<div class="row">
  <div class="col s8">
    <blockquote class="color-primary-green">
      <h3 class="color-black">Lecturer's Class List</h3>

    </blockquote>

  </div>

</div>
<ul class="collapsible popout" data-collapsible="accordion">
  <?php foreach ($offering as $key => $value): ?>
    <?php 
    $student = $this->Crud_model->fetch("student",array("offering_id"=>$value->offering_id));
    ?>
    <li>
      <div class="collapsible-header  bg-primary-green color-white"><i class="material-icons">people_outline</i><?=$value->offering_section?></div>
      <div>
       <table id="tbl-card-lcl" style="padding: 2%;">
        <thead >
          <tr>
            <th>Student ID</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Program</th>
            <th>Email</th>
          </tr>
        </thead>

        <tbody class="bg-color-white">
          <?php foreach ($student as $key => $value_inner): ?>
            <tr class="bg-color-white">
              <td><?= $value_inner->student_id ?></td>
              <td><?= ucwords($value_inner->student_firstname) ?></td>
              <td><?= ucwords($value_inner->student_midname) ?></td>
              <td><?= ucwords($value_inner->student_lastname) ?></td>
              <td><?= strtoupper($value_inner->student_program) ?></td>
              <td><?=$value_inner->student_email?></td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </li>
<?php endforeach ?>
</ul>