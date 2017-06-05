/** 
    THIS FUNCTION IS FOR CROPPING IMAGE BEFORE UPLOADING COMPANY BANNER  REMOVED DUE TO ITS UNRESPONSIVE BEHAVIORS 
    AND UNSUPPORTED TO OTHER BROWSER
*/

Dropzone.autoDiscover = false;

$(function (){
    

    var path = window.location.pathname;
    var seg = path.split('/');
    var pathUrl = window.location.protocol + "//" + window.location.host + "/" + seg[1];
    var currentImageWidth = 0, currentImageHeight = 0;
    var validDimension = false;
    
    function getJSONDoc(url) {
        var response = $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            global: false,
            async: false,
            success: function (data) {
                return data;
            }
        }).responseText;
        return $.parseJSON(response);
    }

    /** Modal Template for Cropping Image*/
    // var modalTemplate = '' + 
    //             '<div class="modal fade" tabindex="-1" role="dialog">' + 
    //                 '<div class="modal-dialog modal-lg" role="document">' + 
    //                     '<div class="modal-content">' + 
    //                         '<div class="modal-header">' + 
    //                             '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + 
    //                             '<h4 class="modal-title">Crop Banner</h4>' + 
    //                         '</div>' +                      
    //                         '<div class="modal-body">' + 
    //                             '<div class="form-group">'+
    //                                 '<small><strong><label class="control-label">Image Width:</strong> <text id="imgWidth"></text></label>&#9;<strong><label class="control-label">Image Height:</strong> <text id="imgHeight"></text></label></small>'+
    //                             '</div>'+
    //                             '<div class="image-container"></div>' + 
    //                         '</div>' +                      
    //                         '<div class="modal-footer">' + 
    //                             '<div class="form-group">'+
    //                             '<button type="button" class="btn btn-primary crop-upload pull-left">Done</button>' +
    //                             '<button type="button" class="btn btn-secondary cancel-upload" data-dismiss="modal">Close</button>' + 
    //                             '</div>' +
    //                         '</div>' + 
    //                     '</div>' + 
    //                 '</div>' + 
    //             '</div>' + 
    //         '';


        function dataURItoBlob(dataURI) {
            var binary = atob(dataURI.split(',')[1]);
            var array = [];
            for(var i = 0; i < binary.length; i++) {
                array.push(binary.charCodeAt(i));
            }
            return new Blob([new Uint8Array(array)], {type: 'image/jpeg'});
        }


        function blobToFile(theBlob, fileName){

            theBlob.lastModifiedDate = new Date();
            theBlob.name = fileName;
            return theBlob;
        }
        
        var minImageWidth = 800,
            minImageHeight = 200;
        
        var myDropzone = new Dropzone("#companyBanner",{
            acceptedFiles: "image/*",
            thumbnailWidth: null,
            thumbnailHeight: null,
            dictDefaultMessage: "<i class='fa fa-image fa-5x'></i><br>Drop image or click here to upload",
            maxFiles:1,
            init: function() {
                this.on("maxfilesexceeded", function(file) {
                    this.removeAllFiles();
                    this.addFile(file);
                });
                this.on('error', function(file, error) {

                });    
                this.on("thumbnail", function(file) { //https://github.com/enyo/dropzone/wiki/FAQ#reject-images-based-on-image-dimensions
                    if(file.name == "")
                    {
                        $("#upload-banner").prop("disabled", true);
                    }
                    if(file.height < minImageHeight || file.width < minImageWidth){
                        file.rejectDimensions();
                        this.removeAllFiles();
                        $("#upload-banner").prop("disabled", true);
                    }
                    else {
                        file.acceptDimensions();
                        $("#upload-banner").prop("disabled", false);
                        $("#remove-banner").prop("disabled", false);
                    }
                });
            },
            accept: function(file, done) {
                file.acceptDimensions = done;
                file.rejectDimensions = function() { 
                    //done("Image dimension must be at least 900 x 400"); 
                    $.notify({
                        title: "<h6><i class='fa fa-exclamation-triangle'></i> Invalid image dimensions</h6>",
                        message: "<small>Image dimension must be at least 800 x 200.</small>"
                    },{
                        type: "danger",
                        delay:2000,
                        animate: {
                            enter: 'animated fadeIn',
                            exit: 'animated fadeOut'
                        }
                    });
                };

            } 
        });   
        
        /** Image Cropping Functions*/
        // myDropzone.on('thumbnail', function (file) {
        //     if (file.cropped) {
        //         return;
        //     }
        //     if(file.height < minImageHeight || file.width < minImageWidth){
        //         return;
        //     }

        //     console.log(file)
        //     var cachedFilename = file.name;
        //     myDropzone.removeFile(file);
        
        //     var $cropperModal = $(modalTemplate);
        //     var $uploadCrop = $cropperModal.find('.crop-upload');
        //     var $cancelCrop = $cropperModal.find('.cancel-upload');
        //     var $img = $('<img />');
        //     var reader = new FileReader();
        //     reader.onloadend = function () {
        //         $cropperModal.find('.image-container').html($img);
        //         $img.attr('src', reader.result);
        //         $img.cropper({
        //             preview: '.image-preview',
        //             minCropBoxWidth: 473.5,
        //             minCropBoxHeight: 118.5,
        //             // aspectRatio: 1 / 1,
        //             // autoCropArea: 1,
        //             // movable: false,
        //             // cropBoxResizable: true,
        //             minContainerHeight : 320,
        //             minContainerWidth : 568,
        //             viewMode: 2,
        //             crop: function(e) {
        //                 currentImageWidth =  Math.round(e.width);
        //                 currentImageHeight = Math.round(e.height);
        //                 $cropperModal.find('#imgWidth').text(currentImageWidth);
        //                 $cropperModal.find('#imgHeight').text(currentImageHeight);

        //                 validDimension = (currentImageWidth > minImageWidth && currentImageHeight > minImageHeight )? true : false;

        //                 // console.log(e.x);
        //                 // console.log(e.y);
        //                 // console.log("width:"+ Math.round(e.width));
        //                 // console.log("height:"+ Math.round(e.height));
        //                 // console.log(e.rotate);
        //                 // console.log(e.scaleX);
        //                 // console.log(e.scaleY);
        //             }
        //         });

        //     };
            
        //     reader.readAsDataURL(file);     
        //     $cropperModal.modal('show');        
            
        //     $uploadCrop.on('click', function() {
        //         var blob = $img.cropper('getCroppedCanvas').toDataURL();
        //         var newFile = dataURItoBlob(blob); //covert to blob 
        //         var random = new Date().valueOf();

                
        //         newFile.cropped = true;
        //         newFile.name = random +"."+cachedFilename;
        //         myDropzone.addFile(newFile);
        //         myDropzone.processQueue();
        //         $cropperModal.modal('hide');
        //         console.log(newFile)

        //             //convert blob to file http://stackoverflow.com/questions/27159179/how-to-convert-blob-to-file-in-javascript
        //             //convert blob to file because when send to server blob change name with no extension and codeigniter file validation consider it as invalid    
        //     });

        //     $cancelCrop.on("click", function(){
        //         $("#upload-banner").prop("disabled", true);
        //         $("#remove-banner").prop('disabled', true);
        //     });
        // });

    //cropper

    $("#upload-banner").on("click", function(){
        var newFile = myDropzone.files[0];
        var currentBanner = $("#current-banner").data("val");
        //upload blob to server
        var formData = new FormData();
        var file = new File([newFile], newFile.name); 
        console.log(file)
        formData.append('userfile', newFile);
        formData.append('current_banner', currentBanner);

        // if(validDimension == true)
        // {
            $.ajax(App.apiUrl + '/companies/banner', {
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
            
                    $.notify({
                        title: " ",
                        message: "<h6><i class='fa fa-check-circle'></i> "+response.message+ "</h6>",

                    },{
                        type: "success",
                        animate: {
                            enter: 'animated fadeIn',
                            exit: 'animated fadeOut'
                        }
                    });
                    myDropzone.removeAllFiles();
                    $("#upload-banner").prop("disabled", true);
                    $("#remove-banner").prop('disabled', true);
                    setTimeout(function() {
                        window.location.reload();
                    }, 500);

                },
                error: function () {

                }
            });
    });

    $("#remove-banner").on("click", function(){
               
        myDropzone.removeAllFiles(); 
        $(this).attr('disabled', true);
        $("#upload-banner").attr('disabled', true);
    });

});