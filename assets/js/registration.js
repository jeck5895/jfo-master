 $(function () {  

 	var path = window.location.pathname;
 	var seg = path.split('/');
 	var pathUrl = window.location.protocol + "//" + window.location.host + "/" + seg[1];
 	var boolean = false;
 	var bool_dimension = false;
 	
 	function guid() {
	    function _p8(s) {
	        var p = (Math.random().toString(16) + "000000000").substr(2, 8);
	        return s ? "-" + p.substr(0, 4) + "-" + p.substr(4, 4) : p;
	    }
	    var guid = _p8() + _p8(true) + _p8(true) + _p8();
	    return guid.toUpperCase();
	}

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

 	function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#company-logo-preview').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('input[name=termsCondition], #terms-condition').change(function(){
        if(!(this.checked)){

            $.notify({
                icon: "fa fa-exclamation-triangle",
                title: " ",
                message: "You must agree to Terms and Condition of the site",
            },{
                type: "info",
                delay: 1400,
                animate: {
                    enter: 'animated fadeIn',
                    exit: 'animated fadeOut'
                },
            });

            $('input[name=register-applicant]').prop('disabled',true);
            $('input[name=register-employer]').prop('disabled',true);
        }
        else{
            console.log('checked');
            $('input[name=register-applicant]').prop('disabled',false);
            $('input[name=register-employer]').prop('disabled',false);
        }
    });
 	
 	$("#applicant-registration-form").validate({

 		rules:{
 			firstname:{
                required: true
            },
            lastname:{
                required:true
            },
            birth_month:{
                required: true
            },
            birth_date:{
                required: true
            },
            birth_year:{
            	required: true,
                remote:{
                    url: pathUrl + '/authenticate/validate',
                    type: "post",
                    data: {
                        birth_year: function() {
                            return $("select[name=birth_year] option:selected").val();
                        },
                        action: function(){
                            return "validate_age";
                        }    
                    }  
                }
            },
            "permanent-address":{
            	required: true
            },
            email:{
            	required: true,
            	email: true,
            	remote:{                        
                    url: pathUrl + '/authenticate/validate',
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
                    url: pathUrl + '/authenticate/validate',
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
         	educAttainment:{
         		required: true
         	},
         	workExp:{
         		required: true
         	},
         	jobCategory:{
         		required: true
         	},
 		},
 		messages:{
 			firstname:{
 				required: " First name is required"
 			},
 			lastname:{
 				required: " Last name is required"
 			},
            birth_month:{
                required: " Birth month is required"
            },
            birth_date:{
                required: " Birth date is required"
            },
 			birth_year:{
 				required: " Birth year is required",
                remote:" Age must be at least 15 and above"
 			},
 			
 			"permanent-address":{
 				required: " Region/City field is required"
 			},
 			email:{
 				required: " Email is required",
 				email: " Please enter a valid email",
 				remote:" This email is already in used"
 			},
 			phonenumber:{
 				required: " Phone number is required",
 				remote:" This number is already in used"
 			},
 			password:{
 				required: " Password is required",
 				minlength: "<i class'fa fa-exclamation-circle'></i> Password is at least 8 characters"
 			},
 			confirmPassword:{
 				required: " Please re-type your password",
 				equalTo: " Password doesn't match"
 			},
 			educAttainment:{
         		required: " Educational Attainment is required"
         	},
         	workExp:{
         		required: " Work Experience is required"
         	},
         	jobCategory:{
         		required: " Please specify your desired field"
         	},

 		},
 		tooltip_options:{
           	firstname:{
                trigger: 'focus',
                placement: 'top',
                html: true,
            },
            lastname:{
                trigger: 'focus',
                placement: 'top',
                html: true,
            },
            birth_month:{
               trigger: 'focus',
               placement: 'top',
               html: true,
            },
            birth_date:{
                trigger: 'focus',
                placement: 'top',
                html: true,
            },
            birth_year:{
                trigger: 'focus',
                placement: 'right',
                html: true,
            },
            
            "permanent-address":{
                trigger: 'focus',
                placement: 'top',
                html: true,
            },
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
            educAttainment:{
                trigger: 'focus',
                placement: 'left',
                html: true,
            },
            workExp:{
                trigger: 'focus',
                placement: 'right',
                html: true,
            },
            jobCategory:{
                trigger: 'focus',
                placement: 'left',
                html: true,
            }
        },
        submitHandler:function(form)
        {
        	var firstname = $("#applicant-registration-form input[name = firstname]").val();
        	var middlename = $("#applicant-registration-form input[name = middlename]").val();
        	var lastname = $("#applicant-registration-form input[name = lastname]").val();
        	var birth_date = $("select[name=birth_date]").val();
            var birth_year = $("select[name=birth_year]").val();
            var birth_month = $("select[name=birth_month]").val();
        	var street = $("#applicant-registration-form input[name=street]").val();
        	var region_id = $("input[name = region_id]").val();
        	var city_id = $("input[name = city_id]").val();
        	var email = $("#applicant-registration-form input[name = email]").val();
        	var phonenumber = $("#applicant-registration-form input[name=phonenumber]").val();
        	var password = $("#applicant-registration-form input[name = password]").val();
        	var educAttainment = $("#applicant-registration-form select[name=educAttainment] option:selected" ).val();
        	var workExp = $( "#applicant-registration-form select[name=workExp] option:selected" ).val();
        	var jobCategory = $("#applicant-registration-form select[name=jobCategory] option:selected" ).val();
        	var jobRole = $("#job-role").val();
        	var infoCondition = $("input[name = infoCondition]:checked").val();
        	var hearAboutUs = $("input[name = hearAboutUs]:checked").val();
        	var form_token  = $("input[name = token]").val();

        	
            $("#register-applicant").prop("disabled", true);
            $("#register-applicant").append('<center><i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only">Registering Account...</span></center>');

            
            $.ajax({
                type: "POST",
                url: pathUrl + "/api/applicants/",
                dataType: "JSON",
                data:{
                    form_token: form_token,
                    firstname : $.trim(firstname),
                    middlename : $.trim(middlename),
                    lastname : $.trim(lastname),
                    birth_date: birth_date,
                    birth_year: birth_year,
                    birth_month: birth_month,
                    street: $.trim(street),
                    region_id: region_id,
                    city_id: city_id,
                    email: $.trim(email),
                    phonenumber: $.trim(phonenumber),
                    password: $.trim(password),
                    educAttainment:educAttainment,
                    workExp:workExp,
                    jobCategory:jobCategory,
                    jobRole:jobRole,
                    infoCondition:infoCondition,
                    hearAboutUs:hearAboutUs,
                },
                success:function(data){

                    $("#register-applicant").prop("disabled", false);
                    $("#register-applicant").html("Register");
                    $("#applicant-registration-form")[0].reset();

                    window.location = data.redirect;
                    

                },
                error:function(){
                    $("#register-applicant").prop("disabled", false);
                    $("#register-applicant").html("Register");
                }
            });
        }
 	});

 	$("#employer-registration-form").validate({
 		rules:{
 			company_name:{
 				required: true,
 				remote:{                        
                    url: pathUrl + '/authenticate/validate',
                    type: "post",
                    data: {
                        company_name: function() {
                            return $("input[name=company_name]").val();
                        },
                        action: function(){
                            return "validate_company_name";
                        }    
                    }
                }
 			},
 			company_industry:{
 				required: true
 			},
 			street_address:{
 				required: true
 			},
 			"permanent-address":{
 				required: true
 			},
 			company_description:{
 				required: true
 			},
 			first_name:{
 				required: true
 			},
 			lastname:{
 				required: true
 			},
 			position:{
 				required: true
 			},
 			department:{
 				required: true
 			},
 			email:{
 				required: true,
 				email: true,
 				remote:{                        
                    url: pathUrl + '/authenticate/validate',
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
                    url: pathUrl + '/authenticate/validate',
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
            confirm_password:{
            	required: true,
            	equalTo: "#password"
            },
 		},
 		messages:{
 			company_name:{
 				required: " What's the name of your company?",
 				remote: " This name is already  exists."
 			},
 			company_industry:{
 				required: "  What's the industry of your company?"
 			},
 			street_address:{
 				required: " Street address is required"
 			},
 			"permanent-address":{
 				required: " Company address is required"
 			},
 			company_description:{
 				required: " Company description is required"
 			},
 			first_name:{
 				required: " Contact Person's First name is required"
 			},
 			lastname:{
 				required: " Contact Person's Last name is required"
 			},
 			position:{
 				required: " Contact Person's position is required"
 			},
 			department:{
 				required: " Contact Person's department is required"
 			},
 			email:{
 				required: " Contact Person's email is required",
 				email : " Please enter a valid email",
 				remote: " This email is already in used"
 			},
 			phonenumber:{
 				required: " Contact Person's phone number is required",
 				remote:" This number is already in used"
 			},
 			password:{
 				required: " Password is required",
 				minlength: " Password is at least 8 characters."
 			},
 			confirm_password:{
 				required : " Please re-type your password",
 				equalTo: " Password doesn't match"
 			}
 		},
 		tooltip_options:{
           	company_name:{
                trigger: 'focus',
                placement: 'left',
                html: true,
            },
            company_industry:{
                trigger: 'focus',
                placement: 'right',
                html: true,
            },
            street_address:{
                trigger: 'focus',
                placement: 'left',
                html: true,
            },
            "permanent-address":{
                trigger: 'focus',
                placement: 'left',
                html: true,
            },
            company_description:{
                trigger: 'focus',
                placement: 'left',
                html: true,
            },
            first_name:{
                trigger: 'focus',
                placement: 'left',
                html: true,
            },
            lastname:{
                trigger: 'focus',
                placement: 'right',
                html: true,
            },
            position:{
                trigger: 'focus',
                placement: 'left',
                html: true,
            },
            department:{
                trigger: 'focus',
                placement: 'bottom',
                html: true,
            },
            email:{
                trigger: 'focus',
                placement: 'left',
                html: true,
            },
            phonenumber:{
                trigger: 'focus',
                placement: 'right',
                html: true,
            },
            password:{
                trigger: 'focus',
                placement: 'left',
                html: true,
            },
            confirm_password:{
                trigger: 'focus',
                placement: 'right',
                html: true,
            },
        },
        submitHandler:function(form){
        	var inputFile = $('input[name = userfile]');
        	var company_name = $("input[name=company_name]").val();
        	var company_industry = $("select[name = company_industry] option:selected").val();
        	var street_address = $("input[name = street_address]").val();
        	var region_id = $("input[name = region_id]").val();
        	var city_id = $("input[name = city_id]").val();
        	var company_description = $("textarea[name=company_description]").val();
        	var firstname = $("input[name = first_name]").val();
        	var middlename = $("input[name = middlename]").val();
        	var lastname  = $("input[name = lastname]").val();
        	var position = $("input[name = position]").val();
        	var department = $("input[name = department]").val();
        	var area_code = $("input[name = area-code]").val();
        	var landline = $("input[name = landline]").val();
        	var email = $("input[name = email]").val();
        	var phonenumber = $("input[name = phonenumber]").val();
        	var password = $("input[name = password]").val();
        	var recaptcha = grecaptcha.getResponse();
        	var form_token = $("input[name = token]").val();
        	
        	if(inputFile.val() != "")
        	{
        		if(recaptcha == "")
        		{
        			$(".g-recaptcha").tooltip({
        				title: " It seems like your a robot!",
        				html: true,
        				placement: "left"
        			});
        			$(".g-recaptcha").tooltip("show");
        		}
        		else
        		{
        			$.ajax({
        				url: pathUrl+"/authenticate/validate",
        				type: "POST",
        				dataType: "JSON",
        				data:{
        					recaptcha: recaptcha,
        					action: "validate_recaptcha"
        				},
        				success: function(data){
        					console.log(data.success);
        					
        					$("#register-employer").prop("disabled", true);
        					$("#register-employer").append('<i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only">Saving...</span>');
        					
        					if(data.success == true){
        						var fileToUpload = inputFile[0].files[0];
        						var formData = new FormData();

        						formData.append('form_token', form_token);
        						formData.append('company_name' , company_name);
        						formData.append('company_industry', company_industry);
        						formData.append('street_address', street_address);
        						formData.append('region_id' , region_id);
        						formData.append('city_id', city_id);
        						formData.append('company_description', company_description);
        						formData.append('firstname', firstname);
        						formData.append('middlename', middlename);
        						formData.append('lastname', lastname);
        						formData.append('position', position);
        						formData.append('department', department);
        						formData.append('area_code', area_code);
        						formData.append('landline', landline);
        						formData.append('email', email);
        						formData.append('phonenumber', phonenumber);
        						formData.append('password', password);
        						formData.append('userfile', fileToUpload); 

        						$.ajax({
        							url: pathUrl+'/api/companies/',
        							type: 'POST',
        							data: formData,
        							processData: false,
        							contentType: false,
        							success: function(data){

        								console.log(data);
        								if(data.status == true)
        								{
        									$.notify({
        										title: " ",
        										message: "<i class='fa fa-check-circle'></i> "+data.message,

        									},{
        										type: "success",
        										delay: 5000,
        										animate: {
        											enter: 'animated fadeIn',
        											exit: 'animated fadeOut'
        										},
        										onClose: function(){
        											setTimeout(function() {
        												window.location = pathUrl+'/login/';
        											}, 500);
        										}
        									});
        								}
        							},
        							error: function(){
        								console.log("error")
        							}
        						});             
        					}
        					else{
        						$(".g-recaptcha").tooltip({
        							title: " It says you're a robot!",
        							html: true,
        							placement: "left"
        						});
        						$(".g-recaptcha").tooltip("show");  
        					}   
        				}
        			}); 		
        		}
			}
			else{
				$(".bootstrap-filestyle input").tooltip({
					title: " Company Logo is required",
                    html: true,
                    placement: "left"
				});
				$(".bootstrap-filestyle input").tooltip("show");
				$('html, body').animate({
					scrollTop: $("input[name = userfile]").offset().top
				}, 1000);
			}
        }    
 	});

 	var width = 0;
 	var height = 0;
 	
 	$("input[name = userfile]").on("change", function(){ 
 		var mime = $(this)[0].files[0].type;
 		var type = mime.split("/");
 		var size = $(this)[0].files[0].size;
 		var input = $(this);	
 		var image = $("#company-logo-preview")[0];

 		
 	
 		if(type[0] == "image" && size <= 200000)
 		{
 			readURL(this);
 			boolean = true;
 		}
 		else{
 			if(type[0] != "image"){
 				$.notify({
 					title: "<h6><i class='fa fa-exclamation-triangle'></i> Please upload valid image</h6>",
 					message: "",
 					target: "_blank"
 				},{
 					type: "danger"
 				});
 				input.val("");
 				$("#company-logo-preview").attr("src","");
 				// /$(this).closest('.form-group').addClass('has-danger');
 			}
 			else if(size > 200000)
 			{
 				$.notify({
 					title: "",
 					message: "<i class='fa fa-exclamation-triangle'></i>Image Size too large",
 					target: "_blank"
 				},{
 					type: "danger"
 				});
 				input.val("");
 				$("#company-logo-preview").attr("src","");
 			}
 		}

 		image.onload = function(){  
 			
 			
 			if((this.naturalWidth < 150 || this.naturalWidth > 200) && (this.naturalHeight < 150 || this.naturalHeight > 200))
 			{
 				$("#company-logo-preview").attr("src","");
 				input.val("");
 				$(".bootstrap-filestyle input").val("");
 				$.notify({
 					title: "",
 					message: "<i class='fa fa-exclamation-triangle'></i> &nbsp&nbspImage Dimension is at least 150 PIXELS to 200 PIXELS",
 					target: "_blank"
 				},{
 					type: "danger",
 				});	
 			}
 		}

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
	}, jQuery.validator.format("<p style='text-align:justify; text-justify: inter-word;'> Please complete the field</p>"));

 });    