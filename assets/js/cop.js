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

    var temp = seg[3].split('-');
    var cid = temp[temp.length-1];
    
    getData(App.apiUrl+'/companies/index/id/'+cid, function(company){
        $("h5#company-name, span#company-name").html(company.company_name);
        $("#company-logo").attr('src', company.logo);
        $("#company-log").attr('alt', company.company_name+" logo");
        $("#company-banner").attr('src', company.banner);
        $("#company-banner").attr('alt', company.company_name+" banner");
        $("#company-industry").html('<strong>'+company.industry+'</strong>');
        $("#company-address").html('<strong>'+company.address+'</strong>');
        $("#company-website").attr('href',company.site);
        $("#company-website").text(company.site);
        $("#company-details").text(company.details);
    });
    
    function loadJobs(jobs, selector)
    {   
       if(jobs.data != 0)
       {    
            selector.html("");
                
            $.each(jobs, function(index, item){
                var html = '';
                var salary = (item.salary != 0)? '₱'+item.salary :'Not available';
                var uri = encodeURIComponent(item.company);
                var temp = item.position.replace(/\//g, '');
                var job_title_uri = temp.replace(/\s+/g, '-').toLowerCase();

                html += '<div class="box box-widget jobs-container">';
                    html += '<div class="box-body">';
                        html += '<div class="row">';
                            html += '<div class="col-xs-6  col-md-3 job-info">';
                                html += '<h6 class="job-title"><a href="'+App.pathUrl+'/jobs/details/'+job_title_uri+'/'+item.id+'" target="'+item.id+'">'+item.position+'</a></h6>';
                    
                                html += '<p><a href="'+App.pathUrl + '/companies/'+uri+'-'+item.cid+'" target="'+item.company+'-'+item.cid+'"><small><strong>'+item.company+'</strong></small></a></p>';
                                html += '<p><small>' + item.location + '</small></p>';
                                html += '<p style="color:#cc6969;"><small>' + salary + '</small></p>';

                                html += '<a href="'+App.pathUrl+'/jobs/details/'+job_title_uri+'/'+item.id+'" target="'+item.id+'" class="btn btn-info btn-sm" style="margin-top:0.3125rem;">See More Details</a>';
                            html += '</div>';
                            html += '<div class="col-md-6 hidden-sm-down">';
                                html += '<small><p class="job-description"> '+item.job_description+'</p></small>';
                            html += '</div>';
                            html += '<div class="col-xs-3 col-md-3 logo-box">';
                                html += '<div class="company-logo-container">';
                                    html += '<img src="'+item.company_logo+'" alt="'+item.company+' logo" class="img-fluid"/>';
                                html += '</div>';
                                html += '<p><small class="text-muted"><strong>Posted</strong>: '+moment(item.date_posted).format('MMMM D, YYYY')+' ('+moment(item.date_posted).fromNow()+')</small></p>';
                                html += '<p><small class="text-muted"><strong>Until</strong>: '+item.due_date + '</small></p>'; 
                                   
                            html += '</div>';
                        html += '</div>';
                    html += '</div>';   
                html += '</div>';

                selector.append(html);
            });
       }
    }

    getData(App.apiUrl+'/jobs?cid='+cid, function(jobs){
        loadJobs(jobs, jobsCanvas);
    });

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
            url: App.apiUrl + "/companies/upload_photo",
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
});