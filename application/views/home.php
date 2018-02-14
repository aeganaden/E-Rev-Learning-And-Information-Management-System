<!--====================================
=            Navigation Top            =
=====================================-->

<?php $this->load->view('includes/home-navbar'); ?>


<!--====  End of Navigation Top  ====-->



<!-- 
<?php echo "<pre>" ?>
  <?php print_r($info) ?> -->
  <div class="row">
    <div class="row container">
      <div class="col s1">
        <?php $this->load->view('includes/home-sidenav'); ?>
      </div>
      <div class="col s11">
         <!--==========================================
        =            Announcement Section            =
        ===========================================-->

        <div class="col s4">
          <h4>Announcements</h4>
          <div class="row s12">

            <?php 
            
            $where = array(
              "announcement_is_active"=>1
            );
            $announcements = $this->Crud_model->fetch("announcement",$where);
            ?>
            <?php if ($announcements): ?>
              <?php foreach ($announcements as $key => $value): ?>
                <?php 
                $audience = explode(",",$value->announcement_audience);

                ?>
                <?php if (in_array($program, $audience)): ?>
                  <div class="card bg-primary-green">
                    <div class="card-content white-text">
                      <span class="card-title" style="text-transform: capitalize;"><?=$value->announcement_title?></span>
                      <p style="font-size: 80%" class="color-primary-yellow">Shown Until <?=date("M d, Y", $value->announcement_end_datetime)?></p>
                      <hr>
                      <p><?=$value->announcement_content?></p>
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

        </div>

        <!--====  End of Announcement Section  ====-->
      </div>
    </div>
  </div>