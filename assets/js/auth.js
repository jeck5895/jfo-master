$(function (){
	var path = window.location.pathname;
 	var seg = path.split('/');
	var App = {
        pathUrl : window.location.protocol + "//" + window.location.host + "/" + seg[1],
        apiUrl : window.location.protocol + "//" + window.location.host +"/"+seg[1]+"/api"
    }


    $('#login-form').submit(function(e){
    	e.preventDefault();
    	var username = $('input[name=username]').val();
    	var password = $('input[name=password]').val();
    	var formToken = $('input[name=token]').val();
        var urlParam = window.location.search;
        var data = {};

        if(urlParam != "")
        {
            var temp = urlParam.split("?");
            var redirect_arr = temp[1].split("=");
            var redirect = redirect_arr[0];

            data = {
                username: username,
                password: password,
                form_token: formToken,
                redirect: redirect_arr[1]
            } 
            
        }
        else{
            data = {
                username: username,
                password: password,
                form_token: formToken,
            } 
        }

    	$.ajax({
    		type: "POST",
    		url: App.apiUrl + "/auth",
    		dataType: "JSON",
    		data:data,
    		success:function(data){
                if(data.status == true){
                    window.location = data.redirect;
                }
    		},
    		error:function(jqXHR, exception){
    			$.notify({
    				title: " ",
    				message: "<h6><i class='fa fa-exclamation-triangle'></i>&nbsp<small>"+jqXHR.responseJSON.message+"</small></h6> ",
    				allow_dismiss:false,
    				delay: 35000

    			},{
    				type: "danger",
                    animate: {
                        enter: 'animated fadeIn',
                        exit: 'animated fadeOut'
                    },	
    			});
    		}
    	});
    });

    $("#recovery-form").submit(function(e){
        e.preventDefault();

        var email = $("input[name=email]").val();
        var formToken = $('input[name=token]').val();

        $("input[name=btn-confirm-email]").prop("disabled", true);
        
        $.ajax({
            type:"POST",
            url: App.apiUrl + "/auth/validate",
            data:{email:email,form_token:formToken},
            success:function(data){
                $.notify({
                    title: " ",
                    message: "<i class='fa fa-check-circle'></i>&nbsp"+data.message,

                },{
                    type: "success",
                    animate: {
                        enter: 'animated fadeIn',
                        exit: 'animated fadeOut'
                    },
                });
                $("input[name=btn-confirm-email]").prop("disabled", false);
                $("#recovery-form")[0].reset();
            },
            error:function(jqXHR, exception){
                $.notify({
                    title: " ",
                    message: "<i class='fa fa-exclamation-triangle'></i>&nbsp"+jqXHR.responseJSON.message,
                    allow_dismiss:false,
                    delay: 35000

                },{
                    type: "danger",
                    animate: {
                        enter: 'animated fadeIn',
                        exit: 'animated fadeOut'
                    },  
                });

                $("input[name=btn-confirm-email]").prop("disabled", false);
            }
        });
    });

    $("#change-password-form").validate({
        onkeyup: false,
        rules:{
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
            
            var newPassword = $("input[name=newPassword").val();
            var formToken = $('input[name=token]').val();
            var urlParam = window.location.search;
            var temp = urlParam.split("?");
            var code_arr = temp[1].split("=");
            var code = code_arr[1];
            
            $("#btn-reset-password").prop("disabled", true);
            $("#btn-reset-password").append('<i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only">Saving...</span>');
            
            $.ajax({
                type: "POST",
                url: App.apiUrl +'/auth/resetpassword',
                dataType: "json",
                data:
                {
                    password: newPassword,
                    code: code,
                    form_token: formToken
                },
                success: function (data) {
                  
                    $.notify({
                        title: " ",
                        message: "<i class='fa fa-exclamation-triangle'></i>&nbsp"+data.message,

                    },{
                        type: "success",
                        animate: {
                            enter: 'animated fadeIn',
                            exit: 'animated fadeOut'
                        },
                        onClose: function(){
                            setTimeout(function() {
                                window.location = App.pathUrl+"/login";
                            }, 500);
                        }
                    });
                        
                    $("#change-password-form")[0].reset();
                    $("#btn-reset-password").prop('disabled',false);
                    $("#btn-reset-password").html('Save Changes');
                   
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

                    $("#change-password-form")[0].reset();
                    $("#btn-reset-password").prop('disabled',false);
                    $("#btn-reset-password").html('Save Changes');
                }
            });
        }
    });
});