
<div class="row">
  <div class="col s8">
    <blockquote class="color-primary-green">
      <h3 class="color-black">Lecturer's Class List</h3>

    </blockquote>

  </div>

</div>

<div class="row">
  <div class="col s2">
    <div class="row">
      <div class="card bg-primary-yellow">
        <div class="card-content white-text">
          <span class="card-title color-black" style="text-transform: uppercase;">Sections</span>
          <?php if ($schedule): ?>
            <?php foreach ($schedule as $key => $value): ?>
              <a href="javascript:showonlyone('<?=$value->offering_section?>');" >
               <button class="btn bg-primary-green " style="margin-bottom: 5%;" o>
                <i class="material-icons left ">play_arrow</i><?=$value->offering_section?>
              </button>
            </a>
          <?php endforeach ?>
        <?php else: ?>
          <h5>No Section Assigned</h5>
        <?php endif ?>
      </div>
    </div>
  </div>
</div>
<div class="col s10">
  
  <?php if ($schedule): ?>
    <?php $x = 1;
    ?> 
    <?php foreach ($schedule as $key => $value): ?>
      <?php   $display = $x == 1 ? "block" : "none"; ?>
      <?php 
      $student = $this->Crud_model->fetch("student",array("offering_id"=>$value->offering_id));
      ?>
      <div class="row div_section " id="<?=$value->offering_section?>" style="display: <?=$display?>;">
        <ul class="collapsible popout " data-collapsible="accordion">
          <li>
            <div class="collapsible-header  bg-primary-green color-white"><i class="material-icons">people_outline</i><?=$value->offering_section?></div>
            <div>
             <table id="tbl-<?=$value->offering_section?>" class="data-table" style="padding: 2%;">
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
                    <td><?= $value_inner->student_num ?></td>
                    <td><?= ucwords($value_inner->firstname) ?></td>
                    <td><?= ucwords($value_inner->midname) ?></td>
                    <td><?= ucwords($value_inner->lastname) ?></td>
                    <td><?= strtoupper($value_inner->student_department) ?></td>
                    <td><?=$value_inner->email?></td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </li>
      </ul>
    </div>
    <?php $x++; ?>
    <script>
      $('#tbl-<?=$value->offering_section?>').DataTable();
    </script>
  <?php endforeach ?>
<?php endif ?>
</div>
</div>
