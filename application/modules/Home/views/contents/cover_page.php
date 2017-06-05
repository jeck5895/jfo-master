
<div id="home" class="hero_container">
	<img src="<?=base_url('assets/images/banner/h_b1.png')?>" alt="JobFair-online banner">
	<div class="c-search-form-container">
		
		<form id="c-search-form" class="form-inline" role="form">
			<div class="col-md-8 c-input-container">
				<input type="text" name="c-keyword" placeholder="Search a job | a company | job by location" class="form-control form-control-lg" id="main-search">
			</div>
			<div class="col-md-3 c-input-container">
				<button type="submit" class="btn btn-info  btn-materialize btn-materialize-lg">
					<span class="btn-text hidden-sm-down">Search</span><span class="fa fa-search hidden-md-up"></span>
				</button>	
			</div>	
			
		</form>
		
	</div>
</div>

<div class="container">
	<div id="partners" class="partners">
		<h3 class="home-header-p">OUR TRUSTED PARTNERS</h3>
		<p> 
			Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
		</p>
	</div>
</div>
<div class="carousel-container">
	<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
		</ol>
		<div class="carousel-inner" role="listbox">
			<?php $counter = 0; $imagesTotal = count($sliderImages);?>
			<?php foreach($sliderImages as $slider):?>
				<?php $active = (($counter++ == 1)||($imagesTotal)==1)?"active":"";?>
				<div class="carousel-item <?=$active?>">
					<a href="<?=$slider['ads_url']?>" title="<?=$slider['ads_title']?>" target="_blank">
						<img class="d-block img-fluid" src="<?=$slider['path']?>" alt="<?=$counter;?> slide">
					</a>	
				</div>
			<?php endforeach;?>
		</div>
		<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
</div>
<div class="container">
	<div class="f-comp-logo">
		<?php foreach( $featuredCompanies AS $company):?>
			<div class="f-item">
				<a href="http://localhost/jobfair-online.com/companies/<?=$company['company']."-".$company['cid']?>" target="<?=$company['company']."-".$company['cid']?>">
					<img src="<?=$company['logo']?>" alt="<?=$company['company']?> logo" class="img-fluid">
				</a>	
			</div>
		<?php endforeach;?>	
	</div>

	<div id="about-us" class="about-us">
		<h2>About JobFair-Online.Net</h2>
		<hr>
		<div class="sub-header">
			<p class="sub-header">
				JobFair-Online.Net is a website for companies to post their job vacancies where Filipinos can apply, no matter what province they are in the Philippines.
			</p>
		</div>
		<div class="about-us-body">
			<p>
				We’re all about being one of the solution to solve the alarming ever-increasing unemployment rate in the country. We believe that it can be done one step at a time, but for now, we’ll start on providing a job portal that can be used by companies, agencies, local government units, enterprises to post their job vacancies for free and most importantly, for job seekers.
			</p>
		</div>
	</div>
</div>

<div class="home-tab-container">
	<ul class="nav nav-tabs nav-justified" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" data-toggle="tab" href="#jobseekers-tab" role="tab">WHAT'S IN IT FOR JOB SEEKERS?</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#employers-tab" role="tab">WHAT'S IN IT FOR EMPLOYERS?</a>
		</li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane active animated fadeInLeftBig" id="jobseekers-tab" role="tabpanel">
			<div class="tab1-content">
			<img src="<?=base_url('assets/images/forJobSeeker.png')?>" class="img-fluid">
			</div>
		</div>
		<div class="tab-pane animated fadeInRightBig" id="employers-tab" role="tabpanel">
			<div class="tab2-content">
				<img src="<?=base_url('assets/images/forRecruiter.png')?>" class="img-fluid">
			</div>
		</div>
	</div>
</div>	

<div class="container">
	<div id="contact-us" class="know-us">
		<h2>KNOW MORE ABOUT US</h2>
		<hr>
		<div class="row">
			<div class="col-md-6">
				<div class="contact-us">
					<h4>CONTACT US</h4>
					<hr>
					<ul class="list-unstyled">
						<li class="align-left">
							
							<i class="fa fa-envelope"></i>
							jobfair-onlineph@gmail.com
						</li>
						<li class="align-left">
						
							<i class="fa fa-phone"></i>
							(63)923-456-7890
						</li>
						<li class="align-left" id="address">
							<div class="icon-container">
								<i class="fa fa-map-marker maximize"></i> 
							</div>
							<div class="text-content">
								First Capitol Place Building First St. corner Philam St., Barangay Kapitolyo,, Pasig, 1603 Metro Manila
							</div>	
						</li>
					</ul>
					<div class="map-container">
						<?=$this->load->view('v_map_location')?>
					</div>	
				</div>
			</div>
			<div class="col-md-6">
				<div class="lets-talk">
					<h4>LET'S TALK</h4>
					<hr>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus efficitur accumsan ante nec sagittis. Cras fermentum sollicitudin orci vitae hendrerit. Integer sollicitudin dignissim ex id scelerisque. Aenean quis porttitor enim. Quisque porttitor augue ut velit accumsan, nec blandit ligula mattis.
					</p>
					
					<div class="form-group">
						<input type="text" name="sender-name" class="form-control effect-2" placeholder="Your name">
						<span class="focus-border"></span>
					</div>
					<div class="form-group">
						<input type="text" name="sender-email" class="form-control effect-2" placeholder="Your Email">
						<span class="focus-border"></span>
					</div>
					<div class="form-group">
						<input type="text" name="sender-subject" class="form-control effect-2" placeholder="Subject">
						<span class="focus-border"></span>
					</div>
					<div class="form-group">
						<textarea class="form-control effect-2" name="concerns" placeholder="What do you want to know?"></textarea>
						<span class="focus-border"></span>
					</div>
					<div class="form-group">
					<button id="send-message" class="btn btn-materialize btn-info">Send message</button>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>