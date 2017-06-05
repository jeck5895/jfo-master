<div class="login-box w-md overlay-center">
	<div class="overlay bg-red w-sm fs-14">
		<label class="mb-0">Forgot password?</label>
	</div>
	<div class="login-box-body">

		<form id="recovery-form">
			<?=form_hidden('token',$token) ?>

			<div class="form-group" style="padding-top: 1.5rem;">
				<label class="fc-grey fs-14 text-center">Enter your email address and we'll send you a recovery link</label>
				<input type="email" name="email" class="form-control no-border ph-center" placeholder="Email" value="" required autofocus>
			</div>
			<div class="form-group-btn">
				<input type="submit" name="btn-confirm-email" value="CONFIRM" class="btn btn-login" >
			</div>
		</form>

	</div>
</div>