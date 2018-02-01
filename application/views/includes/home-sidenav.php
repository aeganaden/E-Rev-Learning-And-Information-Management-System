
<!--======================================
=            Side-Nav Section            =
=======================================-->

<ul id="slide-out" class="side-nav bg-color-white">
    <li><div class="user-view">
        <div class="background bg-primary-yellow">

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
                <h5><?= $info["identifier"] != 'fic' ? strtoupper($info["identifier"]) : "FACULTY IN CHARGE"?></h5>
            </blockquote>
        </div>
        <div class="row">
            <a href="#!email"><span class="color-black"><?= $info["user"]->email ?></span></a>
        </div>
    </div></li>
    <li class="<?=$s_h?>">
        <a clas href="<?= base_url() ?>Home" class="color-black"><i class="material-icons color-black">home</i>Home</a> <!--mark - naglagay-->
    </li>
    <?php if ($info["identifier"] == "fic"): ?>
        <li class="color-black <?=$s_a?>">
            <a href="<?= base_url() ?>Home/Activity" class="color-black"><i class="material-icons color-black">remove_from_queue</i>Activity</a>
        </li>
    <?php endif ?>
    <?php if ($info["identifier"] == "student"): ?>
        <li class="color-black <?=$s_c?>">
            <a href="<?= base_url() ?>Coursewares" class="color-black"><i class="material-icons color-black">book</i>Coursewares</a>
        </li>
    <?php endif ?>
    <li class="<?=$s_f?>">
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