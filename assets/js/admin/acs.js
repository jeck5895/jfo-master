 $(function () {  

 	var path = window.location.pathname;
 	var seg = path.split('/');
 	var pathUrl = window.location.protocol + "//" + window.location.host + "/" + seg[1];

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

    $("#form-admin-info").validate({
        rules:{
            first_name:{
                required: true
            },
            middlename:{
                required: true
            },
            lastname:{
                required: true
            },
            "permanent-address":{
                required: true
            },
            street:{
                required:true
            }
         
        },
        messages:{
            first_name:{
                required: "<i class='fa fa-exclamation-circle'></i> This field is required",
            },
            middlename:{
                required: "<i class='fa fa-exclamation-circle'></i> This field is required",
            },
            lastname:{
                required: "<i class='fa fa-exclamation-circle'></i> This field is required",
            },
            "permanent-address":{
                required: "<i class='fa fa-exclamation-circle'></i> This field is required",
            },
            street:{
                required: "<i class='fa fa-exclamation-circle'></i> This field is required",
            }
            
        },
        tooltip_options:{
            first_name:{
                trigger: 'focus',
                placement: 'top',
                html: true,

            },
            middlename:{
                trigger: 'focus',
                placement: 'top',
                html: true,

            },
            lastname:{
                trigger: 'focus',
                placement: 'top',
                html: true,

            },
            "permanent-address":{
                trigger: 'focus',
                placement: 'top',
                html: true,   
            },
            street:{
                trigger: 'focus',
                placement: 'top',
                html: true,
            }
        },
       
        submitHandler:function(form){
            var first_name = $("input[name=first_name]").val();
            var middle_name = $("input[name=middlename]").val();
            var last_name = $("input[name=lastname]").val();
            var street = $("input[name=street]").val();
            var province = $("input[name=region_id]").val();
            var city = $("input[name=city_id]").val();
            var data = {
                first_name: first_name,
                middle_name: middle_name,
                last_name: last_name,
                street: street,
                province: province,
                city:city,
                op: "general_info_update" 
            };

            $("#btn-save-info").prop("disabled", true);
            $("#btn-save-info").append('<i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only">Saving...</span>');

            
            $.ajax({
                type: "PATCH",
                url: App.apiUrl +'/admin',
                dataType: "json",
                data: data,
                success: function (data) {
                   $.notify({
                        title: " ",
                        message: "<h6><i class='fa fa-exclamation-triangle'></i>&nbsp<small>"+data.message+"</small></h6>"
                    },{
                        type: "success",
                        animate: {
                            enter: 'animated fadeIn',
                            exit: 'animated fadeOut'
                        },  
                    });

                    $("#btn-save-info").prop('disabled', false);
                    $("#btn-save-info").html('Save Changes');

                },
                error: function(xhr, exception){
                    $.notify({
                        title: " ",
                        message: "<h6><i class='fa fa-exclamation-triangle'></i>&nbsp<small>"+xhr.responseJSON.message+"</small></h6>"
                    },{
                        type: "danger",
                        animate: {
                            enter: 'animated fadeIn',
                            exit: 'animated fadeOut'
                        },  
                    });

                    $("#btn-save-info").prop('disabled', false);
                    $("#btn-save-info").html('Save Changes');
                }
            });
        }
    });

    //Change email
    $("#email_settings_form").validate({
        // onkeyup: false,
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
            var password = $("#email_settings_form input[name=password").val();
            
            $("#btn-save-email").prop("disabled", true);
            $("#btn-save-email").append('<i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only">Saving...</span>');

            $.ajax({    
                type: "PATCH",
                url: App.apiUrl +'/admin',
                dataType: "json",
                data:
                {
                    newEmail: newEmail,
                    password: password,
                    op: "email_update"
                },
                success: function (data) {
                    
                    $.notify({
                        title: " ",
                        message: "<i class='fa fa-check-circle'></i>&nbsp<small>"+data.message,

                    },{
                        type: "success",
                        animate: {
                            enter: 'animated fadeIn',
                            exit: 'animated fadeOut'
                        },
                    });

                    $("#btn-save-email").prop('disabled', false);
                    $("#btn-save-email").html('Save Changes');
                    $("#current_email").text(newEmail);
                    $("#email_settings_form")[0].reset();
                    
                },
                error: function(xhr, exception){
                    $.notify({
                        title: " ",
                        message: "<h6><i class='fa fa-exclamation-triangle'></i>&nbsp<small>"+xhr.responseJSON.message+"</small></h6>"
                    },{
                        type: "danger",
                        animate: {
                            enter: 'animated fadeIn',
                            exit: 'animated fadeOut'
                        },  
                    });

                    $("#btn-save-email").prop('disabled', false);
                    $("#btn-save-email").html('Save Changes');
                }
            });
        }
    });

    //change password
    $("#change_password_form").validate({
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
            var oldPassword = $("#change_password_form input[name=oldPassword").val();
            var newPassword = $("input[name=newPassword").val();
            
            $("#btn-save-password").prop("disabled", true);
            $("#btn-save-password").append('<i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only">Saving...</span>');
            
            $.ajax({
                type: "PATCH",
                url: App.apiUrl +'/admin',
                dataType: "json",
                data:
                {
                    password: oldPassword,
                    newPassword: newPassword,
                    op: "password_update"
                },
                success: function (data) {
                  
                    $.notify({
                        title: " ",
                        message: "<h6><i class='fa fa-exclamation-triangle'></i>&nbsp<small>"+data.message+"</small></h6> ",

                    },{
                        type: "success",
                        animate: {
                            enter: 'animated fadeIn',
                            exit: 'animated fadeOut'
                        },
                    });
                        
                    $("#change_password_form")[0].reset();
                    $("#btn-save-password").prop('disabled',false);
                    $("#btn-save-password").html('Save Changes');
                   
                },
                error: function(xhr, exception){
                    $.notify({
                        title: " ",
                        message: "<h6><i class='fa fa-exclamation-triangle'></i>&nbsp<small>"+xhr.responseJSON.message+"</small></h6> "
                    },{
                        type: "danger",
                        animate: {
                            enter: 'animated fadeIn',
                            exit: 'animated fadeOut'
                        },  
                    });

                    $("#change_password_form")[0].reset();
                    $("#btn-save-password").prop('disabled',false);
                    $("#btn-save-password").html('Save Changes');
                }
            });
        }
    });

    //password strengt validation
    jQuery.validator.addMethod("passwordStrength", function(value, element){
        var password = value; 
        var preg_match = /^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/;   
        
        return  (password.match(preg_match))? true: false;
    }, jQuery.validator.format("<p style='text-align:justify; text-justify: inter-word;'><i class='fa fa-exclamation-circle'></i> Password must contain at least 1 character, 1 digit, 1 symbol and is combination of small and capital letters!</p>"));

    //change mobile number
     $("#change_mobile_number_form").validate({
       
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
            }
        },
        password:{
            required: true
        },
        messages:{
            phonenumber:{
                required: "<i class='fa fa-exclamation-circle'></i> Please provide valid phone number",
                remote: "<p style='text-align:justify; text-justify: inter-word;'><i class='fa fa-exclamation-circle'></i> This number has already taken by another user</p>"
            }
        },
        tooltip_options:{
            phonenumber:{
                trigger: 'focus',
                placement: 'right',
                html: true,
            }
        },
        submitHandler:function(form){
            var phone_number = $("input[name=phonenumber]").val();
            var password = $("#change_mobile_number_form input[name=password]").val();
            
            $("#btn-save-mobile").prop("disabled", true);
            $("#btn-save-mobile").append('<i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only">Saving...</span>');

            $.ajax({
                type: "PATCH",
                url: App.apiUrl +'/admin/',
                dataType: "json",
                data:
                {
                    mobile_num: phone_number,
                    password: password,
                    op: "mobile_update"
                },
                success: function (data) {

                    $.notify({
                        title: " ",
                        message: "<h6><i class='fa fa-exclamation-triangle'></i>&nbsp<small>"+data.message+"</small></h6> ",

                    },{
                        type: "success",
                        animate: {
                            enter: 'animated fadeIn',
                            exit: 'animated fadeOut'
                        },
                    });

                    $("#change_mobile_number_form")[0].reset();
                    $("#btn-save-mobile").prop("disabled", false);
                    $("#btn-save-mobile").html('Save Changes'); 
                    $("#current-mobile").text(phone_number.replace(/-/g, ''));
                },
                error: function(xhr, exception){
                    $.notify({
                        title: " ",
                        message: "<h6><i class='fa fa-exclamation-triangle'></i>&nbsp<small>"+xhr.responseJSON.message+"</small></h6> "
                    },{
                        type: "danger",
                        animate: {
                            enter: 'animated fadeIn',
                            exit: 'animated fadeOut'
                        },  
                    });

                    $("#btn-save-mobile").prop("disabled", false);
                    $("#btn-save-mobile").html('Save Changes');
                }
            });
        }
    });

    jQuery.validator.addMethod("validPhonenumber", function(value, element){
        var counter = 0;
        var regex =  /\d/;
        for(var i = 0 ; i < value.length ; i++)
        {
            console.log(value[i]);
            (value[i].match(regex))? counter += 1 : "";
        }   
        
        return  (counter == 11)? true: false;
    }, jQuery.validator.format("<p style='text-align:justify; text-justify: inter-word;'><i class='fa fa-exclamation-circle'></i> Please complete the field</p>")); 

    jQuery.validator.addMethod("isCurrentMobile", function(value, element){
        var str = value.replace(/-/g, '');
        return (str != $("#current-mobile").text())? true : false;
        
    }, jQuery.validator.format("<p><i class='fa fa-exclamation-circle'></i> You are currently using this mobile</p>"));

    jQuery.validator.addMethod("isCurrentEmail", function(value, element){
        return (value != $("#current_email").text())? true : false;
    }, jQuery.validator.format("<p><i class='fa fa-exclamation-circle'></i> You are currently using this email</p>"));

    $("#smtp_email_form").submit(function(e){
        e.preventDefault();
        var email = $("input[name=smtp_email]").val();

        $("#btn-save-smtp-email").append('<i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only">Saving...</span>');
        $("#btn-save-smtp-email").prop("disabled", true);
        
        $.ajax({
            type:"POST",
            url: App.apiUrl +"/admin/smtp_acct",
            dataType: "JSON",
            data:{email:email},
            success:function(data){
                $.notify({
                    title: " ",
                    message: "<i class='fa fa-check-circle'></i> "+data.message,

                },{
                    type: "success",
                    delay: 2000,
                    animate: {
                        enter: 'animated fadeIn',
                        exit: 'animated fadeOut'
                    }
                });
                $("#btn-save-smtp-email").prop("disabled", false);
                $("#btn-save-smtp-email").html('Save Changes');
            },
            error: function(xhr, exception){
                $.notify({
                    title: " ",
                    message: "<i class='fa fa-exclamation-triangle'></i>&nbsp<small>"+xhr.responseJSON.messag
                },{
                    type: "danger",
                    animate: {
                        enter: 'animated fadeIn',
                        exit: 'animated fadeOut'
                    },  
                });

                $("#btn-save-smtp-email").prop("disabled", false);
                $("#btn-save-smtp-email").html('Save Changes');
            }
        });
    });

    
    $("#smtp_password_form").validate({
        onkeyup: false,
        rules:{
         
            newSmtpPassword:{
                required: true,
            },
            confirmSmtpPassword:{
                required: true,
                equalTo: "#newSmtpPassword"
            }
        },
        messages:{
            newSmtpPassword:{
                required: "<i class='fa fa-exclamation-circle'></i> Provide new password",
                minlength: "<i class='fa fa-exclamation-circle'></i> Password must be at least 8 characters"
            },
            confirmSmtpPassword:{
                required: "<i class='fa fa-exclamation-circle'></i> Please re-type password",
                equalTo: "<i class='fa fa-exclamation-circle'></i> Password doesn't match"
            }
        },
        tooltip_options:{
            newSmtpPassword:{
                trigger: 'focus',
                placement: 'right',
                html: true,
            },
            confirmSmtpPassword:{
                trigger: 'focus',
                placement: 'right',
                html: true,
            }
        },
        submitHandler:function(form){
            var password = $("input[name=newSmtpPassword]").val();

            $("#btn-save-smtp-password").append('<i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only">Saving...</span>');
            $("#btn-save-smtp-password").prop("disabled", true);

            $.ajax({
                type:"POST",
                url: App.apiUrl +"/admin/smtp_acct",
                dataType: "JSON",
                data:{password:password},
                success:function(data){
                    $.notify({
                        title: " ",
                        message: "<i class='fa fa-check-circle'></i> "+data.message,

                    },{
                        type: "success",
                        delay: 2000,
                        animate: {
                            enter: 'animated fadeIn',
                            exit: 'animated fadeOut'
                        }
                    });

                    $("#smtp_password_form")[0].reset();
                    $("#btn-save-smtp-password").prop("disabled", false);
                    $("#btn-save-smtp-password").html('Save Changes');
                },
                error: function(xhr, exception){
                    $.notify({
                        title: " ",
                        message: "<i class='fa fa-exclamation-triangle'></i>&nbsp<small>"+xhr.responseJSON.messag
                    },{
                        type: "danger",
                        animate: {
                            enter: 'animated fadeIn',
                            exit: 'animated fadeOut'
                        },  
                    });

                    $("#btn-save-smtp-password").prop("disabled", false);
                    $("#btn-save-smtp-password").html('Save Changes');
                }
            });
        }
    });
 });	