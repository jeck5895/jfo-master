<?php if(isset($_COOKIE['_typ']) && $_COOKIE['_typ'] == "ad"):?>
    <nav class="navbar navbar-toggleable-sm navbar-light bg-dark"> 
<?php elseif(isset($_COOKIE['_typ']) && $_COOKIE['_typ'] == "ep"):?>
    <nav class="navbar navbar-toggleable-sm navbar-light bg-purple"> 
<?php else:?>
    <nav class="navbar navbar-toggleable-sm navbar-light bg-default">
<?php endif;?>    
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="<?=((isset($_COOKIE['_typ']) && $_COOKIE['_typ'] == 'ap') || !isset($_COOKIE['_typ']))? base_url('/#home'): base_url(''); ?>">
        <div class="navbar-brand-logo">
            <img class="" src="<?=base_url('/assets/images/app/JFO Logo_White.png')?>" alt="JobFair-online Logo" />
        </div>    
    </a>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <div class="navbar-nav mr-auto"></div>
        <ul class="default navbar-nav my-2 my-lg-0">
            <?php if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'] && $_COOKIE['_typ'] == "ap"):?>
        
                <li class="nav-item dropdown">
                    <a href="" class="nav-link" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">    <span class="nav-notification fa fa-flag-o"> 
                            <span id="notif-badge" class="badge-sm badge badge-pill badge-danger badge-nav-notif" style="display: none;">0</span>    
                        </span> 
                    </a>

                   <!--  <ul id="notif-list" class="dropdown-menu dropdown-notif top-navigation dropdown-default" aria-labelledby="responsiveNavbarDropdown">
                        <li class="dropdown-item text-center"><label class="fs-11 text-bold">No notifications for now</label></li>
                    </ul> -->
                    <div class="dropdown-menu dropdown-notif">
                        <div class="box-header with-border py-1">
                            <p class="text-bold">Notifications</p>
                        </div>
                        <div class="box-body py-0 px-0" id="notif-list">
                            
                        </div>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php  $firstname = strtolower($user->first_name);  $lastname = strtolower($user->last_name);
                            echo ucfirst($firstname) ." ". ucfirst($lastname);
                        ?>
                    </a>
                    <ul class="dropdown-menu top-navigation dropdown-default" aria-labelledby="responsiveNavbarDropdown">
                        <li>
                            <a class="dropdown-item" href="<?php echo base_url('applicant/applications/pending')?>"> Applications</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo base_url('applicant/profile')?>"> My Profile</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo base_url('applicant/account/settings')?>"> Account Settings</a>
                        </li>
                        <li>
                            <a id="logout" class="dropdown-item" href="#" >  Sign-out</a>
                         
                        </li>
                    </ul>
                </li>

            <?php elseif(isset($_COOKIE['_typ']) && $_COOKIE['_typ'] == "ep"):?>
                <li class="nav-item active dropdown">

                    <a class="nav-link nav-link-purple dropdown-toggle" href="" id="responsiveNavbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php 
                        echo ucfirst($user->company_name);
                        ?>
                    </a>
                    <ul class="dropdown-menu top-navigation dropdown-purple" aria-labelledby="responsiveNavbarDropdown">
                        <li>
                            <a class="dropdown-item" href="<?php echo base_url('co/profile/settings')?>">Account Settings</a>
                        </li>

                        <li>
                            <a id="logout" class="dropdown-item" href="#">  Sign-out</a>
                        </li>
                    </ul>
                </li>
            <?php elseif(isset($_COOKIE['_typ']) && $_COOKIE['_typ'] == "ad"):?>
                <li class="nav-item active dropdown">

                    <a class="nav-link nav-link-purple nav-link-dark dropdown-toggle" href="" id="responsiveNavbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <?php $fname = strtolower($user->first_name); $mname = strtolower($user->middle_name); $lname = strtolower($user->last_name);?>
                         <?=ucfirst($fname) ." ". ucfirst($mname[0])."."." ". ucfirst($lname)?>
                    </a>
                    <ul class="dropdown-menu top-navigation dropdown-dark" aria-labelledby="responsiveNavbarDropdown">
                        <li>
                            <a class="dropdown-item" href="<?php echo base_url('admin/dashboard')?>"> Dashboard</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo base_url('admin/review/jobs')?>">Review Job Post</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo base_url('admin/review/applicants')?>">Applicants</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo base_url('admin/review/applicants')?>">Reports</a>
                        </li>
                        <li>
                            <a id="logout" class="dropdown-item" href="#">  Sign-out</a>
                        </li>
                    </ul>
                </li>
            <?php else:?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        REGISTER
                    </a>
                    <div class="dropdown-menu dropdown-default" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="<?php echo base_url('registration/job-seeker')?>">
                            Job Seeker
                        </a>
                        <a class="dropdown-item" href="<?php echo base_url('registration/employer')?>">
                            Employer
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=base_url('login')?>">SIGN-IN</a>
                </li>            
            <?php endif;?>        
        </ul>
    </div>
</nav>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript">
    var path = window.location.pathname;
    var seg = path.split('/');  
    var App = {
        
        pathUrl : window.location.protocol + "//" + window.location.host + "/" + seg[1],
        apiUrl : window.location.protocol + "//" + window.location.host +"/"+seg[1]+"/api"
    }
    $(document).on("click", "a#logout", function(){
        $.ajax({
            url: App.pathUrl +'/api/auth/logout',
            type: "POST",
            success:function(data){

                $.ajax({
                    url: App.pathUrl +'/api/auth/destroy',
                    type: "POST",
                    success:function(data){
                        window.location = App.pathUrl + '/login';
                    }
                }); 
            }
        });
    });

</script>