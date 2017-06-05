
<div class="login-box">
	<div class="login-box-body">
		<form id="login-form">
			<?=form_hidden('token',$token) ?>

			<div class="form-group" style="padding-top: 2.5rem;">
				
				<div class="username-label">
					<img src="<?=base_url('assets/images/app/user-ico.png')?>" class="img-fluid">
				</div>
				<input type="text" name="username" class="form-control no-border ph-center" placeholder="Email or Phone" value="" required autofocus>
			</div>
			<div class="form-group">
				<div class="password-label">
					<img src="<?=base_url('assets/images/app/password-ico.png')?>" class="img-fluid">
				</div>
				<input type="password" name="password" class="form-control no-border ph-center" placeholder="Password" required>
				<small><a class="text-bold" href="<?=base_url('accounts/recovery')?>">Forgot Password ?</a></small>

			</div>	
			<div class="form-group-btn">
				<input type="submit" name="login" value="Sign in" class="btn btn-login" >
			</div>
		</form>

		<div class="form-group">
			<span class="google-label">
				<i class="fa fa-google-plus"></i>
			</span>
			<a href="<?=$google_login_url ?>" class="btn btn-block btn-google">Sign in with Google</a>
		</div>

		<div class="form-group">
			<span class="facebook-label">
				<i class="fa fa-facebook-official"></i>
			</span>
			<a href="<?=$fb_login_url ?>" onclick="window.open(this.href,'targetWindow', 'toolbar=no, location=no, status=no, menubar=no, scrollbars=yes, resizable=yes,  width=500, height=500').moveTo(450,150);return false;" class="btn btn-block btn-facebook">Sign in with Facebook</a>
		</div>
		
		<center>

			<small id="emailHelp" class="form-text text-muted">Register as <a href="<?php echo base_url('registration/employer')?>">Employer</a> or <a href="<?php echo base_url('registration/job-seeker')?>">Job Seeker</a> now!
			</small>
		</center>
		
	</div>
	<div class="login-box-footer">

	</div>	
</div>

