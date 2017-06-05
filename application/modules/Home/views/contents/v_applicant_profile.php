<?php $var = explode("/",$_SERVER['PATH_INFO']); $isMe = explode("-",$var[2]);?>
<div class="container">
	<div class="col-md-10 offset-md-1">
		<div class="c-profile-box">
			<div class="profile-box-header">
				<div class="profile-img-overlay">
					<img id="profile-image" src="" class="img-fluid img-circle">
					<a data-toggle="modal" data-target="#uploadModal" class="">
						<img src="<?=base_url('assets/images/app/img_frame.png')?>" class="img-fluid upload-frame-overlay">
					</a>    
				</div>
			</div>
			<div class="profile-box-body">
				<div class="btn-box">
					<a href="<?=site_url('applicant/resume')?>" class="btn btn-secondary btn-materialize">View Resume</a>
				</div>
				<div class="profile-name">
					<h5 id="applicant-name"></h5>
					<p id="degree"></p>
				</div>  

				<div class="profile-information-box">

					<div class="information-content">

						<div class="info-ico-box">
							<img src="<?=base_url('assets/images/app/contact_info.png')?>" class="">
						</div>

						<div class="info-header">
							<h6>CONTACT INFORMATION</h6>

							<div class="info-body">
								<p id="mobile"></p>
								<label class="text-muted">Mobile</label>

								<p id="email"></p>
								<label class="text-muted">Email</label>

								<p id="address"></p>
								<label class="text-muted">Address</label>
							</div>
						</div>   

					</div>

					<hr>

					<div class="information-content">

						<div class="info-ico-box">
							<img src="<?=base_url('assets/images/app/personal_details.png')?>" class="">
						</div>

						<div class="info-header">
							<h6>PERSONAL DETAILS</h6>

							<div class="info-body">
								<dl class="row"> 
									<div class="col-md-3"> <label class="text-muted"> Age </label></div>
									<div class="col-md-9"> <p id="age"></p></div>

									<div class="col-md-3"><label class="text-muted">Civil Status</label></div>
									<div class="col-md-9"><p id="c-status"></p></div>

									<div class="col-md-3"> <label class="text-muted">Birthdate </label></div>
									<div class="col-md-9"><p id="birthdate"></p></div>

									<div class="col-md-3"> <label class="text-muted">Gender </label></div>
									<div class="col-md-9"><p id="gender"></p></div>

									<div class="col-md-3"> <label class="text-muted">Home Address </label></div>
									<div class="col-md-9"><p id="home-address"></p></div>
								</dl>
							</div>
						</div>   

					</div>

					<div class="information-content" id="education-box"></div>
					  

					
					<div class="information-content" id="work-history"></div>
					
				</div>
			</div>
		</div>
	</div>
</div>    

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/dropzone.js');?>"></script>
<script type="text/javascript" src="<?=base_url('assets/js/appProf.js')?>"></script>