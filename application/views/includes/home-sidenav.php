
<!--======================================
=            Side-Nav Section            =
=======================================-->

<?php
$ident = $info['identifier'];
$ident.="_department";
$program = "";

switch ($info['user']->$ident) {
    case 'CE':
    $program = "Civil Engineering";
    break;
    case 'EE':
    $program = "Electrical Engineering";
    break;
    case 'ECE':
    $program = "Electronics and Computer Engineering";
    break;
    case 'ME':
    $program = "Mechanical Engineering";
    break;

    default:
        # code...
    break;
}
// echo "<pre>";
// print_r($info);
?>

<ul id="slide-out" class="side-nav bg-color-white fixed">
    <li><div class="user-view">
        <div class="background" style="background-color: #F2A900">

        </div>
        <div class="row valign-wrapper" style="margin-bottom: 0px !important">
            <div class="col s2">
                <div class="row" style="margin-bottom: 0 !important">
                    <a href="#!user"><img style=" object-fit: cover;" class="circle" src="<?= base_url() ?>assets/img/profiles/profile.jpg "></a>
                </div>
            </div>
            <div class="col s2"></div>
            <div class="col s8">
                <div class="row " style="margin-bottom: 0 !important">
                    <h5><span class="color-black"><?= ucwords($info["user"]->firstname) . " " . ucwords($info["user"]->lastname) ?></span></h5>
                </div>
            </div>
        </div>
        <div class="row" style="margin-bottom: 0px !important">
            <blockquote class="color-primary-green">
                <h5 class="color-black"><?= $info["identifier"] != 'fic' ? strtoupper($info["identifier"]) : "FACULTY IN CHARGE" ?></h5>
            </blockquote>
        </div>
        
        <div class="row" style="margin-top: 0px !important; border-bottom: 2px solid #007A33;">

        </div>
        <div class="row">
            <?php   
            if ($info['identifier']!="professor" && $info['identifier']!="fic") {
                $section = $this->Crud_model->fetch("offering",array("offering_id"=>$info['user']->offering_id));
                $section = $section[0];
            }
            ?>
            <blockquote class="color-primary-green" style="margin: 0">
                <h5 class="color-black" >ABOUT</h5>
            </blockquote>
            <h6  style="text-transform: capitalize; margin: 0; margin-left: 10%;" class="color-black valign-wrapper" ><i class="material-icons color-primary-green">chevron_right</i><?=$program?></h6>
            <?php if ($info['identifier']!="professor"&& $info['identifier']!="fic"): ?>
                <h6  style="text-transform: capitalize; margin: 0; margin-left: 10%;" class="color-black valign-wrapper" ><i class="material-icons color-primary-green">chevron_right</i><?=$section->offering_name?></h6>
            <?php endif ?>

        </div>
        <div class="row">
            <!-- <a href="#!email"><span class="color-black"><?= $info["user"]->email ?></span></a> -->
        </div>
    </div></li>
    <li class="<?=$s_h?>">
        <a clas href="<?= base_url() ?>Home" class="color-black"><i class="material-icons color-black">home</i>Home</a> <!--mark - naglagay-->
    </li>
    <?php if ($info["identifier"] == "fic"): ?>
        <li class="color-black <?= $s_a ?>">
            <a href="<?= base_url() ?>Home/Activity" class="color-black"><i class="material-icons color-black">remove_from_queue</i>Activity</a>
        </li>
    <?php endif ?>

    <?php if ($info["identifier"] == "student"): ?>
        <li class="color-black <?= $s_c ?>">
            <a href="<?= base_url() ?>Coursewares" class="color-black"><i class="material-icons color-black">book</i>Coursewares</a>
        </li>
    <?php endif ?>
    <li class="<?= $s_f ?>">
        <a href="<?= base_url() ?>feedback" class=" color-black"><i class="material-icons color-black">feedback</i>Feedback</a> <!--mark - naglagay-->
    </li>
    <li>
        <div class="divider"></div>
    </li>
    <li>
        <a class="waves-effect color-black" href="<?= base_url() ?>Login/logout ">Log Out</a>
    </li>
</ul>


<!--====  End of Side-Nav Section  ====-->