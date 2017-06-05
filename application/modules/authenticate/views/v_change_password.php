<div class="login-box w-md overlay-center">
	<div class="overlay bg-success w-sm fs-14">
		<label class="mb-0">Reset Password</label>
	</div>
	<div class="login-box-body">

		<form id="change-password-form">
			<?=form_hidden('token',$token) ?>

			<div class="form-group" style="padding-top: 2rem;">
				
				<input type="password" id="newPassword" name="newPassword" class="form-control no-border ph-center" placeholder="New Password" value="" required autofocus>
			</div>
			<div class="form-group" style="">
	
				<input type="password" name="confirmPassword" class="form-control no-border ph-center" placeholder="Confirm Password" value="" required autofocus>
			</div>
			<div class="form-group-btn">
				<button id="btn-reset-password" type="submit" name="btn-reset-password" class="btn btn-login">CONFIRM</button>
			</div>
		</form>

	</div>
</div>