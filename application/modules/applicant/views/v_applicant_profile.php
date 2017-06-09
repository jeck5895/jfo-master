<?php $this->load->view('applicant/v_applicant_sidebar')?>
<div class="content-wrapper">
    <section class="content-header" style="">
        
    </section>  
    <section class="content">
        <div class="row">
            <div class="profile-box">
                <div class="profile-box-header">
                    <div class="profile-img-overlay">
                        <img src="<?=($user->profile_pic != '')? $user_image : base_url('assets/images/Default_User1.png');?>" class="img-fluid img-circle">
                        <a data-toggle="modal" data-target="#uploadModal" class="">
                            <img src="<?=base_url('assets/images/app/img_frame.png')?>" class="img-fluid upload-frame-overlay">
                        </a>    
                    </div>
                    <div class="profile-btn-box">
                       <a href="<?=site_url('applicant/profile/edit')?>"><img src="<?=base_url('assets/images/app/edit_btn.png')?>" class=""></a>
                    </div>
                </div>
                <div class="profile-box-body">
                    
                    <div class="btn-box">
                        <?php if($user->resume_path != "" && $user->resume_name != ""):?>
                            <a href="<?=base_url().$user->resume_path.'/'.$user->resume_name?>" class="btn btn-secondary btn-materialize">View Resume</a>
                        <?php endif;?>       
                    </div>
                    
                    <div class="profile-name">
                        <h5>
                            <?php $firstname = strtolower($user->first_name); $mInitial = ($user->middle_name != "")?strtolower($user->middle_name).".": ""; $lastname = strtolower($user->last_name);
                                echo ucfirst($firstname)." ".$mInitial." ".ucfirst($lastname);
                            ?>
                        </h5>
                        <p><?=$user->degree?></p>
                    </div>  

                    <div class="profile-information-box">
                        
                        <div class="information-content">
                            
                            <div class="info-ico-box">
                                <img src="<?=base_url('assets/images/app/contact_info.png')?>" class="">
                            </div>

                            <div class="info-header">
                                <h6>CONTACT INFORMATION</h6>
                                
                                <div class="info-body">
                                    <p><?=$user->mobile_num?></p>
                                    <label class="text-muted">Mobile</label>

                                    <p><?=$user->email?></p>
                                    <label class="text-muted">Email</label>

                                    <p><?=$user->city.", ".$user->province?></p>
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
                                        <div class="col-md-9"> <p><?=$user->age?></p></div>

                                        <div class="col-md-3"><label class="text-muted">Civil Status</label></div>
                                        <div class="col-md-9"><p><?=ucfirst($user->civil_status)?></p></div>

                                        <div class="col-md-3"> <label class="text-muted">Birthdate </label></div>
                                        <div class="col-md-9"><p><?=date("F d, Y", strtotime($user->birth_date))?></p></div>

                                        <div class="col-md-3"> <label class="text-muted">Gender </label></div>
                                        <div class="col-md-9"><p><?=ucfirst($user->sex)?></p></div>

                                        <div class="col-md-3"> <label class="text-muted">Home Address </label></div>
                                        <div class="col-md-9"><p><?=$user->street_1 .", ". $user->city.", ".$user->province?></p></div>
                                    </dl>
                                </div>
                            </div>   

                        </div>

                        <hr>

                        <?php if(($user->s_educ_attain) != ""):?>
                            <div class="information-content">
                                
                                <div class="info-ico-box">
                                    <img src="<?=base_url('assets/images/app/personal_details.png')?>" class="">
                                </div>

                                <div class="info-header">
                                    <h6>EDUCATIONAL ATTAINMENT</h6>
                                    
                                    <div class="info-body">
                                        <p class="h4"><?=$user->degree?></p>
                                        <label class="light-blue"><?=$user->school_name?></label><br>
                                        <label class="red"><?=$user->s_educ_attain ." ". $user->s_year_entered." - ".$user->s_year_graduated?></label>
                                    </div>
                                </div>   
                            </div>
                        <?php endif;?>    

                        <?php if(!empty($userWorkHisto)):?>
                            <div class="information-content">
                                
                                <div class="info-ico-box">
                                    <img src="<?=base_url('assets/images/app/w_h.png')?>" class="">
                                </div>

                                <div class="info-header">
                                    <h6>WORK HISTORY</h6>
                                    
                                    <div class="info-body">    
                                        <?php foreach($userWorkHisto as $workHistory):?>
                                            <ul class="list-unstyled work-history-box">
                                                <li> 
                                                    <p class="h4"><?=$workHistory->position?></p>
                                                    <label ><?=$workHistory->company_name?></label><br>
                                                    <label class="red">
                                                        <?=date('F d, Y',strtotime($workHistory->work_start)) ." - ". date('F d, Y',strtotime($workHistory->work_end))?>
                                                    </label>
                                                    <p><?=$workHistory->work_description?></p>
                                                </li>
                                            </ul>
                                        <?php endforeach;?>
                                    </div>
                                </div>   

                            </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
            <?php $this->load->view('template/v_ads_box')?>    
        </div>
    </section>
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
<script type="text/javascript">

  /** 
      DROPZONE UPLOAD
      CAMELCASE naming convention recommended
      
      dropzoneID.files[0].attributeToAccess
    
  */
   
    Dropzone.autoDiscover = false;
     var minImageWidth = 160,
            minImageHeight = 160;
    var profileDropzone = new Dropzone("#profileDropzone",{
        acceptedFiles: "image/*",
        addRemoveLinks: true,
        thumbnailWidth: 200,
        thumbnailHeight: 150,
        dictDefaultMessage: "<small><i class='fa fa-image fa-5x'></i><br>Drop image or click here to upload</small>",
        maxFiles:1,
        init: function() {
            this.on("maxfilesexceeded", function(file) {
                this.removeAllFiles();
                this.addFile(file);
            });
            this.on('error', function(file, error) {
                console.log(response)
               
            });  
            this.on("thumbnail", function(file) { //https://github.com/enyo/dropzone/wiki/FAQ#reject-images-based-on-image-dimensions
                if(file.height < minImageHeight || file.width < minImageWidth){
                    file.rejectDimensions();
                    this.removeAllFiles();
                    $("#btn-save-img").prop("disabled", true);
                }
                if(file.name == "")
                {
                    $("#btn-save-img").prop("disabled", true);
                }
                else{
                    file.acceptDimensions();
                    $("#btn-save-img").prop("disabled", false);
                }
                
            });     
        },
        removedfile: function(file){
            $("#btn-save-img").prop("disabled", true);
            var filename = file.name;

            
            var previewElement;

            return (previewElement = file.previewElement) != null ? (previewElement.parentNode.removeChild(file.previewElement)) : (void 0);
        },
        accept: function(file, done) {
            file.acceptDimensions = done;
            file.rejectDimensions = function() { 

                $.notify({
                    title: "<h6><i class='fa fa-exclamation-triangle'></i> Invalid image dimensions</h6>",
                    message: "<small>Image dimension must be at least 160 x 160.</small>"
                },{
                    type: "danger",
                    delay:1300,
                    animate: {
                        enter: 'animated fadeIn',
                        exit: 'animated fadeOut'
                    }
                });
            };
        }   
    });   

    $("#btn-save-img").on("click", function(){
        var old_img = $("input[name=userPrevImg]").val();
        var formData = new FormData();
        var imgToUpload = profileDropzone.files[0];

        formData.append('userfile', imgToUpload);
        if(old_img != ""){
            formData.append('prev_img', old_img);
        }

        $.ajax({
            url: "<?php echo base_url('api/applicants/user_photo/');?>",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data){
                $('#uploadModal').modal('hide');
                $("#profileDropzone")[0].reset();
                setTimeout(function() {
                    window.location.reload();
                }, 500); 
            },
            error: function(){
                console.log("error")
            }
        });      
    });


 
</script>