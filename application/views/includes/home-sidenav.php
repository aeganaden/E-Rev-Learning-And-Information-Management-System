
<!--======================================
=            Side-Nav Section            =
=======================================-->

<ul id="slide-out" class="side-nav bg-primary-green">
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
    <?php if ($info["identifier"] == "fic"): ?>
        <li class="color-white">
            <a href="<?= base_url() ?>Home/Activity" class="color-white"><i class="material-icons color-white">remove_from_queue</i>Activity</a>
        </li>
    <?php endif ?>
    <li>
        <a href="<?= base_url() ?>Home" class=" color-white"><i class="material-icons color-white">home</i>Home</a> <!--mark - naglagay-->
    </li>
    <li>
        <a href="<?= base_url() ?>feedback" class=" color-white"><i class="material-icons color-white">feedback</i>Feedback</a> <!--mark - naglagay-->
    </li>
    <li>
        <div class="divider"></div>
    </li>
    <li>
        <a class="subheader">Subheader</a>
    </li>
    <li>
        <a class="waves-effect color-white" href="<?= base_url() ?>Login/logout ">Log Out</a>
    </li>
</ul>


<!--====  End of Side-Nav Section  ====-->