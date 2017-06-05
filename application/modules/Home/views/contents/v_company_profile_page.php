<?php $var = explode("/",$_SERVER['PATH_INFO']); $isMe = explode("-",$var[2]);?>
<div class="container">
    <div class="col-md-10 offset-md-1">
        <div class="c-profile-box">
            <div class="profile-box-banner">
                <img id="company-banner" class="img-responsive" src="">
            </div>
            <div class="c-profile-box-body">
                <div class="c-logo-overlay company-logo-box">
                    <img id="company-logo" class="img-fluid" src="">
            
                    <?php if($user!=NULL && $user->account_type == 3 && $user->comp_id == end($isMe)):?>
                        <div class="upload-logo-box">
                            <a data-toggle="modal" data-target="#uploadModal" class="text-center text-bold">
                                Change logo
                            </a>
                        </div>
                    <?php endif;?>    

                </div>
                <div class="c-info-box ml-13">
                    <div class="c-info-box-header">
                        <h5 id="company-name" class="header light-black"> </h5>
                        <small><label id="company-address" class="light-blue"> </label></small>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <dl class="row"> 
                                    <div class="col-sm-4">
                                        <small>
                                            <label class="header">Email</label>
                                        </small>
                                    </div>
                                    <div class="col-sm-8"> <small><p id="company-email"></p></small></div>

                                    <div class="col-sm-4">
                                        <small>
                                            <label class="header">Website</label>
                                        </small>
                                    </div>
                                    <div class="col-sm-8"><small><p id="company-website"></p></small></div>
                                </dl>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <small>
                                    <label class="header">Industry </label>
                                    <p id="company-industry"></p>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="about-box">
                    <h6 class="header light-black"><i class="fa fa-info-circle"></i> About</h6>
                        <p id="company-details"> </p>
                </div>
            </div>
        </div>

        <div class="box box-widget bg-default">
            <div class="box-header">
                <div class="sp-header-box">
                    <h6>Latest Job openings at <span id="company-name"></span></h6>
                </div>
            </div>
        </div>

        <div class="">

            <div id="jobs-container">

            </div>
            <div class="pagination-box">
                <p id="jobs-pagination"></p>
            </div>      
        </div>
        <div style="padding: 5px; margin-bottom: 1rem;">
            <center><a href="<?=site_url('jobs/')?>">See All Jobs</a></center>
        </div>
        
    </div>    
</div>  

<div class="modal animated fade" id="uploadModal" tabindex="" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close dismiss" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="lead modal-title" id="exampleModalLabel"></h5>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart('', array("class" => "dropzone profile-dropzone", "id" => "profileDropzone"))?>
                    <input type="hidden" name="userPrevImg" value="<?php echo $user->profile_pic?>">
            </div>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-info btn-materialize btn-materialize-sm pull-left" id="btn-save-img" disabled>Save</button>
                <button type="button" class="btn btn-secondary btn-materialize btn-materialize-sm dismiss" data-dismiss="modal" id="btn-cancel" >Cancel</button>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/dropzone.js');?>"></script>
<script type="text/javascript" src="<?=base_url('assets/js/cop.js')?>"></script>