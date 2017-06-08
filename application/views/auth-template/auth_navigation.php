<nav class="navbar navbar-toggleable-sm navbar-light dark-faded">
			<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<a class="navbar-brand" href="<?=base_url('/#home')?>">
				<div class="navbar-brand-logo">
					<img class="" src="<?=base_url('/assets/images/logo/jfo_logo_nav.png')?>" alt="JobFair-online Logo" />
				</div>    
			</a>

			<div class="collapse navbar-collapse" id="navbarTogglerDemo02">
				<div class="navbar-nav mr-auto"></div>
				<ul class="navbar-nav my-2 my-lg-0">
					<li class="nav-item">
						<a class="nav-link" href="<?=base_url('/#home')?>">HOME</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?=site_url('jobs')?>">SEARCH JOBS</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							REGISTER
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" href="<?php echo base_url('registration/job-seeker')?>">
								Job Sekeer
							</a>
							<a class="dropdown-item" href="<?php echo base_url('registration/employer')?>">
								Employer
							</a>
						</div>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?=base_url('login')?>">SIGN-IN</a>
					</li>
				</ul>
			</div>
		</nav>
