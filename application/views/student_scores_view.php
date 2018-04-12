<?php $this->load->view('includes/home-navbar'); ?>
<?php $this->load->view('includes/home-sidenav'); ?>


<div class="container row">
    <div class="col s1"></div>
    <div class="col s11">
        <div class="row">
            <blockquote class="color-primary-green">
                <h5 class="color-black">View Student Scores</h5>
            </blockquote>
        </div>
        <div class="row">
            <div class="col s12 m6"> 
                <div class="card bg-primary-green">
                    <div class="card-content white-text">
                        <span class="card-title">Long Quizzes</span>
                        <p> This contains all the uploaded scores of the students on their Long Quizzes </p>
                    </div>
                    <div class="card-action">
                        <a href="<?=base_url()?>Student_scores/view_dataScores/1" class="valign-wrapper"><i class="material-icons" style="padding-right: 2%;">visibility</i>View</a> 
                    </div>  
                </div>
            </div>
            <div class="col s12 m6"> 
                <div class="card bg-primary-green">
                    <div class="card-content white-text">
                        <span class="card-title">Short Quizzes</span>
                        <p> This contains all the uploaded scores of the students on their Short Quizzes </p>
                    </div>
                    <div class="card-action">
                        <a href="<?=base_url()?>Student_scores/view_dataScores/2" class="valign-wrapper"><i class="material-icons" style="padding-right: 2%;">visibility</i>View</a> 
                    </div>  
                </div>
            </div> 
        </div>    
        <div class="row">
            <div class="col s12 m6"> 
                <div class="card bg-primary-green">
                    <div class="card-content white-text">
                        <span class="card-title">Seatworks</span>
                        <p> This contains all the uploaded scores of the students on their Seatworks </p>
                    </div>
                    <div class="card-action">
                        <a href="<?=base_url()?>Student_scores/view_dataScores/3" class="valign-wrapper"><i class="material-icons" style="padding-right: 2%;">visibility</i>View</a> 
                    </div>  
                </div>
            </div>
            <div class="col s12 m6"> 
                <div class="card bg-primary-green">
                    <div class="card-content white-text">
                        <span class="card-title">Exam</span>
                        <p> This contains all the uploaded scores of the students on their Exams </p>
                    </div>
                    <div class="card-action">
                        <a href="<?=base_url()?>Student_scores/view_dataScores/4" class="valign-wrapper"><i class="material-icons" style="padding-right: 2%;">visibility</i>View</a> 
                    </div>  
                </div>
            </div> 
        </div>
    </div>
</div>
