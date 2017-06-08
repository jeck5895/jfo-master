<?php if(isset($_COOKIE['_typ']) && $_COOKIE['_typ'] == "ap"):?>
	<?php $this->load->view('template/v_home_sidebar')?>
<?php endif?>

<?php
	if(isset($_GET['vt']) && $_GET['vt'] == "jobs-by-location"){
		$this->load->model('api/admin_model');
		$region_id = $_GET['reg'];
		$query2 = $this->admin_model->getFeaturedJobsByLocation($id = FALSE, $region_id);
		$featuredJobsByLocation = array();

		foreach ($query2 as $fjob) {
			$featuredJobsByLocation[] = array(
				"company" => $fjob->company_name,
				"position" => ($fjob->use_alternative == 1)? $fjob->alternative_title:$fjob->job_position,
				"job" => $fjob->job_description,
				"url" => site_url('jobs/details/'.str_replace("+","-",urlencode(ucfirst($fjob->job_position))).'-/'.$this->my_encrypt->encode($fjob->job_id)),
				"company_url" => site_url('companies/'.str_replace("+","-",urlencode(ucfirst($fjob->company_name))).'-'.$fjob->company_id),
				"description" => $fjob->job_description,
				);
		}
	}
?>

<div class="content-wrapper-home">
	<section class="content-header">

	</section>
	<section class="content">
		<?php $bool = ($this->session->userdata('active_employer')!=NULL)? 1: 0;?>
		<input type="hidden" name="boolean" value="<?=$bool?>">
		
			<div class="row d-filter-container">
				<div class="col-md-3 d-filter-group">
					<select name="filter-category" class="form-control">
						<option value="" class='select-placeholder'>Search Job via Category</option>
					</select>
				</div>
				<div class="col-md-3 d-filter-group">
					<select name="filter-location" class="form-control province">
						<option></option>
					</select>
				</div>
				<div class="col-md-4 d-filter-group">
					<input type="search" id="search-jobs" class="form-control" name="search" placeholder="Search Job">	
				</div>
				<div class="col d-filter-group">
					<button type="button" id="btn-i-search" class="btn btn-info btn-materialize form-control ripple">SEARCH</button>
				</div>
			</div>
			<div class="clear-filter-box">
				<div class="ckb-box pull-top-right">
					<small>
					<a href="" id="btn-clear-filter" onclick="return false;" class="fs-11 text-bold">CLEAR FILTER </a>
					</small>
				</div> 
			</div>
		<label id="total-jobs" class="header"> </label>
		<div class="row">

			<div class="job-container">
				
				<?php if(isset($_GET['vt']) && $_GET['vt'] == "jobs-by-location"):?>
					<?php if(count($featuredJobsByLocation) != 0):?>
				
						<div class="box box-widget">
							<div class="box-header py-2">
								<h6 class="header mb-0">Featured jobs in <?=urldecode($_GET['location']);?></h6>
							</div>
							<div class="box-body py-1">
								<div class="row">

									<?php $counter=0;?>		

									<?php foreach($featuredJobsByLocation AS $job):?>

										<?php $counter++;?>

										<div class="col-md-3">

											<div class="py-2 acc-header">	
												<a data-toggle="collapse" href="#collapseSidebar<?=$counter?>" aria-expanded="false" aria-controls="collapseSidebar" class="">
													<i class="fa fa-plus pos-right fc-grey" style="top:25px;"></i>
												</a>
												<a class="fs-13 text-bold text-upper mb-0" href="<?=$job['url']?>" target="<?=$job['url']?>"><?=$job['position']?></a>
												<p class="fs-12"><a href="<?=$job['company_url']?>" target="<?=$job['company_url']?>"><?=$job['company']?></a></p>
												<div class="collapse" id="collapseSidebar<?=$counter?>">
													<div class="card card-block fs-13">
														<?=$job['description']?>
														<a href="<?=$job['url']?>" class="text-center" target="<?=$job['url']?>">See more</a>
													</div>
												</div>
											</div>	
										</div>
									<?php endforeach;?>	
								</div>
							</div>
						</div>
					<?php endif;?>		
				<?php else:?>
					<div class="box box-widget">
						<div class="box-header py-2">
							<h6 class="header mb-0">Featured jobs</h6>
						</div>
						<div class="box-body py-1">
							<div class="row">
								<?php $counter=0;?>		
								<?php foreach($featuredJobs AS $job):?>
									
									<?php $counter++;?>
									<div class="col-md-3">
										
										
										<div class="py-2 acc-header">	
											<a data-toggle="collapse" href="#collapseSidebar<?=$counter?>" aria-expanded="false" aria-controls="collapseSidebar" class="">
												<i class="fa fa-plus pos-right fc-grey" style="top:25px;"></i>
											</a>
											<a class="fs-13 text-bold text-upper mb-0" href="<?=$job['url']?>" target="<?=$job['url']?>"><?=$job['position']?></a>
											<p class="fs-12"><a href="<?=$job['company_url']?>" target="<?=$job['company_url']?>"><?=$job['company']?></a></p>
											<div class="collapse" id="collapseSidebar<?=$counter?>">
												<div class="card card-block fs-13">
													<?=$job['description']?>
													<a href="<?=$job['url']?>" class="text-center" target="<?=$job['url']?>">See more</a>
												</div>
											</div>
										</div>	
									</div>
								<?php endforeach;?>	
							</div>
						</div>
					</div>	
				<?php endif;?>	

				
				
				<div id="jobs-container">

				</div>
				<div class="pagination-box">
					<p id="jobs-pagination"></p>
				</div>		
			</div>

			<?php $this->load->view('template/v_ads_box')?>
		</div>
	</section>
</div>	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url('assets/js/index.js')?>"></script>