$(document).ready(function() {

	var path = window.location.pathname;
 	var seg = path.split('/');
 	var pathUrl = window.location.protocol + "//" + window.location.host + "/" + seg[1];
    var current_url = window.location.href; 
    

    Array.prototype.inArray = function (value)
    {

        var i;
        for (i=0; i < this.length; i++)
        {
            if (this[i] == value)
            {
                return true;
            }
        }
         return false;
    };

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                
                $('#img-banner').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    var Application = {
        path : window.location.protocol + "//" + window.location.host + "/" + seg[1],
        renderTemplate: function(template, canvas, templateID){
            var template = $(template).filter(templateID).html();
            canvas.html("").append(template);
        },
        navigate: function(hash,template, canvas, templateID){
             
            switch (hash)
            {
                case "#create-user":

                    this.renderTemplate(template, canvas, "#create-user");
                    $('#phone').inputmask();
                    $('#create-user-form').validate({
                        ignore: '.ignore', 
                        onkeyup: false,
                        rules:{
                            email:{
                                required: true,
                                email: true,
                                remote:{                        
                                    url: pathUrl + '/registration/validate',
                                    type: "post",
                                    data: {
                                        email: function() {
                                            return $("input[name=email]").val();
                                        },
                                        action: function(){
                                            return "validate_new_email";
                                        }    
                                    }
                                }
                            },
                            phonenumber:{
                                required: true,
                                validPhonenumber: true,
                                remote:{
                                    url: pathUrl + '/registration/validate',
                                    type: "post",
                                    data: {
                                        mobile_number: function() {
                                            return $("input[name=phonenumber]").val();
                                        },
                                        action: function(){
                                            return "validate_new_number";
                                        }    
                                    }  
                                }
                            },
                            password:{
                                required: true,
                                minlength: 8
                            },
                            confirmPassword:{
                                required: true,
                                equalTo: "#password" 
                            },
                        },
                        messages:{
                            email:{
                                required: "<i class='fa fa-exclamation-circle'></i> Email is required",
                                email: "<i class='fa fa-exclamation-circle'></i> Please enter a valid email",
                                remote:"<i class='fa fa-exclamation-circle'></i> This email is already in used"
                            },
                            phonenumber:{
                                required: "<i class='fa fa-exclamation-circle'></i> Phone number is required",
                                remote:"<i class='fa fa-exclamation-circle'></i> This number is already in used"
                            },     
                            password:{
                                required: "<i class='fa fa-exclamation-circle'></i> Password is required",
                                minlength: "<i class'fa fa-exclamation-circle'></i> Password is at least 8 characters"
                            },
                            confirmPassword:{
                                required: "<i class='fa fa-exclamation-circle'></i> Please re-type your password",
                                equalTo: "<i class='fa fa-exclamation-circle'></i> Password doesn't match"
                            },
                        },
                        tooltip_options:{
                            email:{
                                trigger: 'focus',
                                placement: 'top',
                                html: true,
                            },
                            phonenumber:{
                                trigger: 'focus',
                                placement: 'top',
                                html: true,
                            },
                            password:{
                                trigger: 'focus',
                                placement: 'top',
                                html: true,
                            },
                            confirmPassword:{
                                trigger: 'focus',
                                placement: 'top',
                                html: true,
                            },
                        },
                        highlight: function(element) {
                            $(element).closest('.form-group').addClass('has-danger');
                        },
                        unhighlight: function(element) {
                            $(element).closest('.form-group').removeClass('has-danger');

                        },
                        submitHandler:function(form){
                            var firstname = $.trim($('input[name=firstname]').val());
                            var middlename = $.trim($('input[name=middlename]').val());
                            var lastname = $.trim($('input[name=lastname]').val());
                            var street = $.trim($('input[name=street]').val());
                            var region_id = $("input[name = region_id]").val();
                            var city_id = $("input[name = city_id]").val();
                            var user_type = $('select[name = user_type] option:selected').val();
                            var phonenumber = $("input[name=phonenumber]").val();
                            var email = $.trim($("input[name=email]").val());
                            var password = $.trim($("input[name=password]").val());

                           
                            $("#btn-create-user").prop("disabled", true);
                            $("#btn-create-user").append('<center><i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only">Creating User...</span></center>');
                            
                            $.ajax({
                                url : pathUrl + "/api/admin",
                                type: "POST",
                                dataType: "JSON",
                                data:{
                                    firstname: firstname,
                                    middlename: middlename,
                                    lastname: lastname,
                                    street: street,
                                    region_id: region_id,
                                    city_id: city_id,
                                    acct_type: user_type,
                                    phonenumber: phonenumber,
                                    email: email,
                                    password: password
                                },
                                success: function(data)
                                {
                                    $('#create-user-form')[0].reset();
                                    $("#btn-create-user").prop("disabled", false);
                                    $("#btn-create-user").html('Create User');
                                    
                                    $.notify({
                                        title: "<h6><i class='fa fa-check-circle'></i> Success</h6> ",
                                        message: "<small>"+data.message+"</small>",

                                    },{
                                        type: "success",
                                        delay: 1400,
                                        animate: {
                                            enter: 'animated bounceInRight',
                                            exit: 'animated bounceOutRight'
                                        }
                                    });
                                },
                                error: function()
                                {
                                    $("#btn-create-user").prop("disabled", false);
                                    $("#btn-create-user").html('Create User');
                                }
                            });
                        }    
                    }); 

                break;

                case "#jobfair":
                    this.renderTemplate(template, canvas, "#jobfair");
                    
                    $(".filestyle").filestyle({
                        iconName : 'fa fa-image',
                        buttonName : 'btn-secondary',
                        buttonText : 'Choose image',

                    });

                    var minImageWidth = 800, minImageHeight = 200;
                    var boolean = false;
                    var mime ;
                    var type;
                    var size ;
                    var input ;    
                    var valid_images = ["image/jpeg","image/jpg","image/png"];
                    var imgToUpload ;


                    $("input[name = userfile]").on("change", function(){ 

                        mime = $(this)[0].files[0].type;
                        type = mime.split("/");
                        size = $(this)[0].files[0].size;
                        input = $(this);    
                        imgToUpload = input[0].files[0];


                        if(valid_images.inArray(mime))
                        {
                            var html = "<img src='' id='img-banner' class='responsive-logo'>"; 

                            $("#img-preview").html("").append(html);

                            readURL(this);

                            var image = $("#img-banner")[0];


                            image.onload = function(){

                                if(this.naturalWidth < minImageWidth)
                                {

                                    $.notify({
                                        title: "<h6><i class='fa fa-exclamation-triangle'></i> Error</h6>",
                                        message: "<small>Invalid Image Dimensions</small>",
                                        target: "_blank"
                                    },{
                                        type: "danger"
                                    });

                                    var html = '';
                                    html += '<center>';
                                    html += '<i class="fa fa-image fa-5x"></i>';
                                    html += '<p><small>Image Preview</small></p>';
                                    html += '</center>';
                                    $(".bootstrap-filestyle input").val("")
                                    input.val("");
                                    $("#img-preview").html(html);
                                    $("#remove-banner, #upload-banner").attr('disabled', true);
                                    $("#upload-banner").html("<i class='fa fa-upload'></i> Upload Image");

                                }
                                else{
                                    $("#upload-banner, #remove-banner").attr('disabled', false);
                                }
                            }
                        }
                        else{

                            $.notify({
                                title: "<h6><i class='fa fa-exclamation-triangle'></i> Please upload valid image</h6>",
                                message: "",
                                target: "_blank"
                            },{
                                type: "danger"
                            });

                            $(".bootstrap-filestyle input").val("")
                            input.val("");

                        }  
                    });

                    $(document).on("click", "#remove-banner, #upload-banner", function(){
                        btn = $(this);
                        if(btn.attr('id') == "upload-banner")
                        {
                            $(this).html('<i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only">Saving...</span>');

                            var formData = new FormData();

                            formData.append('userfile', imgToUpload);

                            $.ajax({
                                url : pathUrl + "/api/admin/banner",
                                type: "POST",
                                processData: false,
                                contentType: false,
                                data: formData,
                                success: function(data)
                                {
                                    $.notify({
                                        title: "<h6><i class='fa fa-check-circle'></i> Success</h6> ",
                                        message: "<small>"+data.message+"</small>",

                                    },{
                                        type: "success",
                                        delay: 1400,
                                        animate: {
                                            enter: 'animated bounceInRight',
                                            exit: 'animated bounceOutRight'
                                        }
                                    });

                                    var html = '';
                                    html += '<center>';
                                    html += '<i class="fa fa-image fa-5x"></i>';
                                    html += '<p><small>Image Preview</small></p>';
                                    html += '</center>';
                                    $(".bootstrap-filestyle input").val("")
                                    input.val("");
                                    $("#img-preview").html(html);
                                    $("#remove-banner, #upload-banner").attr('disabled', true);
                                    $("#upload-banner").html("<i class='fa fa-upload'></i> Upload Image");
                                },
                                error: function(jqXHR, textStatus, errorThrown)
                                {
                                    $.notify({
                                        title: "<h6><i class='fa fa-check-circle'></i>Upload Error</h6> ",
                                        message: "<small>"+jqXHR+" "+textStatus+" "+errorThrown+"</small>",

                                    },{
                                        type: "danger",
                                        delay: 1400,
                                        animate: {
                                            enter: 'animated bounceInRight',
                                            exit: 'animated bounceOutRight'
                                        }
                                    });
                                    console.log()
                                }
                            });       
                        }
                        else{
                            var html = '';
                            html += '<center>';
                            html += '<i class="fa fa-image fa-5x"></i>';
                            html += '<p><small>Image Preview</small></p>';
                            html += '</center>';
                            $(".bootstrap-filestyle input").val("")
                            input.val("");
                            $("#img-preview").html(html);
                            $("#remove-banner, #upload-banner").attr('disabled', true);
                        }
                    });      

                break;

                case "#advertisement":
                    this.renderTemplate(template, canvas, "#advertisement");
                    //advertisement Table
                    $ads_table = $('#admin-advertisement-table').DataTable({ 
                                "processing": true, 
                                "serverSide": true, 
                                "responsive": true,

                                "ajax": {
                                    "url": pathUrl + "/admin/advertisements",
                                    "type": "POST",
                                    "dataFilter": function(data){
                                        var json = jQuery.parseJSON( data );
                                        var totalReFiltered = json.recordsFiltered;

                                        if(totalReFiltered != 0)
                                        {
                                            $("#admin-advertisement-badge").html(totalReFiltered);
                                            $("#admin-advertisement-badge").css("background-color","rgb(154, 30, 30)");
                                        }
                                        else
                                        {
                                            $("#admin-advertisement-badge").html("0");
                                            $("#admin-advertisement-badge").css("background-color","#999999");
                                        }

                                        return JSON.stringify( json ); 
                                    }
                                },
                                "language": {
                                    "processing": "<img src='"+pathUrl+'/assets/images/app/ajax-loader.gif'+"'>",
                                },

                                "columnDefs": [
                                    { 
                                      "targets": ['class','no-sort'], 
                                      "orderable": false, 
                                    },
                                  ],
                              });

                    $(".filestyle").filestyle({
                        iconName : 'fa fa-image',
                        buttonName : 'btn-secondary',
                        buttonText : 'Choose image',
                    });

                    $("#create-advertisement-form").validate({
                        onkeyup: false,
                        rules:{
                            caption:{
                                required: true
                            },
                            website:{
                                url: true,
                                required: true
                            }
                        },
                        message:{
                            website:{
                                url: "<i class='fa fa-exclamation-circle'></i> Invalid url"
                            }
                        },
                        tooltip_options:{
                            caption:{
                                trigger: 'focus',
                                placement: 'top',
                                html: true,
                            },
                            website:{
                                trigger: 'focus',
                                placement: 'top',
                                html: true,
                            }
                        },
                        highlight: function(element) {
                            $(element).closest('.form-group').addClass('has-danger');
                        },
                        unhighlight: function(element) {
                            $(element).closest('.form-group').removeClass('has-danger');

                        },
                        submitHandler:function(form0){
                            var caption = $('input[name = caption]').val();
                            var website = $('input[name = website]').val();
                            var inputFile = $('input[name = userfile]');

                            

                            if(inputFile.val() == "")
                            {
                                $(".bootstrap-filestyle input").tooltip({
                                    title: "<i class='fa fa-exclamation-circle'></i> Advertisement Image is required",
                                    html: true,
                                    placement: "top"
                                });
                                $(".bootstrap-filestyle input").tooltip("show");
                            }
                            else{

                               $("#btn-save-advertisement").prop("disabled", true);
                               $("#btn-save-advertisement").html('<i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only">Saving...</span>');
                                
                                var formData = new FormData();
                                var imgToUpload = inputFile[0].files[0];

                                formData.append('caption', caption);
                                formData.append('website', website);
                                formData.append('userfile', imgToUpload);       



                                $.ajax({
                                    url : pathUrl + "/api/admin/advertisement",
                                    type: "POST",
                                    processData: false,
                                    contentType: false,
                                    data: formData,
                                    success: function(data)
                                    {
                                        $('#create-advertisement-form')[0].reset();
                                        $("#btn-save-advertisement").prop("disabled", false);
                                        $("#btn-save-advertisement").html('Save Advertisement');

                                        $.notify({
                                            title: "<h6><i class='fa fa-check-circle'></i> Success</h6> ",
                                            message: "<small>"+data.message+"</small>",

                                        },{
                                            type: "success",
                                            delay: 1400,
                                            animate: {
                                                enter: 'animated bounceInRight',
                                                exit: 'animated bounceOutRight'
                                            }
                                        });
                                    },
                                    error: function()
                                    {
                                        $("#btn-save-advertisement").prop("disabled", false);
                                        $("#btn-save-advertisement").html('Save Advertisement');
                                    }
                                });                       
                            }
                        }
                    });

                break;

                default:;//this.renderTemplate(template, canvas, "#404");
            }
        }
    };

    $('.header a[href="'+ current_url +'"]').addClass('active'); //add active to current url=

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

    function loadBadgeData()
    {
        var  pending_jobs =  getJSONDoc(pathUrl +"/api/jobs/index/status/pending");
        // var  published_jobs =  getJSONDoc(pathUrl +"/api/jobs/index/status/published");
        // var  declined_jobs =  getJSONDoc(pathUrl +"/api/jobs/index/status/declined");
        // var  trash_jobs =  getJSONDoc(pathUrl +"/api/jobs/index/status/trash");
        
        if(pending_jobs.length != 0)
        {
            $("#admin-review-badge, .jobs-badge").html(pending_jobs.length);
            $("#admin-review-badge, .jobs-badge").css("background-color","rgb(154, 30, 30)");
        }
        else
        {
            $("#admin-review-badge").html("0");
            $("#admin-review-badge").css("background-color","#999999");
        }
    }


	$('.sublinks').on('show.bs.collapse', function () {
		$('.panel-heading').addClass('active');
	});

	$('.sublinks').on('hide.bs.collapse', function () {
		$('.panel-heading').removeClass('active');
	});
                    
    loadBadgeData();
    //FOR MAINTENANCE/CONFIGURATION javascript templating (v_admin_maintenance dynamic content from /assets/templates/maintenace)
    $.get(pathUrl + "/assets/templates/maintenance/template.html", function(template){
        var canvas = $("#maintenance-canvas");
        var hash = window.location.hash;

        Application.navigate(hash, template, canvas, "#create-user");
       
        $(document).on("click","a", function(){
            $('.header a').removeClass('active');
            
            hash = $(this)[0].hash;
            current_url = $(this)[0].href;
            
            Application.navigate(hash, template, canvas, "#create-user"); 

            $('.header a[href="'+ current_url +'"]').addClass('active');
        });
        
    });


	jQuery.validator.addMethod("validPhonenumber", function(value, element){
        var counter = 0;
        var regex =  /\d/;
        for(var i = 0 ; i < value.length ; i++)
        {
            // console.log(value[i]);
            (value[i].match(regex))? counter += 1 : "";
        }   
        //console.log(counter);
        return  (counter == 11)? true: false;
     }, jQuery.validator.format("<p style='text-align:justify; text-justify: inter-word;'><i class='fa fa-exclamation-circle'></i> Please complete the field</p>"));
});
