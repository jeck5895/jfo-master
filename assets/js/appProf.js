Dropzone.autoDiscover = false;
$(function () {  

 	var path = window.location.pathname;
 	var seg = path.split('/');
 	var pathUrl = window.location.protocol + "//" + window.location.host + "/" + seg[1];
    var jobsCanvas = $("#jobs-container");

    String.prototype.ucfirst = function(){
        return this.charAt(0).toUpperCase() + this.slice(1);
    }

 	
    function getData(url, callback)
    {
        $.ajax({
            type: "GET",
            url : url,
            dataType: "JSON",
            success: callback,
            error:function(){
                
            }
        });
    }

    $('.company-logo-box').hover(function(){
        $(".upload-logo-box").css('display','block');
    }, function(){
        $(".upload-logo-box").css('display','none');
    });

    var id = seg[3];

   
    getData(App.apiUrl+'/applicants/profiles/id/'+id, function(data){
        var fname = data.first_name.toLowerCase();
        var mname = data.middle_name.toLowerCase();
        var lname = data.last_name.toLowerCase();
        var html = "";

        $("#applicant-name").html(fname.ucfirst() +" "+ mname[0].ucfirst()+"."+" "+lname.ucfirst());
        $("#profile-image").attr('src', data.profile_img);
        $("#degree").text(data.degree);
        $("#mobile").text(data.mobile);
        $("#email").text(data.email);
        $("#address").text(data.address);
        $("#age").text(data.age);
        $("#c-status").text(data.civil_status.ucfirst());
        $("#birthdate").text(moment(data.birthdate).format('MMMM D, YYYY'));
        $("#gender").text(data.gender.ucfirst());
        $("#home-address").text(data.street +", "+data.address);


        if(data.school != "" && data.degree != "" && data.attainment != "")
        {
            var ehtml = '<div class="info-ico-box">';
                    ehtml += '<img src="'+App.pathUrl+'/assets/images/app/personal_details.png" >';
                ehtml += '</div>';

                ehtml += '<div class="info-header">';
                    ehtml += '<h6>EDUCATIONAL ATTAINMENT</h6>';
                    ehtml += '<div class="info-body">';
                        ehtml += '<p class="h4" >'+data.degree+'</p>';
                        ehtml += '<label class="light-blue" >'+data.school+'</label><br>';
                        ehtml += '<label class="red">'+data.attainment+' '+data.year_entered+' - '+data.year_graduated+'</label>';
                    ehtml += '</div>';
                ehtml += '</div>';
           
            $("#education-box").html(ehtml);
        }
       
        
        if(data.work_history.length != 0)
        {
            
                html += '<div class="info-ico-box">';
                    html += '<img src="'+App.pathUrl+'/assets/images/app/w_h.png">';
                html += '</div>';

                html += '<div class="info-header">';
                    html += '<h6>WORK HISTORY</h6>';
                    html += '<div class="info-body">';
                    $.each(data.work_history, function(index, item){
                        html += '<ul class="list-unstyled work-history-box">';
                            html += '<li> ';
                                html += '<p class="h4">'+item.position+'</p>';
                                html += '<label>'+item.company_name+'</label><br>';
                                html += '<label class="red">'+item.start_date+' - '+item.end_date+'</label>';
                                html += '<p>'+item.work_description+'</p>';
                            html += '</li> '; 
                        html += '</ul>';        
                    });
                html += '</div>';    
                html += '</div>';
           
           $("#work-history").html("").append(html);
        }
    });


    // var minImageWidth = 160,
    //         minImageHeight = 160;
    
    // var profileDropzone = new Dropzone("#profileDropzone",{
    //     acceptedFiles: "image/*",
    //     addRemoveLinks: true,
    //     thumbnailWidth: 200,
    //     thumbnailHeight: 150,
    //     dictDefaultMessage: "<small><i class='fa fa-image fa-5x'></i><br>Drop image or click here to upload</small>",
    //     maxFiles:1,
    //     init: function() {
    //         this.on("maxfilesexceeded", function(file) {
    //             this.removeAllFiles();
    //             this.addFile(file);
    //         });
    //         this.on('error', function(file, error) {
    //             console.log(response)
               
    //         });      
    //         this.on("thumbnail", function(file) { //https://github.com/enyo/dropzone/wiki/FAQ#reject-images-based-on-image-dimensions
    //             if(file.height < minImageHeight || file.width < minImageWidth){
    //                 file.rejectDimensions();
    //                 this.removeAllFiles();
    //                 $("#btn-save-img").prop("disabled", true);
    //             }
    //             if(file.name == "")
    //             {
    //                 $("#btn-save-img").prop("disabled", true);
    //             }
    //             else{
    //                 file.acceptDimensions();
    //                 $("#btn-save-img").prop("disabled", false);
    //             }
    //         });
    //     },
    //     removedfile: function(file){
    //         $("#btn-save-img").prop("disabled", true);
    //         var filename = file.name;

            
    //         var previewElement;

    //         return (previewElement = file.previewElement) != null ? (previewElement.parentNode.removeChild(file.previewElement)) : (void 0);
    //     },
    //     accept: function(file, done) {
    //         file.acceptDimensions = done;
    //         file.rejectDimensions = function() { 

    //             $.notify({
    //                 title: "<h6><i class='fa fa-exclamation-triangle'></i> Invalid image dimensions</h6>",
    //                 message: "<small>Image dimension must be at least 160 x 160.</small>"
    //             },{
    //                 type: "danger",
    //                 delay:1300,
    //                 animate: {
    //                     enter: 'animated fadeIn',
    //                     exit: 'animated fadeOut'
    //                 }
    //             });
    //         };
    //     }  
    // });   

    // $("#btn-save-img").on("click", function(){
    //     var old_img = $("input[name=userPrevImg]").val();
    //     var formData = new FormData();
    //     var imgToUpload = profileDropzone.files[0];

    //     formData.append('userfile', imgToUpload);
    //     if(old_img != ""){
    //         formData.append('prev_img', old_img);
    //     }

    //     $.ajax({
    //         url: App.apiUrl + "/companies/upload_photo",
    //         type: 'POST',
    //         data: formData,
    //         processData: false,
    //         contentType: false,
    //         success: function(data){
    //             $('#uploadModal').modal('hide');
    //             $("#profileDropzone")[0].reset();
    //             setTimeout(function() {
    //                 window.location.reload();
    //             }, 500);
    //         },
    //         error: function(){
    //             console.log("error")
    //         }
    //     });      
    // });
});