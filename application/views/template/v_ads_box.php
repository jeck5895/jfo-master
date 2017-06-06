<?php
    $this->load->model('api/admin_model');
    $this->load->model('api/job_post_model');
    $this->load->model('api/location_model');
    $this->load->library('my_encrypt');

    $sliderImages = array();
    $featuredCompanies = array();
    $query = $this->admin_model->getAdvertisementSlider();
    $companies = $this->admin_model->getFeaturedCompanies();
    $locations = $this->location_model->get();
    
    foreach($query as $image)
    {
        $sliderImages[] = array(
            "path" => base_url().str_replace("./", "", $image->upload_path)."/".$image->filename,
            "ads_url" => $image->ads_url,
            "ads_title" => $image->ads_title,
            "company" => $image->company_name,
            );
    }

    foreach($companies as $company)
    {
        $featuredCompanies[] = array(
            "logo" => base_url().str_replace("./", "", $company->profile_pic),
            "company" => $company->company_name,
            "location" => $company->city_name.", ".$company->region_name,
            "industry" => $company->industry_name,
            "industry_id" => $company->industry,
            "prov_id" => $company->province_1,
            "city_id" => $company->city_1,
            "cid" => $company->cid
            );
    }

?>
<div class="ads-container" style="">
    <div class="box-slider">
        <div class="mini-carousel-container">
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
                    <span class="carousel-control-prev-icon-sm" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon-sm" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="box-slider-body">
            <h6>JObFair-Online.Net is a Free Website</h6>
        </div>
    </div>

    <div class="box box-widget featured-companies-box">
        <div class="box-header with-border">
            <h6 class="registration-title">FEATURED COMPANIES</h6>
        </div>
        <div class="box-body">

            <?php foreach( $featuredCompanies AS $company):?>

                <div class="featured-companies-list px-0">
                    <div class="logo-box-mini">
                        <img src="<?=$company['logo']?>" alt="<?=$company['company']?> logo" class="img-fluid">
                    </div>
                    <div class="featured-companies-description">
                        <?php $comp_url  = site_url('companies/'.str_replace("+","-",urlencode(ucfirst($company['company']))).'-'.$company['cid']);?>
                        <a href="<?=$comp_url?>" target="<?=$comp_url?>">
                            <small>
                                <strong><?=$company['company']?></strong>
                            </small>
                        </a>
                        <p class="featured-companies-industry"><small><?=$company['industry']?></small></p>
                        <p><small><?=$company['location']?></small></p>
                    </div>
                </div>

            <?php endforeach;?>

        </div>
        <div class="box-footer">
            <center><a href="#" class="btn btn-sm btn-primary form-control">See More</a></center>
        </div>
    </div>



    <div class="box box-widget mt-3">
        <div class="box-header with-border">
            <h6 class="registration-title">JOBS BY LOCATION  </h6>
        </div>
        <div class="box-body jbl-box">

            <ul class="list-unstyled">
                <?php foreach($locations AS $location):?>
                <?php $locId = $location['id']; ?>
                <?php $totalJobs = $this->job_post_model->getTotalJobsByLocation($locId)?>

                <li class="fs-13"><a href="<?=site_url('jobs?location='.$location['region_name'].'&reg='.$location['id'].'&vt=jobs-by-location')?>" target="<?=site_url('jobs?location='.$location['region_name'].'&reg='.$location['id'].'&vt=jobs-by-location')?>"><?=$location['region_name']?></a> - <span class="">(<?=$totalJobs?>) jobs</span></li>

               
                <?php endforeach;?>
            </ul>

        </div>
        <div class="box-footer">
            <center><a href="#" class="btn btn-sm btn-primary form-control">See More</a></center>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?=base_url('assets/js/adslyt.js')?>"></script>