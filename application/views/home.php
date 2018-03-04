<!--====================================
=            Navigation Top            =
=====================================-->

<?php $this->load->view('includes/home-navbar'); ?>


<!--====  End of Navigation Top  ====-->


<?php $this->load->view('includes/home-sidenav'); ?>
<!--
<?php echo "<pre>" ?>
  <?php print_r($info) ?> -->
  <div class="row">
    <div class="row">
         <!--==========================================
        =            Announcement Section            =
        ===========================================-->

        <div class="col s4">
          <blockquote class="color-primary-green">

            <h5 class="color-black">Announcement </h5>
          </blockquote>

          <?php
          $where = array(
            "announcement_is_active" => 1
          );
          $announcements = $this->Crud_model->fetch("announcement", $where);
          ?>
          <?php if ($announcements): ?>
            <?php foreach ($announcements as $key => $value): ?>
              <?php
              $audience = explode(",", $value->announcement_audience);
              $str_aud = '';
              ?>
              <?php if (in_array($program, $audience)): ?>
                <div class="card bg-primary-green">
                  <div class="card-content white-text">
                    <h5  style="text-transform: capitalize;"><?= $value->announcement_title ?></h5>
                    <p style="font-size: 80%" class="color-primary-yellow">Created at <?= date("M d, Y", $value->announcement_created_at) ?> | Shown Until <?= date("M d, Y", $value->announcement_end_datetime) ?></p>
                    <p style="font-size: 80%">Audience  
                      |
                      <?php foreach ($audience as $key => $i_value): ?>
                        <?php switch ($i_value) {
                          case '1':
                          $str_aud = 'CE';
                          break;
                          case '2':
                          $str_aud = 'EEE';
                          break;
                          case '3':
                          $str_aud = 'EE';
                          break;
                          case '4':
                          $str_aud = 'ME';
                          break;
                          
                          default:
                            # code...
                          break;
                        } ?>
                        <span><?= $str_aud." |" ?></span>
                      <?php endforeach ?>
                    </p>
                    <hr>
                    <p><?= $value->announcement_content ?></p>
                  </div>
                </div>
              <?php else: ?>
                <?php echo $program ?>
                <div class="card bg-primary-green">
                  <div class="card-content">
                    <h5 class="center color-white">No Announcement Yet</h5>
                  </div>
                </div>
              <?php endif ?>

            <?php endforeach ?>
          <?php else: ?>
            <div class="card bg-primary-green">
              <div class="card-content">
                <h5 class="center color-white">No Announcement Yet</h5>
              </div>
            </div>
          <?php endif ?>


        </div>

        <!--====  End of Announcement Section  ====-->
        <div class="col s8">
         <blockquote class="color-primary-green">
          <h5 class="color-black">Activities </h5>
        </blockquote>
        <div class="row">
          <?php 
          $activity = $this->Crud_model->fetch("activity",array("offering_id"=>$info['user']->offering_id,"activity_status"=>1));
          ?>
          <?php if ($activity): ?>
            <?php $x = 1; ?>
            <?php foreach ($activity as $key => $value): ?>
              <?php 
              $details = $this->Crud_model->fetch("activity_details", array("activity_details_id"=>$value->activity_details_id));
              $details = $details[0];
              $schedule = $this->Crud_model->fetch("activity_schedule",array("activity_schedule_id"=>$value->activity_schedule_id));

              $schedule = $schedule[0];
              $date = $schedule->activity_schedule_date;
              $now = time();

              if($date < $now) {
               $this->Crud_model->update("activity",array("activity_status"=>0),array("activity_id"=>$value->activity_id));
             } 
             ?>
             <?php if ($x == 2) { echo '<div class="row">';} ?>

              <div class="card bg-primary-green col s8" style="margin-left: 10%;">
                <div class="card-content white-text">
                  <div class="row" style="margin-bottom: 0 !important;">
                    <div class="col s8">
                      <blockquote class="color-primary-yellow">
                        <span class="card-title color-white"><?=$details->activity_details_name?> 
                        </span>
                        <?php 
                        $lecturer = $this->Crud_model->fetch("lecturer",array("lecturer_id"=>$value->lecturer_id));
                        $lecturer = $lecturer[0];
                        $name_l = ucwords($lecturer->firstname." ". $lecturer->lastname);
                        ?>
                        <h5><?=$name_l?></h5>
                        <p> 
                          <?=date("M d, Y", $schedule->activity_schedule_date)?> |
                          <?=date("h:i A", $schedule->activity_schedule_start_time)?> -
                          <?=date("h:i A", $schedule->activity_schedule_end_time)?>
                        </p>
                        <p><?=strtoupper($value->activity_venue)?></p>
                      </blockquote>
                    </div>
                  </div>
                  <h5 style="display: block;" class="activity_paragraph_desc<?=$value->activity_id?> a-roboto-cond"><?=$value->activity_description?></h5>
                </div>
              </div>
              <?php if ($x == 2) { echo '</div">';} ?>
              <?php $x++; ?>
            <?php endforeach ?>
          <?php else: ?>
            <h5 class="center">NO ACTIVITY YET</h5>
          <?php endif ?>
        </div>
      </div>
    </div>