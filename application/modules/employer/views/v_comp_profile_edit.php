<?php $this->load->view('employer/v_employer_sidenav')?>
<div class="content-wrapper">
    <section class="content-header" style="">
        
    </section>  
    <section class="content">
        <div class="row">
            <div class="form-box-max">
                <h5> EDIT COMPANY PROFILE </h5>
                <hr>
                <ul class="nav nav-tabs applicant-edit-tab nav-fill" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#general-info-tab" role="tab">General</a>
                    </li>
                
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#contact-tab" role="tab">Contact Person</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#banner-tab" role="tab">Company Photos</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active animated fadeIn" id="general-info-tab" role="tabpanel">
                        <div class="tab1-content">

                            <div class="box box-widget">
                                <div class="box-header with-border">
                                    <h6> COMPANY INFORMATION</h6>
                                </div>
                                <div class="box-body">
                                    
                                    <form id="company_settings_form">
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label for="email" class="control-label"><small>Company Name</small></label>
                                                <input type="text" name="company_name" class="form-control" value="<?=$employer->company_name?>" placeholder="Company Name" tabindex="1"  autofocus>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="email" class="control-label"><small>Company Industry</small></label>
                                                <select class="form-control" tabindex="2" name="company_industry" >
                                                    <option> </option>
                                                    <?php foreach($industries as $industry):
                                                    $selected = ($industry['id'] == $employer->industry_id)? "selected":"";  
                                                    ?>
                                                    <option value="<?=$industry['id']?>"  <?php echo $selected?>> <?=$industry['industry_name'];?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                            
                                        </div>

                                        <div class="row">   
                                            <div class="form-group col-sm-6">
                                                <label for="email" class="control-label"><small>Company Address</small></label>
                                                <input type="text" name="street_address" class="form-control" value="<?=$employer->street_1?>" placeholder="Street Address" tabindex="3" >
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="control-label"><small></small> <small class="text-muted">(click to set location)</small></label>

                                                <input type="text" class="form-control" name="permanent-address" value="<?php echo $employer->city."&#44;".$employer->province ; ?>" tabindex="4" onkeydown="return false;" placeholder="City Address" >
                                                <input type="hidden" name="region_id" value="<?=$employer->province_1?>">
                                                <input type="hidden" name="city_id" value="<?=$employer->city_1?>">
                                            </div>
                                        </div>

                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="email" class="control-label "><small>Company Website</small></label>
                                            <input type="url" name="company_website" class="form-control" value="<?=$employer->company_website?>" placeholder="http://yourdomain.com">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label for="email" class="control-label "><small>Company Description</small></label>
                                            <textarea name="company_description" class="form-control" placeholder="Describe something about your company" rows="5" tabindex="5" ><?php echo ($employer->company_description);?></textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-sm-3">
                                            <button id="btn-save-info" type="submit" class="btn btn-success btn-materialize">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                                        
                                </div>
                            </div>
                        </div>
                    </div>

            

                    <div class="tab-pane animated fadeIn" id="contact-tab" role="tabpanel">
                        <div class="tab3-content">
                            <div class="box box-widget">
                                <div class="box-header with-border">
                                    <h6> CONTACT PERSON DETAILS</h6>
                                </div>
                                <div class="box-body">
                                    <form action="" method="" id="contact_settings_form">
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <label class="control-label "><small>First Name</small></label>
                                                <input type="text" name="first_name" value="<?=$employer->first_name?>" class="form-control" placeholder="" tabindex="1" >
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label class="control-label "><small>Middle Name</small></label>
                                                <input type="text" name="middlename" value="<?=$employer->middle_name?>" class="form-control" placeholder="" tabindex="2" >
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label class="control-label ">Last Name</label>
                                                <input type="text" name="lastname" class="form-control" placeholder="" value="<?=$employer->last_name?>" tabindex="3" >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <label class="control-label "><small>Position</small></label>
                                                <input type="text" name="position" value="<?=$employer->position?>" class="form-control" placeholder="Position" tabindex="4">
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label  class="control-label "><small>Department</small></label>
                                                <input type="text" name="department" class="form-control" value="<?=$employer->department?>" placeholder="Department" tabindex="5">
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label  class="control-label"><small>Landline</small> <span class="text-muted-light fs-12">(optional)</span></label>
                                                <div class="row">
                                                    <div class="col-sm-5">
                                                        <input type="text" name="area-code" placeholder="Area-code" value="<?=$employer->area_code?>" class="form-control">
                                                    </div>
                                                    <div class="col-sm-7">
                                                        <input type="text" id="landline" name="landline" placeholder="411-11-11" value="<?=$employer->telephone_number?>" class="form-control" data-inputmask='"mask": "999-99-99"' data-mask tabindex="12">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-3">
                                                <button id="btn-save-cinfo" type="submit" class="btn btn-success btn-materialize">Save Changes</button>
                                            </div>
                                        </div>
                                    </form>  
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane animated fadeIn" id="banner-tab" role="tabpanel">
                        <div class="tab4-content">

                            <div class="box box-widget">
                                <div class="box-header with-border">
                                    <h6> UPLOAD BANNER</h6>
                                    <small class="text-muted">(Image dimension at least 800 x 200)</small>
                                    <div class="box-tools" style="margin-top: 0.5rem;">
                                        <button class="btn btn-success btn-materialize btn-materialize-sm" id="upload-banner" disabled>Save</button>
                                        <button class="btn btn-danger btn-materialize btn-materialize-sm" id="remove-banner" disabled>Remove</button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    
                                    <div class="row">
                                        <div class="banner-box" >
                                            <?php echo form_open_multipart('', array("class" => "dropzone", "id" => "companyBanner"))?>
                                            <!-- <input type="hidden" name="action" value="upload"> -->
                                            <input type="hidden" name="" value=>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h6 class="lead">Current Banner</h6>
                                            <hr>
                                            <div class="banner-box" id="preview-banner">
                                               <?php if($employer->company_banner != ""):?>
                                                <img class="card-img-top" id="current-banner" data-val="<?=$employer->company_banner?>" src="<?=$company_banner?>" alt="Card image cap" style="width: 100%; height: auto;">
                                               <?php endif?> 
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
</div>
<?php $this->load->view('template/modal')?> 
<script type="text/javascript" src="<?=base_url('assets/js/employer_acct_settings.js')?>"></script>
<script type="text/javascript" src="<?=base_url('assets/js/company/bnu.js')?>"></script>  
