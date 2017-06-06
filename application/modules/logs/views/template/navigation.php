<nav class="navbar navbar-dark" style="background: #449DD1; border-bottom: 1px solid #fff;">
  <div class="container">
  <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"></button>
  <div class="collapse navbar-toggleable-md" id="navbarResponsive">
    <a class="navbar-brand" href="<?php echo base_url()?>" style="font-size:25px;"><span><img src="<?=base_url('assets/images/logo/people-link.ico')?>" style="height: 35px;"></span> <span style="color:#d2cac7;">jobfair-</span>online</a>
    <ul class="nav navbar-nav float-lg-right">
      <li class="nav-item active">
        <a class="nav-link" href="#">SEARCH JOBS</a>
      </li>
      <li class="nav-item dropdown">
        <a style="color:#fff;"class="nav-link dropdown-toggle" href="http://example.com" id="responsiveNavbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">REGISTER</a>
        <div class="dropdown-menu" id="registration-dropdown" aria-labelledby="responsiveNavbarDropdown">
          <a class="dropdown-item" href="<?php echo base_url('Registration/view_applicant_registration')?>"><span><i class="fa fa-user"></i></span> Applicant</a>
          <a class="dropdown-item" href="<?php echo base_url('Registration/view_employer_registration')?>"><span><i class="fa fa-briefcase"></i></span> Employer</a>
        </div>
      </li>
      <li class="nav-item active dropdown">
        <a class="nav-link" href="<?=base_url('authenticate/index')?>">SIGN-IN</a>
       
      </li>
    </ul>
  </div>
</div>
</nav>
