$(function(){
	var path = window.location.pathname;
	var seg = path.split('/');
	var App = {
		pathUrl : window.location.protocol + "//" + window.location.host + "/" + seg[1],
		apiUrl : window.location.protocol + "//" + window.location.host +"/"+seg[1]+"/api"
	}

	function postData(url, method, data, callback)
	{

		$.ajax({
			type: method,
			url : url,
			dataType: "JSON",
			data:data,
			success: callback,
			error:function(jqXHR, exception){

				$.notify({
					title: "<h6><i class='fa fa-exclamation-triangle'></i>&nbsp<small>"+jqXHR.responseJSON.message+"</small></h6> ",
					message: "",
					allow_dismiss:false,
					timer: 5000

				},{
					type: "danger"  
				});
			}
		});
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

	function loadFormData()
    {
    	getData(App.apiUrl +"/applicants/profiles", function(data){
            $("#current-email").text(data.email);
            $("#current-mobile").text(data.mobile);
            if(data.profile_type == 1){
                $("input[name=info_status]").prop("checked", true);
            }
            else{
                $("input[name=info_status]").prop("checked", false);
            }
    	});
    }

    loadFormData();

    $("input[name=info_status]").on("change", function(){
        var data = {};
        if ($(this).is(':checked')) 
        {
           data = {info_status:1, op:"info_status_update"}; 
        } 
        else {
            data = {info_status:0, op:"info_status_update"};
            
        }
        console.log(data);

        postData(App.apiUrl + "/applicants/", "PATCH", data, function(response){

            if(response.status === true){

                $.notify({
                    title: "<h6><i class='fa fa-check-circle'></i> Success</h6> ",
                    message: "<small>"+response.message+"</small>",
                },{
                    type: "success",
                    delay: 1500,
                    animate: {
                        enter: 'animated fadeIn',
                        exit: 'animated fadeOut'
                    }
                });
            }
        });
    });

    $("#form-change-email").validate({
        rules:{
            newEmail:{
                required: true,
                email: true,
                isCurrentEmail: true,
                remote:{                         
                    url: App.pathUrl + '/authenticate/validate',
                    type: "post",
                    data: {
                        email: function() {
                            return $("input[name=newEmail]").val();
                        },
                        action: function(){
                            return "validate_new_email";
                        }    
                    }
                }
            },
            password:{
                required: true
            }
        },
        messages:{
            newEmail:{
                required: "<i class='fa fa-exclamation-circle'></i> New email is required",
                email: "<i class='fa fa-exclamation-circle'></i> Please enter a valid email",
                remote: "<i class='fa fa-exclamation-circle'></i> Email is already in used. Please enter new email"
            },
            password:{
                required: "<i class='fa fa-exclamation-circle'></i> You need to type your password",
            }
        },
        tooltip_options:{
            newEmail:{
                trigger: 'focus',
                placement: 'right',
                html: true,
            },
            password:{
                trigger: 'focus',
                placement: 'right',
                html: true,
            }
        },
        submitHandler:function(form){
            var newEmail = $("input[name=newEmail").val();
            var password = $("#form-change-email input[name=password").val();

            $("#btn-save-email").prop("disabled", true);
            $("#btn-save-email").append('<i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only">Saving...</span>'); 

            $.ajax({
                type: "PATCH",
                url: App.apiUrl + '/applicants/',
                dataType: "json",
                data:
                {
                    newEmail: newEmail,
                    password: password,
                    op:"email_update"
                },
                success: function (data) {
                    if(data.status == true)
                    {
                        $.notify({
                            title: "<h6><i class='fa fa-check-circle'></i> Success</h6> ",
                            message: data.message,

                        },{
                            type: "success",
                            animate: {
                                enter: 'animated bounceInRight',
                                exit: 'animated bounceOutRight'
                            }
                        });
                        $("#current-email").text(newEmail);
                        $("input[name=newEmail]").val("");
                        $("input[name=password]").val("");
                        $("#btn-save-email").prop("disabled", false);
                        $("#btn-save-email").html('Save Changes'); 
                    }
                },
                error: function(xhr, exception){

                    $.notify({
                        title: " ",
                        message: "<h6><i class='fa fa-exclamation-triangle'></i>&nbsp<small>"+jqXHR.responseJSON.message+"</small></h6> "
                    },{
                        type: "danger",
                        animate: {
                            enter: 'animated fadeIn',
                            exit: 'animated fadeOut'
                        },  
                    });

                    $("#btn-save-email").prop("disabled", false);
                    $("#btn-save-email").html('Save Changes'); 
                }
            });
        }
    });

    $("#form-change-mobile").validate({
        rules:{
            phonenumber:{
                required: true,
                validPhonenumber: true,
                isCurrentMobile: true,
                remote:{
                    url: App.pathUrl + '/authenticate/validate',
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
                required: true
            }
        },
        messages:{
            phonenumber:{
                required: "<i class='fa fa-exclamation-circle'></i> Please provide valid phone number",
                remote: "<p style='text-align:justify; text-justify: inter-word;'><i class='fa fa-exclamation-circle'></i> This number has already taken by another user</p>"
            },
            password:{
                required: "<i class='fa fa-exclamation-circle'></i> You need to type your password",
            }
        },
        tooltip_options:{
            phonenumber:{
                trigger: 'focus',
                placement: 'right',
                html: true,
            },
            password:{
                trigger: 'focus',
                placement: 'right',
                html: true,
            }
        },
        submitHandler:function(form){
            var phone_number = $("input[name=phonenumber]").val();
            var password = $("#form-change-mobile input[name=password]").val();
            var data = {
                mobile_num: phone_number,
                password: password,
                op: "mobile_update" 
            };

            $("#btn-save-mobile").prop("disabled", true);
            $("#btn-save-mobile").append('<i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only">Saving...</span>');

            $.ajax({
                type: "PATCH",
                url: App.apiUrl + '/applicants/',
                dataType: "json",
                data:data,
                success: function (data) {
                    if(data.status == true)
                    {
                        $.notify({
                            title: "<h6><i class='fa fa-check-circle'></i> Success</h6> ",
                            message: "<small>"+data.message+"</small>",

                        },{
                            type: "success",
                            animate: {
                                enter: 'animated fadeIn',
                                exit: 'animated fadeOut'
                            }
                        });
                        $("#current-mobile").text(phone_number.replace(/-/g, ''));
                        $("#form-change-mobile")[0].reset();
                        $("#btn-save-mobile").prop("disabled", false);
                        $("#btn-save-mobile").html('Save Changes'); 
                    }
                },
                error: function(xhr, exception){

                    $.notify({
                        title: "<h6><i class='fa fa-times-circle'></i> "+xhr.responseJSON.message+"</h6> ",
                        message: ""
                    },{
                        type: "danger",
                    });

                    $("#btn-save-mobile").prop('disabled', false);
                    $("#btn-save-mobile").html('Save Changes');
                }
            });
        }
    });

    $("#form-change-password").validate({
        onkeyup: false,
        rules:{
            oldPassword:{
                required: true,
            },
            newPassword:{
                required: true,
                //passwordStrength: true
                minlength: 8
            },
            confirmPassword:{
                required: true,
                equalTo: "#newPassword"
            }
        },
        messages:{
            oldPassword:{
                required: "<i class='fa fa-exclamation-circle'></i> Enter current password",
            },
            newPassword:{
                required: "<i class='fa fa-exclamation-circle'></i> Provide new password",
                minlength: "<i class='fa fa-exclamation-circle'></i> Password must be at least 8 characters"
            },
            confirmPassword:{
                required: "<i class='fa fa-exclamation-circle'></i> Please re-type password",
                equalTo: "<i class='fa fa-exclamation-circle'></i> Password doesn't match"
            }
        },
        tooltip_options:{
            oldPassword:{
                trigger: 'focus',
                placement: 'right',
                html: true,
            },
            newPassword:{
                trigger: 'focus',
                placement: 'right',
                html: true,
            },
            confirmPassword:{
                trigger: 'focus',
                placement: 'right',
                html: true,
            }
        },
       
        submitHandler:function(form){
            var oldPassword = $("input[name=oldPassword").val();
            var newPassword = $("input[name=newPassword").val();

            $("#btn-save-password").prop("disabled", true);
            $("#btn-save-password").append('<i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only">Saving...</span>');

            $.ajax({
                type: "PATCH",
                url: App.apiUrl + "/applicants",
                dataType: "json",
                data:
                {
                    password: oldPassword,
                    newPassword: newPassword,
                    op: "password_update"
                },
                success: function (data) {
                    if(data.status == true)
                    {
                        $.notify({
                            title: "<h6><i class='fa fa-check-circle'></i> Success</h6> ",
                            message: "<small>"+data.message+"</small>",

                        },{
                            type: "success",
                            animate: {
                                enter: 'animated fadeIn',
                                exit: 'animated fadeOut'
                            }
                        });

                        $("#form-change-password")[0].reset();
                        $("#btn-save-password").prop('disabled',false);
                        $("#btn-save-password").html('Save Changes');
                    }
                },
                error: function(xhr, exception){

                    $.notify({
                        title: "<h6><i class='fa fa-times-circle'></i> "+xhr.responseJSON.message+"</h6> ",
                        message: ""
                    },{
                        type: "danger",
                    });

                    $("#btn-save-password").prop('disabled',false);
                    $("#btn-save-password").html('Save Changes');
                }
            });
        }
    });

    jQuery.validator.addMethod("validPhonenumber", function(value, element){
        var counter = 0;
        var regex =  /\d/;
        for(var i = 0 ; i < value.length ; i++)
        {
            (value[i].match(regex))? counter += 1 : "";
        }   
        return  (counter == 11)? true: false;
    }, jQuery.validator.format("<p style='text-align:justify; text-justify: inter-word;'><i class='fa fa-exclamation-circle'></i> Please complete the field</p>")); 
    
    jQuery.validator.addMethod("isCurrentMobile", function(value, element){
        var str = value.replace(/-/g, '');
        return (str != $("#current-mobile").text())? true : false;
        console.log(str)
    }, jQuery.validator.format("<p><i class='fa fa-exclamation-circle'></i> You are currently using this mobile</p>"));

    jQuery.validator.addMethod("isCurrentEmail", function(value, element){
        return (value != $("#current-email").text())? true : false;
    }, jQuery.validator.format("<p><i class='fa fa-exclamation-circle'></i> You are currently using this email</p>"));

});