<div class="col-lg-3">
    <ul class="list-group">
        <li class="list-group-item">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="applicant-img-container">
                            <img src="<?php echo ($user->profile_pic != '')? $user_image : base_url('assets/images/avatar.jpg'); ?>" class="responsive-logo" alt="User Image">
                            <!-- img-profile-pic -->
                            
                            <!-- <label for="file-upload" class="custom-file-upload">
                                <input id="file-upload" type="button"/>
                                <h5><i class="fa fa-camera-retro customize"></i></h5>
                            </label> -->
                    </div>
                    <div class="btn-profile-img-container hidden-sm-down">
                        <center>
                        <button id="file-upload" class="btn btn-custom"><i class="fa fa-camera-retro"></i> Change Picture</button>
                        </center>
                    </div>    
                </div>
            </div>
        </li>
        <li class="list-group-item"> 
            <p class="text-center lead">
                <?php $firstname = strtolower($user->first_name); $lastname = strtolower($user->last_name);?>
                <h3 class="text-center"><?php  echo ucfirst($firstname) ." ". ucfirst($lastname); ?></h3>  
            </p>
        </li>
        <a href="<?php echo base_url('applicant/news-feed')?>" class="list-group-item"><i class="fa fa-rss"></i> News Feed</a>
        
        <a href="<?php echo base_url('applicant/dashboard')?>" class="list-group-item"><i class="fa fa-dashboard"></i> DASHBOARD</a>
        
        <a href="<?php echo base_url('jobs')?>" class="list-group-item"><i class="fa fa-search"></i> SEARCH JOB</a>

        <a href="<?php echo base_url('applicant/profile/view/'.$this->session->userdata('active_applicant')->user_id)?>" class="list-group-item" ><i class="fa fa-user-circle" aria-hidden="true"></i> MY PROFILE <span class="tag tag-default tag-pill float-xs-right">1</span></a>
        
        <a href="<?php echo base_url('applicant/profile/edit/'.$this->session->userdata('active_applicant')->user_id)?>" class="list-group-item"><i class="fa fa-edit"></i> UPDATE PROFILE</a>

        <a href="<?=base_url('applicant/resume')?>" class="list-group-item"><i class="fa fa-paperclip"></i> UPLOAD RESUME</a> 
        <li class="list-group-item" style=""><br></li>
    </ul>
</div>

<!-- UPLOAD MODAL -->
<div class="modal fade" id="uploadModal" tabindex="" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="lead modal-title" id="exampleModalLabel"></h5>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart('', array("class" => "dropzone", "id" => "profileDropzone"))?>
                    <input type="hidden" name="userPrevImg" value="<?php echo $user->profile_pic?>">
            </div>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-primary pull-left" id="btn-save-img">Save</button>
                <button type="button" class="btn btn-secondary" id="btn-cancel" data-dismiss="modal">Cancel</button>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="<?php //echo base_url('assets/js/jquery-2.2.3.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/applicant.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/dropzone.js');?>"></script>
<script type="text/javascript">

  /** 
      DROPZONE UPLOAD
      CAMELCASE naming convention recommended
      
      dropzoneID.files[0].attributeToAccess
    
  */
    Dropzone.autoDiscover = false;
    
    var profileDropzone = new Dropzone("#profileDropzone",{
        acceptedFiles: "image/*",
        addRemoveLinks: true,
        thumbnailWidth: 200,
        thumbnailHeight: 150,
        dictDefaultMessage: "<i class='fa fa-image fa-5x'></i><br>Drop image or click here to upload",
        maxFiles:1,
        init: function() {
            this.on("maxfilesexceeded", function(file) {
                this.removeAllFiles();
                this.addFile(file);
            });
            this.on('error', function(file, error) {
                console.log(response)
                // var errorMessage = response.errorMessage;
                // $(file.previewElement).find('.dz-error-message').text(errorMessage);
            });       
        },
        removedfile: function(file){
            console.log(file)
            var filename = file.name;

            // $.ajax({
            //     url: "<?php echo base_url('applicant/update_profile_image/');?>",
            //     type: "POST",
            //     data:{
            //         filename : filename,
            //         action: "remove"
            //     },
            //     dataType: 'html',
            //     success: function(data)
            //     {
            //         console.log("Deleted");
            //     }
            // });
            var previewElement;

            return (previewElement = file.previewElement) != null ? (previewElement.parentNode.removeChild(file.previewElement)) : (void 0);
        } 
    });   

    $("#btn-save-img").on("click", function(){
        var old_img = $("input[name=userPrevImg]").val();
        //var new_img = profileDropzone.files[0].name;
        var formData = new FormData();
        var imgToUpload = profileDropzone.files[0];

        formData.append('file', imgToUpload);
        formData.append('old_img', old_img);

        $.ajax({
            url: "<?php echo base_url('applicant/update_profile_image/');?>",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data){
                console.log(data);
                $('#uploadModal').modal('hide');
                $("#profileDropzone")[0].reset();
                window.location.reload();
            },
            error: function(){
                console.log("error")
            }
        });      
    });
 
</script>